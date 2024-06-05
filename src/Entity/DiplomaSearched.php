<?php

namespace App\Entity;

use App\Repository\DiplomaSearchedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiplomaSearchedRepository::class)]
class DiplomaSearched
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, InternshipOffer>
     */
    #[ORM\ManyToMany(targetEntity: InternshipOffer::class, inversedBy: 'diplomaSearcheds')]
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
