<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait AddressTrait
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company', 'companies', 'home', 'internship_offer'])]
    protected ?string $address1 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company', 'internship_offer'])]
    protected ?string $address2 = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company', 'companies', 'home', 'internship_offer'])]
    protected ?string $city = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company', 'companies'])]
    protected ?string $zipCode = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company'])]
    protected ?string $country = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company'])]
    protected ?float $latitude = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['company'])]
    protected ?float $longitude = null;

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): static
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(string $address2): static
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }
}
