<?php

namespace App\Entity;

use App\Repository\DiplomaSearchedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DiplomaSearchedRepository::class)]
#[ORM\Table(name: 'diploma_searched')]
class DiplomaSearched
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['internship_offer', 'internship_offers', 'selectsRegisterStudent'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['internship_offer', 'internship_offers', 'selectsRegisterStudent'])]
    private ?string $name = null;

    /**
     * @var Collection<int, InternshipOffer>
     */
    #[ORM\ManyToMany(targetEntity: InternshipOffer::class, inversedBy: 'diplomasSearched')]
    private Collection $internshipOffer;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'diplomasSearched')]
    private Collection $students;


    public function __construct()
    {
        $this->internshipOffer = new ArrayCollection();
        $this->students = new ArrayCollection();
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

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        $this->students->removeElement($student);

        return $this;
    }
}
