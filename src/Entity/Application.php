<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Enum\ApplicationStatusEnum;
use App\Model\ApplicationDTO;
use App\Repository\ApplicationRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'application')]
class Application
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: InternshipOffer::class)]
    #[ORM\JoinColumn(name: 'offer_id', referencedColumnName: 'id')]
    private InternshipOffer $offer;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    private Student $student;

    #[ORM\Column(type: Types::STRING, enumType: ApplicationStatusEnum::class, options: ['default' => ApplicationStatusEnum::PENDING])]
    private string $status = ApplicationStatusEnum::PENDING;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

