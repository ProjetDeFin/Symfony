<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Model\ApplicationDTO;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table(name: '`student`')]
class Student
{
    use TimestampableTrait;
    use AddressTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTime $birthday;

    #[ORM\Column(type: Types::STRING, length: 10)]
    private ?string $mobile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $customCurriculumVitae = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $photo = null;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'student')]
    private Collection $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): static
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getCustomCurriculumVitae(): ?string
    {
        return $this->customCurriculumVitae;
    }

    public function setCustomCurriculumVitae(string $customCurriculumVitae): static
    {
        $this->customCurriculumVitae = $customCurriculumVitae;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public static function fromApplicationDTO(ApplicationDTO $applicationDTO): Student
    {
        $user = new User();
        $user
            ->setEmail($applicationDTO->getEmail())
            ->setFirstname($applicationDTO->getFirstname())
            ->setLastName($applicationDTO->getLastname())
            ->setCivility($applicationDTO->getGender())
            ->setRoles(['ROLE_USER'])
        ;
        $student = new self();
        $student
            ->setUser($user)
            ->setBirthday($applicationDTO->getBirthDate())
            ->setMobile($applicationDTO->getPhone())
            ->setCustomCurriculumVitae($applicationDTO->getCv())
        ;

        return $student;
    }
}
