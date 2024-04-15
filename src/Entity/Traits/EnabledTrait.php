<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EnabledTrait
{
    #[ORM\Column(type: 'boolean')]
    protected bool $enabled = false;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }
}
