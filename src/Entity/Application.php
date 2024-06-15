<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Enum\ApplicationStatusEnum;
use App\Enum\TypeEnum;
use App\Model\ApplicationDTO;
use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'application')]
class Application
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['application'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: InternshipOffer::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(name: 'offer_id', referencedColumnName: 'id')]
    #[Groups(['application'])]
    private InternshipOffer $offer;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[Ignore]
    #[Groups(['application', 'home'])]
    private Student $student;

    #[ORM\Column(type: Types::STRING, enumType: ApplicationStatusEnum::class, options: ['default' => ApplicationStatusEnum::PENDING])]
    #[Groups(['application', 'home'])]
    private ApplicationStatusEnum $status;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['application', 'home'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['application', 'home'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['application', 'home'])]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(type: Types::STRING, enumType: TypeEnum::class, options: ['default' => TypeEnum::INTERNSHIP])]
    #[Groups(['application', 'home'])]
    private ?TypeEnum $type = null;

    // Méthodes publiques pour accéder aux propriétés

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffer(): ?InternshipOffer
    {
        return $this->offer;
    }

    public function setOffer(?InternshipOffer $offer): static
    {
        $this->offer = $offer;
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

    public function getStatus(): ApplicationStatusEnum
    {
        return $this->status;
    }

    public function setStatus(ApplicationStatusEnum $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getType(): ?TypeEnum
    {
        return $this->type;
    }

    public function setType(?TypeEnum $type): static
    {
        $this->type = $type;
        return $this;
    }

    public static function fromDTO(ApplicationDTO $dto, Student $student, InternshipOffer $offer): static
    {
        $application = new static();
        $application
            ->setOffer($offer)
            ->setStudent($student)
            ->setStatus(ApplicationStatusEnum::PENDING)
        ;
        return $application;
    }
}
