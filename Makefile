COMPOSE=docker-compose -f docker-compose.yml
COMPOSE_MAC=$(COMPOSE) -f docker-compose-sync.yml
EXEC=$(COMPOSE) exec app
EXEC_TTY=$(COMPOSE) exec -T app
CONSOLE=$(EXEC) bin/console
ENVIRONMENT=$(shell bash ./scripts/get-env.sh)
SHELL := /bin/bash
MUTAGEN_NAME=$(shell bash ./scripts/get-mutagen-name.sh)

.PHONY: start up perm db cc ssh vendor assets assets-watch stop rm
.PHONY: maintenance-on maintenance-off

start: up perm vendor db cc perm

up:
	docker kill $$(docker ps -q) || true
ifeq ($(ENVIRONMENT),Mac)
	$(COMPOSE_MAC) build --force-rm
	$(COMPOSE_MAC) up -d
	bash ./scripts/start-macos.sh
else
	$(COMPOSE) build --force-rm
	$(COMPOSE) up -d
endif

stop:
ifeq ($(ENVIRONMENT),Mac)
	$(COMPOSE_MAC) stop
	$(COMPOSE_MAC) kill
	mutagen sync pause $(MUTAGEN_NAME)
else
	$(COMPOSE) stop
	$(COMPOSE) kill
endif

rm:
	make stop
ifeq ($(ENVIRONMENT),Mac)
	$(COMPOSE_MAC) rm
	mutagen sync terminate $(MUTAGEN_NAME)
else
	$(COMPOSE) rm
endif

vendor: wait-for-db
	$(EXEC) composer install -n
	$(EXEC) yarn install --pure-lockfile
	make perm

ssh:
	$(EXEC) bash

run:
	$(EXEC) $(c)

sf:
	$(EXEC) bin/console $(c)

# Databases
db: wait-for-db
	$(EXEC) bin/console doctrine:database:drop --if-exists --force
	$(EXEC) rm -rf public/uploads/*
	$(EXEC) bin/console doctrine:database:create --if-not-exists
	$(EXEC) bin/console doctrine:schema:update --force
	#$(EXEC) bin/console doctrine:fixtures:load --append -n

db-migrate:
	$(EXEC) bin/console doctrine:migration:migrate

# Assets
assets:
	$(EXEC) bin/console assets:install
	$(EXEC) yarn run encore dev

assets-watch:
	$(EXEC) bin/console assets:install
	$(EXEC) yarn watch

# Permission
perm:
	$(EXEC) mkdir -p public/uploads
	$(EXEC) mkdir -p public/media
	$(EXEC) mkdir -p var/log && $(EXEC) mkdir -p var/cache
ifeq ($(ENVIRONMENT),Linux)
	sudo chown -R $(USER):$(USER) .
	sudo chown -R www-data:$(USER) ./var public/uploads public/media
	sudo chmod -R g+rwx .
else
	$(EXEC) chown -R www-data:root var/ public/uploads public/media
endif

# Cache
cc:
	$(EXEC) bin/console c:cl --no-warmup
	$(EXEC) bin/console c:warmup

# Fixer
php-cs-fixer:
	sh -c "COMPOSE_INTERACTIVE_NO_CLI=1 $(EXEC_TTY) php-cs-fixer fix --config=.php-cs-fixer.php"
	sh -c "COMPOSE_INTERACTIVE_NO_CLI=1 $(EXEC_TTY) php-cs-fixer fix -v --dry-run  --config=.php-cs-fixer.php"

# Tests
tf: wait-for-db
	$(EXEC) vendor/bin/behat

tfdev: wait-for-db
	$(EXEC) vendor/bin/behat --tags=dev

tu: wait-for-db
	$(EXEC) vendor/bin/phpunit --stop-on-failure

# Update prod
update-prod:
	# Set maintenance to on
	make maintenance-on
	# Fetch updates
	git pull origin master
	# Clear cache
	bin/console c:cl --no-warmup
	# Install dependencies
	composer install --classmap-authoritative --no-interaction --no-scripts --no-ansi --no-dev
	# Install font for DOMPDF
	php scripts/load_font.php 'Arial' public/pdf/arial.ttf public/pdf/b_arial.ttf
	# Build JS + CSS files
	bin/console assets:install
	yarn build
	# Update Database
	bin/console doctrine:migrations:migrate --no-interaction
	bin/console c:warmup
	cp robots/robots-allow.txt public/robots.txt
	# Update cronjobs
	rm -f var/cron/crontab.backup
	mkdir -p var/cron
	crontab -l > var/cron/crontab.backup || true
	crontab cron/prod
	# Set maintenance to off
	make maintenance-off

# Update feature
update-feature:
	# Set maintenance to on
	make maintenance-on
	# Clear cache
	bin/console c:cl --no-warmup
	# Install dependencies
	composer install --classmap-authoritative --no-interaction --no-scripts --no-ansi --no-dev
	# Install font for DOMPDF
	php scripts/load_font.php 'Arial' public/pdf/arial.ttf public/pdf/b_arial.ttf
	# Build JS + CSS files
	bin/console assets:install
	yarn install --pure-lockfile --prod
	yarn build
	# Update Database
	bin/console doctrine:migrations:migrate --no-interaction
	bin/console c:warmup
	cp robots/robots-allow.txt public/robots.txt
	# Update cronjobs
	rm -f var/cron/crontab.backup
	mkdir -p var/cron
	crontab -l > var/cron/crontab.backup || true
	crontab cron/preprod
	# Set maintenance to off
	make maintenance-off

maintenance-on:
ifeq ($(shell test -e public/index.php.old && echo -n yes),yes)
	@echo "Maintenance is already enabled."
else
	mv public/index.php public/index.php.old
	cp public/maintenance.html public/index.php
	@echo "Maintenance is enabled."
endif

maintenance-off:
ifeq ($(shell test -e public/index.php.old && echo -n yes),yes)
	mv public/index.php.old public/index.php
endif

# Wait commands
wait-for-db:
	$(EXEC) php -r "set_time_limit(60);for(;;){if(@fsockopen(\"db\",3306)){break;}echo \"Waiting for DB\n\";sleep(1);}"
