<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\EnabledTrait;
use App\Entity\Traits\SoftDeleteTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Model\CompanyRegisterDTO;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'company')]
class Company
{
    use TimestampableTrait;
    use SoftDeleteTrait;
    use EnabledTrait;
    use AddressTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['company', 'companies', 'home', 'internship_offer', 'internship_offers'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Groups(['company', 'companies','home', 'internship_offer', 'internship_offers'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['company', 'companies'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $socialReason = null;

    #[ORM\Column(type: Types::BIGINT, unique: true)]
    #[Groups(['company'])]
    private ?int $siret = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $workforce = null;

    #[ORM\Column(type: TYPES::FLOAT, options: ['default' => 0])]
    #[Groups(['company'])]
    private float $sellFigure = 0;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['company', 'home'])]
    private ?\DateTimeInterface $creation = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company', 'companies', 'home', 'internship_offer',  'internship_offers'])]
    private ?string $logo = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['internship_offer'])]
    private ?string $photo1 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['internship_offer'])]
    private ?string $photo2 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['internship_offer'])]
    private ?string $photo3 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $detail1 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $detail2 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $detail3 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $detail4 = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $detail5 = null;

    #[ORM\Column(type: Types::STRING, unique: true)]
    #[Groups(['company'])]
    private ?string $phone = null;

    #[ORM\Column(type: Types::STRING, unique: true, nullable: true)]
    #[Groups(['company'])]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $websiteUrl = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $fax = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company', 'internship_offer'])]
    private ?string $linkedinUrl = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $facebookUrl = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $instagramUrl = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['company'])]
    private ?string $xUrl = null;

    /**
     * @var Collection<int, Sector>
     */
    #[ORM\ManyToMany(targetEntity: Sector::class, inversedBy: 'company')]
    #[Groups(['company', 'companies'])]
    private Collection $sectors;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'companies')]
    #[Groups(['company', 'companies'])]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: InternshipOffer::class, mappedBy: 'company')]
    #[Groups(['company', 'companies'])]
    private Collection $internshipOffers;

    public function __construct()
    {
        $this->sectors = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->internshipOffers = new ArrayCollection();
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

    /**
     * @return Collection<int, Sector>
     */
    public function getSectors(): Collection
    {
        return $this->sectors;
    }

    public function addSector(Sector $sector): static
    {
        if (!$this->sectors->contains($sector)) {
            $this->sectors->add($sector);
            $sector->addCompany($this);
        }

        return $this;
    }

    public function removeSector(Sector $sector): static
    {
        if ($this->sectors->removeElement($sector)) {
            $sector->removeCompany($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addCompany($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeCompany($this);
        }

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
            $internshipOffer->setCompany($this);
        }

        return $this;
    }

    public function removeInternshipOffer(InternshipOffer $internshipOffer): static
    {
        if ($this->internshipOffers->removeElement($internshipOffer)) {
            $internshipOffer->setCompany(null);
        }

        return $this;
    }

    public static function fromDTO(CompanyRegisterDTO $companyRegisterDTO): self
    {
        $company = new self();
        $company->setName($companyRegisterDTO->getCompanyName());
        $company->setSiret($companyRegisterDTO->getSiret());
        $company->setPhone($companyRegisterDTO->getCompanyPhone());
        $company->setAddress1($companyRegisterDTO->getAddress());
        $company->setAddress2($companyRegisterDTO->getAddressComplement());
        $company->setZipCode($companyRegisterDTO->getZipCode());
        $company->setCity($companyRegisterDTO->getCity());
        $company->addCategory($companyRegisterDTO->getCategory());
        $company->addSector($companyRegisterDTO->getSector());

        return $company;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    #[Groups(['company'])]
    public function getAge(): int
    {
        return $this->creation->diff(new \DateTime())->y;
    }

    public function getPhoto1(): ?string
    {
        return $this->photo1;
    }

    public function setPhoto1(string $photo1): static
    {
        $this->photo1 = $photo1;

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(string $photo2): static
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(string $photo3): static
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getDetail1(): ?string
    {
        return $this->detail1;
    }

    public function setDetail1(string $detail1): static
    {
        $this->detail1 = $detail1;

        return $this;
    }

    public function getDetail2(): ?string
    {
        return $this->detail2;
    }

    public function setDetail2(string $detail2): static
    {
        $this->detail2 = $detail2;

        return $this;
    }

    public function getDetail3(): ?string
    {
        return $this->detail3;
    }

    public function setDetail3(string $detail3): static
    {
        $this->detail3 = $detail3;

        return $this;
    }

    public function getDetail4(): ?string
    {
        return $this->detail4;
    }

    public function setDetail4(string $detail4): static
    {
        $this->detail4 = $detail4;

        return $this;
    }

    public function getDetail5(): ?string
    {
        return $this->detail5;
    }

    public function setDetail5(string $detail5): static
    {
        $this->detail5 = $detail5;

        return $this;
    }

    public function getPhotos(): array
    {
        return [$this->photo1, $this->photo2, $this->photo3];
    }
}
