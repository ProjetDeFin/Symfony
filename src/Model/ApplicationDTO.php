<?php

namespace App\Model;

use App\Enum\UserGenderEnum;

class ApplicationDTO {
    private int $offerId;
    private UserGenderEnum $gender;
    private string $firstName;
    private string $lastName;
    private string $email;
    private \DateTime $birthDate;
    private int $phone;
    private ?string $address;
    private ?string $additionalAddress;
    private ?string $city;
    private ?string $websiteUrl;
    private ?string $linkedinUrl;
    private string $studyLevel;
    private ?string $motivation;
    private ?string $cv;
    private bool $createAccount = false;

    public function __construct(array $data) {
        if (!$data['offerId']) {
            throw new \InvalidArgumentException('Internship offer ID is missing.');
        }
        if (!$data['gender'] || !$data['firstName'] || !$data['lastName'] || !$data['email'] || !$data['phone'] || !$data['birthDate'] || !$data['studyLevel']) {
            throw new \InvalidArgumentException('Required fields are missing.');
        }
        if ($data['email'] !== $data['confirmEmail']) {
            throw new \InvalidArgumentException('Emails do not match.');
        }
        if (!is_numeric($data['phone']) || strlen($data['phone']) !== 10) {
            throw new \InvalidArgumentException("The provided phone number is not a valid.");
        }
        if (!is_numeric($data['studyLevel'])) {
            throw new \InvalidArgumentException("The provided study level is not a valid.");
        }
        if (!is_numeric($data['offerId'])) {
            throw new \InvalidArgumentException("The provided offer ID is not a valid.");
        }
        if (!is_bool($data['createAccount'])) {
            throw new \InvalidArgumentException("The provided value is not a boolean.");
        }
        try {
            $birthDate = new \DateTime($data['birthDate']);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid birth date.');
        }
        $this->offerId = (int)$data['offerId'];
        $this->gender = UserGenderEnum::fromString($data['gender']);
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->email = $data['email'];
        $this->birthDate = $birthDate;
        $this->phone = $data['phone'];
        $this->address = $data['address'] ?? null;
        $this->additionalAddress = $data['additionalAddress'] ?? null;
        $this->city = $data['city'] ?? null;
        $this->websiteUrl = $data['websiteUrl'] ?? null;
        $this->linkedinUrl = $data['linkedinUrl'] ?? null;
        $this->studyLevel = (int)$data['studyLevel'];
        $this->motivation = $data['motivation'] ?? null;
        $this->cv = $data['cv'] ?? null;
        $this->createAccount = $data['createAccount'];
    }

    public function getOfferId(): int {
        return $this->offerId;
    }

    public function setOfferId(int $offerId): static {
        $this->offerId = $offerId;

        return $this;
    }

    public function getGender(): UserGenderEnum
    {
        return $this->gender;
    }

    public function setGender(UserGenderEnum $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function setGenderFromString(string $gender): static
    {
        $this->gender = UserGenderEnum::fromString($gender);

        return $this;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): static {
        $this->email = $email;

        return $this;
    }

    public function getBirthDate(): \DateTime {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): static {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): static {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(string $address): static {
        $this->address = $address;

        return $this;
    }

    public function getAdditionalAddress(): ?string {
        return $this->additionalAddress;
    }

    public function setAdditionalAddress(string $additionalAddress): static {
        $this->additionalAddress = $additionalAddress;

        return $this;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(string $city): static {
        $this->city = $city;

        return $this;
    }

    public function getWebsiteUrl(): ?string {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(string $websiteUrl): static {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getLinkedinUrl(): ?string {
        return $this->linkedinUrl;
    }

    public function setLinkedinUrl(string $linkedinUrl): static {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    public function getStudyLevel(): ?string {
        return $this->studyLevel;
    }

    public function setStudyLevel(string $studyLevel): static {
        $this->studyLevel = $studyLevel;

        return $this;
    }

    public function getMotivation(): ?string {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): static {
        $this->motivation = $motivation;

        return $this;
    }

    public function getCv(): ?string {
        return $this->cv;
    }

    public function setCv(string $cv): static {
        $this->cv = $cv;

        return $this;
    }

    public function getCreateAccount(): bool {
        return $this->createAccount;
    }

    public function setCreateAccount(bool $createAccount): static {
        $this->createAccount = $createAccount;

        return $this;
    }
}
