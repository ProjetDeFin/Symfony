<?php

namespace App\Entity;

use App\Entity\Traits\EnabledTrait;
use App\Entity\Traits\SoftDeleteTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\InternshipOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InternshipOfferRepository::class)]
#[ORM\Table(name: 'internship_offer')]
class InternshipOffer
{
    use TimestampableTrait;
    use SoftDeleteTrait;
    use EnabledTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    #[Groups(['internship_offer',  'internship_offers', 'company', 'home'])]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['internship_offer', 'home', 'company', 'internship_offers'])]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['internship_offer', 'home', 'company', 'internship_offers'])]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'internshipOffers')]
    #[Groups(['home'])]
    private ?Company $company = null;

    #[ORM\ManyToMany(targetEntity: JobProfile::class, mappedBy: 'internshipOffer')]
    #[Groups(['internship_offer', 'home', 'company', 'internship_offers'])]
    private Collection $jobProfiles;

    #[ORM\ManyToMany(targetEntity: DiplomaSearched::class, mappedBy: 'internshipOffer')]
    #[Groups(['internship_offer', 'company'])]
    private Collection $diplomasSearched;

    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'offer')]
    #[Groups(['internship_offer', 'internship_offers'])]
    private Collection $applications;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startApplyDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endApplyDate = null;

    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'internshipOffers')]
    #[Groups(['internship_offer', 'company', 'internship_offers'])]
    private Collection $skills;

    #[ORM\Column(length: 255)]
    #[Groups(['internship_offer', 'internship_offers', 'company', 'home', 'companies'])]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: Mission::class, mappedBy: 'internshipOffer')]
    #[Groups(['internship_offer', 'company', 'internship_offers'])]
    private Collection $missions;

    #[ORM\OneToMany(targetEntity: DesiredProfile::class, mappedBy: 'internshipOffer')]
    #[Groups(['internship_offer', 'company', 'internship_offers'])]
    private Collection $desiredProfiles;

    public function __construct()
    {
        $this->jobProfiles = new ArrayCollection();
        $this->diplomasSearched = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->desiredProfiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, JobProfile>
     */
    public function getJobProfiles(): Collection
    {
        return $this->jobProfiles;
    }

    public function addJobProfile(JobProfile $jobProfile): static
    {
        if (!$this->jobProfiles->contains($jobProfile)) {
            $this->jobProfiles->add($jobProfile);
            $jobProfile->addInternshipOffer($this);
        }

        return $this;
    }

    public function removeJobProfile(JobProfile $jobProfile): static
    {
        if ($this->jobProfiles->removeElement($jobProfile)) {
            $jobProfile->removeInternshipOffer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, DiplomaSearched>
     */
    public function getDiplomasSearched(): Collection
    {
        return $this->diplomasSearched;
    }

    public function addDiplomaSearched(DiplomaSearched $diplomaSearched): static
    {
        if (!$this->diplomasSearched->contains($diplomaSearched)) {
            $this->diplomasSearched->add($diplomaSearched);
            $diplomaSearched->addInternshipOffer($this);
        }

        return $this;
    }

    public function removeDiplomaSearched(DiplomaSearched $diplomaSearched): static
    {
        if ($this->diplomasSearched->removeElement($diplomaSearched)) {
            $diplomaSearched->removeInternshipOffer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setOffer($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            $application->setOffer(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->addInternshipOffer($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeInternshipOffer($this);
        }

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getEndApplyDate(): ?\DateTimeImmutable
    {
        return $this->endApplyDate;
    }

    public function setEndApplyDate(\DateTimeImmutable $endApplyDate): static
    {
        $this->endApplyDate = $endApplyDate;

        return $this;
    }

    public function getStartApplyDate(): ?\DateTimeImmutable
    {
        return $this->startApplyDate;
    }

    public function setStartApplyDate(\DateTimeImmutable $startApplyDate): static
    {
        $this->startApplyDate = $startApplyDate;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyLogo(): ?string
    {
        return $this->company->getLogo();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyName(): ?string
    {
        return $this->company->getName();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyCity(): ?string
    {
        return $this->company->getCity();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getRestDay(): ?string
    {
        return $this->startApplyDate->diff($this->endApplyDate)->format('%a');
    }

    #[Groups(['internship_offers', 'company', 'internship_offer'])]
    public function getPeriod(): ?string
    {
        return $this->startAt->format('d/m/Y') . ' - ' . $this->endAt->format('d/m/Y');
    }

    #[Groups(['internship_offers', 'company', 'internship_offer'])]
    public function getDuration(): ?string
    {
        return $this->startAt->diff($this->endAt)->format('%a');
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getFormatedEndApplyDate(): string
    {
        return $this->endApplyDate->format('d/m/Y');
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getFormatedStartApplyDate(): string
    {
        return $this->startApplyDate->format('d/m/Y');
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getFormatedStartAt(): string
    {
        return $this->startAt->format('d/m/Y');
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getFormatedEndAt(): string
    {
        return $this->endAt->format('d/m/Y');
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyDescription(): string
    {
        return $this->company->getDescription();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyId(): string
    {
        return $this->company->getId();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyLat(): float
    {
        return $this->company->getLatitude();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyLng(): float
    {
        return $this->company->getLongitude();
    }

    #[Groups(['internship_offers', 'internship_offer'])]
    public function getCompanyPhotos(): array
    {
        return $this->company->getPhotos();
    }

    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): static
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setInternshipOffer($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): static
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getInternshipOffer() === $this) {
                $mission->setInternshipOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DesiredProfile>
     */
    public function getDesiredProfiles(): Collection
    {
        return $this->desiredProfiles;
    }

    public function addDesiredProfile(DesiredProfile $desiredProfile): static
    {
        if (!$this->desiredProfiles->contains($desiredProfile)) {
            $this->desiredProfiles->add($desiredProfile);
            $desiredProfile->setInternshipOffer($this);
        }

        return $this;
    }

    public function removeDesiredProfile(DesiredProfile $desiredProfile): static
    {
        if ($this->desiredProfiles->removeElement($desiredProfile)) {
            // set the owning side to null (unless already changed)
            if ($desiredProfile->getInternshipOffer() === $this) {
                $desiredProfile->setInternshipOffer(null);
            }
        }

        return $this;
    }
}
