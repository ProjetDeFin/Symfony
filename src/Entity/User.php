<?php

namespace App\Entity;

use App\Entity\Traits\EnabledTrait;
use App\Entity\Traits\SoftDeleteTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Enum\UserGenderEnum;
use App\Model\ApplicationDTO;
use App\Model\UserRegisterDTO;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    use TimestampableTrait;
    use SoftDeleteTrait;
    use EnabledTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180)]
    #[Groups(['user', 'profile', 'company'])]
    private string $firstname;

    #[ORM\Column(type: Types::STRING, length: 180)]
    #[Groups(['user', 'profile', 'company'])]
    private string $lastName;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['user', 'profile', 'company'])]
    private ?string $picture = null;

    #[ORM\Column(type: Types::STRING, enumType: UserGenderEnum::class)]
    #[Groups(['user', 'profile'])]
    private ?UserGenderEnum $civility = null;

    #[ORM\Column(type: Types::STRING, length: 180)]
    #[Groups(['user', 'profile', 'company'])]
    private string $email;

    #[ORM\Column(type: Types::JSON, options: ['default' => '[]'])]
    private array $roles = [];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: Types::STRING, length: 2048, nullable: true)]
    private ?string $apiToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    #[Groups(['user', 'company'])]
    public function getFullName(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastName();
    }

    public function getCivility(): ?UserGenderEnum
    {
        return $this->civility;
    }

    public function setCivility(UserGenderEnum $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): static
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public static function fromDTO(UserRegisterDTO $userDTO): User
    {
        $user = new self();
        $user
            ->setFirstname($userDTO->getFirstName())
            ->setLastName($userDTO->getLastName())
            ->setEmail($userDTO->getEmail())
            ->setCivility($userDTO->getGender())
            ->setRoles([$userDTO->getRole()])
        ;

        return $user;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }
}
