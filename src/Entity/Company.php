<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\EnabledTrait;
use App\Entity\Traits\SoftDeleteTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: '`company`')]
class Company
{
    use TimestampableTrait;
    use SoftDeleteTrait;
    use EnabledTrait;
    use AddressTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private ?string $name = null;

    #[ORM\Column(type: 'string')]
    private ?string $socialReason = null;

    #[ORM\Column(type: 'bigint', unique: true)]
    private ?int $siret = null;

    #[ORM\Column(type: 'string')]
    private ?string $workforce = null;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $sellFigure = 0;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $creation = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(type: 'string', unique: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $websiteUrl = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $fax = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $linkedinUrl = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $facebookUrl = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $instagramUrl = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $xUrl = null;

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

    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    public function setSocialReason(string $socialReason): static
    {
        $this->socialReason = $socialReason;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getWorkforce(): ?string
    {
        return $this->workforce;
    }

    public function setWorkforce(string $workforce): static
    {
        $this->workforce = $workforce;

        return $this;
    }

    public function getSellFigure(): float
    {
        return $this->sellFigure;
    }

    public function setSellFigure(float $sellFigure): static
    {
        $this->sellFigure = $sellFigure;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): static
    {
        $this->creation = $creation;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(string $websiteUrl): static
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): static
    {
        $this->fax = $fax;

        return $this;
    }

    public function getLinkedinUrl(): ?string
    {
        return $this->linkedinUrl;
    }

    public function setLinkedinUrl(string $linkedinUrl): static
    {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    public function setFacebookUrl(string $facebookUrl): static
    {
        $this->facebookUrl = $facebookUrl;

        return $this;
    }

    public function getInstagramUrl(): ?string
    {
        return $this->instagramUrl;
    }

    public function setInstagramUrl(string $instagramUrl): static
    {
        $this->instagramUrl = $instagramUrl;

        return $this;
    }

    public function getXUrl(): ?string
    {
        return $this->xUrl;
    }

    public function setXUrl(string $xUrl): static
    {
        $this->xUrl = $xUrl;

        return $this;
    }
}
