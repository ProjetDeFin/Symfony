<?php

namespace App\Entity;

use App\Repository\JobProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: JobProfileRepository::class)]
class JobProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['home', 'internship_offer', 'internship_offers'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home', 'internship_offer', 'internship_offers'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['home', 'internship_offer', 'internship_offers'])]
    private ?string $color = null;

    /**
     * @var Collection<int, InternshipOffer>
     */
    #[ORM\ManyToMany(targetEntity: InternshipOffer::class, inversedBy: 'jobProfiles')]
    private Collection $internshipOffer;

    public function __construct()
    {
        $this->internshipOffer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, InternshipOffer>
     */
    public function getInternshipOffer(): Collection
    {
        return $this->internshipOffer;
    }

    public function addInternshipOffer(InternshipOffer $internshipOffer): static
    {
        if (!$this->internshipOffer->contains($internshipOffer)) {
            $this->internshipOffer->add($internshipOffer);
        }

        return $this;
    }

    public function removeInternshipOffer(InternshipOffer $internshipOffer): static
    {
        $this->internshipOffer->removeElement($internshipOffer);

        return $this;
    }
}
