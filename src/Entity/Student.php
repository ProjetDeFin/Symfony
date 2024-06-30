<?php

namespace App\Entity;

use App\Entity\Traits\AddressTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Model\ApplicationDTO;
use App\Model\StudentRegisterDTO;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table(name: 'student')]
class Student
{
    use TimestampableTrait;
    use AddressTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['home'])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[Groups(['student'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['student'])]
    private \DateTime $birthday;

    #[ORM\Column(type: Types::STRING, length: 10)]
    #[Groups(['student'])]
    private ?string $mobile = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['student'])]
    private ?string $customCurriculumVitae = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['student'])]
    private ?string $photo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['student'])]
    private ?string $motivation = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['student'])]
    private ?string $schoolName = null;

    /**
     * @var Collection<int, ProfesionalExperience>
     */
    #[ORM\OneToMany(targetEntity: ProfesionalExperience::class, mappedBy: 'student')]
    #[Groups(['student'])]
    private Collection $profesionalExperiences;

    /**
     * @var Collection<int, Hobby>
     */
    #[ORM\OneToMany(targetEntity: Hobby::class, mappedBy: 'student')]
    #[Groups(['student'])]
    private Collection $hobbies;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'student')]
    #[Groups(['student'])]
    private Collection $skills;

    #[ORM\ManyToOne(targetEntity: StudyLevel::class, inversedBy: 'students')]
    #[Groups(['student'])]
    private ?StudyLevel $studyLevel = null;

    /**
     * @var Collection<int, DiplomaSearched>
     */
    #[ORM\ManyToMany(targetEntity: DiplomaSearched::class, mappedBy: 'student')]
    #[Groups(['student'])]
    private Collection $diplomasSearched;

    /**
     * @var Collection<int, LanguageStudent>
     */
    #[ORM\OneToMany(targetEntity: LanguageStudent::class, mappedBy: 'student')]
    #[Groups(['student'])]
    private Collection $languageStudents;

    public function __construct()
    {
        $this->profesionalExperiences = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->hobbies = new ArrayCollection();
        $this->diplomasSearched = new ArrayCollection();
        $this->languageStudents = new ArrayCollection();
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

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): static
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getSchoolName(): ?string
    {
        return $this->schoolName;
    }

    public function setSchoolName(string $schoolName): static
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    public function getStudyLevel(): ?StudyLevel
    {
        return $this->studyLevel;
    }

    public function setStudyLevel(?StudyLevel $studyLevel): static
    {
        $this->studyLevel = $studyLevel;

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

    /**
     * @return Collection<int, ProfesionalExperience>
     */
    public function getProfesionalExperiences(): Collection
    {
        return $this->profesionalExperiences;
    }

    public function addProfesionalExperience(ProfesionalExperience $profesionalExperience): static
    {
        if (!$this->profesionalExperiences->contains($profesionalExperience)) {
            $this->profesionalExperiences->add($profesionalExperience);
            $profesionalExperience->setStudent($this);
        }

        return $this;
    }

    public function removeProfesionalExperience(ProfesionalExperience $profesionalExperience): static
    {
        if ($this->profesionalExperiences->removeElement($profesionalExperience)) {
            // set the owning side to null (unless already changed)
            if ($profesionalExperience->getStudent() === $this) {
                $profesionalExperience->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): static
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies->add($hobby);
            $hobby->setStudent($this);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): static
    {
        if ($this->hobbies->removeElement($hobby)) {
            // set the owning side to null (unless already changed)
            if ($hobby->getStudent() === $this) {
                $hobby->setStudent(null);
            }
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
            $skill->addStudent($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeStudent($this);
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
            $diplomaSearched->addStudent($this);
        }

        return $this;
    }

    public function removeDiplomaSearched(DiplomaSearched $diplomaSearched): static
    {
        if ($this->diplomasSearched->removeElement($diplomaSearched)) {
            $diplomaSearched->removeStudent($this);
        }

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
            $languageStudent->setStudent($this);
        }

        return $this;
    }

    public function removeLanguageStudent(LanguageStudent $languageStudent): static
    {
        if ($this->languageStudents->removeElement($languageStudent)) {
            // set the owning side to null (unless already changed)
            if ($languageStudent->getStudent() === $this) {
                $languageStudent->setStudent(null);
            }
        }

        return $this;
    }

    public function fromDTO(StudentRegisterDTO $studentDTO): Student
    {
        $student = new self();
        $student
            ->setMobile($studentDTO->getPhone())
            ->addDiplomaSearched($studentDTO->getDiplomaSearched())
            ->setSchoolName($studentDTO->getSchoolName())
            ->setStudyLevel($studentDTO->getStudyLevel())
        ;

        return $student;
    }
}
