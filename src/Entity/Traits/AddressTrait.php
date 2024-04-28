<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait AddressTrait
{
    #[ORM\Column(type: 'string', length: 255)]
    protected bool $address1 = false;

    #[ORM\Column(type: 'string', length: 255)]
    protected bool $address2 = false;

    #[ORM\Column(type: 'string', length: 255)]
    protected bool $city = false;

    #[ORM\Column(type: 'string', length: 255)]
    protected bool $zipCode = false;

    #[ORM\Column(type: 'string', length: 255)]
    protected bool $country = false;

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
}
