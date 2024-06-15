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
use Symfony\Component\Serializer\Annotation\MaxDepth;

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
    #[Groups(['internship_offer'])]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Groups(['internship_offer', 'home'])]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['internship_offer', 'home'])]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'internshipOffers')]
    #[Groups(['internship_offer', 'home'])]
    private ?Company $company = null;

    /**
     * @var Collection<int, JobProfile>
     */
    #[ORM\ManyToMany(targetEntity: JobProfile::class, mappedBy: 'internshipOffer')]
    #[Groups(['internship_offer', 'home'])]
    private Collection $jobProfiles;

    /**
     * @var Collection<int, DiplomaSearched>
     */
    #[ORM\ManyToMany(targetEntity: DiplomaSearched::class, mappedBy: 'internshipOffer')]
    #[Groups(['internship_offer', 'home'])]
    private Collection $diplomaSearcheds;

    #[ORM\Column]
    #[Groups(['internship_offer', 'home'])]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    #[Groups(['internship_offer', 'home'])]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    #[Groups(['internship_offer', 'home'])]
    private ?\DateTimeImmutable $endApplyDate = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'internshipOffers')]
    #[Groups(['internship_offer', 'home'])]
    private Collection $skill;

    #[ORM\Column(length: 255)]
    #[Groups(['internship_offer', 'home'])]
    private ?string $type = null;

    public function __construct()
    {
        $this->jobProfiles = new ArrayCollection();
        $this->diplomaSearcheds = new ArrayCollection();
        $this->skill = new ArrayCollection();
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

    public function setCompany(Company $company): static
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
    public function getDiplomaSearcheds(): Collection
    {
        return $this->diplomaSearcheds;
    }

    public function addDiplomaSearched(DiplomaSearched $diplomaSearched): static
    {
        if (!$this->diplomaSearcheds->contains($diplomaSearched)) {
            $this->diplomaSearcheds->add($diplomaSearched);
            $diplomaSearched->addInternshipOffer($this);
        }

        return $this;
    }

    public function removeDiplomaSearched(DiplomaSearched $diplomaSearched): static
    {
        if ($this->diplomaSearcheds->removeElement($diplomaSearched)) {
            $diplomaSearched->removeInternshipOffer($this);
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

    /**
     * @return Collection<int, Skill>
     */
    public function getSkill(): Collection
    {
        return $this->skill;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skill->contains($skill)) {
            $this->skill->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->skill->removeElement($skill);

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
}
