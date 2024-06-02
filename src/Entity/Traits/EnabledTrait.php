<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EnabledTrait
{
    #[ORM\Column(type: 'boolean', options: ['default' => false])]
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
