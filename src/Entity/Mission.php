<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['internship_offer', 'internship_offers'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['internship_offer', 'internship_offers'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: InternshipOffer::class, inversedBy: 'missions')]
    private ?InternshipOffer $internshipOffer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getInternshipOffer(): ?InternshipOffer
    {
        return $this->internshipOffer;
    }

    public function setInternshipOffer(?InternshipOffer $internshipOffer): self
    {
        $this->internshipOffer = $internshipOffer;

        return $this;
    }
}

