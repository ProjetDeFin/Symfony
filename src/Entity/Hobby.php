<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\HobbyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HobbyRepository::class)]
#[ORM\Table(name: 'hobby')]
class Hobby
{
    use TimestampableTrait;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['hobby', 'home'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['hobby', 'home'])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'hobbies')]
    #[Groups(['hobby'])]
    private ?Student $student = null;

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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
