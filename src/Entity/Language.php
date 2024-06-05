<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, LanguageStudent>
     */
    #[ORM\OneToMany(targetEntity: LanguageStudent::class, mappedBy: 'language')]
    private Collection $languageStudents;

    public function __construct()
    {
        $this->languageStudents = new ArrayCollection();
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
     * @return Collection<int, LanguageStudent>
     */
    public function getLanguageStudents(): Collection
    {
        return $this->languageStudents;
    }

    public function addLanguageStudent(LanguageStudent $languageStudent): static
    {
        if (!$this->languageStudents->contains($languageStudent)) {
            $this->languageStudents->add($languageStudent);
            $languageStudent->setLanguage($this);
        }

        return $this;
    }

    public function removeLanguageStudent(LanguageStudent $languageStudent): static
    {
        if ($this->languageStudents->removeElement($languageStudent)) {
            // set the owning side to null (unless already changed)
            if ($languageStudent->getLanguage() === $this) {
                $languageStudent->setLanguage(null);
            }
        }

        return $this;
    }
}
