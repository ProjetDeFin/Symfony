<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['internship_offer', 'internship_offers', 'profile'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['internship_offer', 'internship_offers', 'profile'])]
    private ?string $name = null;

    /**
     * @var Collection<int, InternshipOffer>
     */
    #[ORM\ManyToMany(targetEntity: InternshipOffer::class, inversedBy: 'skills')]
    private Collection $internshipOffers;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'skills')]
    private Collection $student;

    public function __construct()
    {
        $this->internshipOffers = new ArrayCollection();
        $this->student = new ArrayCollection();
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
    public function getInternshipOffers(): Collection
    {
        return $this->internshipOffers;
    }

    public function addInternshipOffer(InternshipOffer $internshipOffer): static
    {
        if (!$this->internshipOffers->contains($internshipOffer)) {
            $this->internshipOffers->add($internshipOffer);
        }

        return $this;
    }

    public function removeInternshipOffer(InternshipOffer $internshipOffer): static
    {
        $this->internshipOffers->removeElement($internshipOffer);

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->student->contains($student)) {
            $this->student->add($student);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        $this->student->removeElement($student);

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
