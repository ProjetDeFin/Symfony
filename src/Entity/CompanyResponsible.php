<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Model\CompanyRegisterDTO;
use App\Repository\CompanyResponsibleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyResponsibleRepository::class)]
#[ORM\Table(name: 'company_responsible')]
class CompanyResponsible
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Company::class)]
    private ?Company $company = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['profile'])]
    private ?string $position = null;

    #[ORM\Column(type: Types::STRING, length: 10)]
    #[Groups(['profile'])]
    private ?string $phone = null;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public static function fromDTO(CompanyRegisterDTO $companyResponsibleDTO, User $user, Company $company): self
    {
        $companyResponsible = new self();
        $companyResponsible->setPosition($companyResponsibleDTO->getFunction());
        $companyResponsible->setPhone($companyResponsibleDTO->getPhone());

        return $companyResponsible;
    }
}
