<?php

namespace App\Entity\Traits;

use App\Entity\Admin;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait BlameableTrait
{
    #[ORM\JoinColumn(name: 'created_by_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: Admin::class)]
    #[Gedmo\Blameable(on: 'create')]
    protected ?Admin $createdBy = null;

    #[ORM\JoinColumn(name: 'updated_by_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: Admin::class)]
    #[Gedmo\Blameable(on: 'update')]
    protected ?Admin $updatedBy = null;

    public function getCreatedBy(): ?Admin
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Admin $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?Admin
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?Admin $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
