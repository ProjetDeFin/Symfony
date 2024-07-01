<?php

namespace App\Model;

use App\Entity\Category;
use App\Entity\Company;
use App\Enum\UserGenderEnum;
use App\Repository\CategoryRepository;
use App\Repository\CompanyRepository;
use App\Repository\SectorRepository;

class CompanyRegisterDTO {
    private string $function;
    private string $phone;
    private string $companyName;
    private string $siret;
    private array $categories = [];
    private array $sectors = [];
    private string $address;
    private string $addressComplement;
    private string $zipCode;
    private string $city;
    private string $companyPhone;

    public function __construct(
        array $data,
        CompanyRepository $companyRepository,
        CategoryRepository $categoryRepository,
        SectorRepository $sectorRepository,
    ) {
        $function = $data['position'];
        $phone = $data['mobile'];
        $companyName = $data['companyName'];
        $siret = $data['siret'];
        $categories = $data['categories'];
        $sectors = $data['sectors'];
        $address = $data['address'];
        $addressComplement = $data['addressComplement'];
        $zipCode = $data['zipCode'];
        $city = $data['city'];
        $companyPhone = $data['companyPhone'];

        if (!$function || !$phone || !$companyName || !$siret || !$categories || !$sectors || !$address || !$zipCode || !$city || !$companyPhone) {
            throw new \InvalidArgumentException('Function, phone, company name, siret, category, sector, address, zip code, city and company phone are required');
        }

        if (!is_numeric($phone) || strlen($phone) !== 10) {
            throw new \InvalidArgumentException("The provided phone number is not a valid.");
        }

        if (!is_numeric($companyPhone) || strlen($companyPhone) !== 10) {
            throw new \InvalidArgumentException("The provided company phone number is not a valid.");
        }

        if (!is_numeric($zipCode) || strlen($zipCode) !== 5) {
            throw new \InvalidArgumentException("The provided zip code number is not a valid.");
        }

        $company = $companyRepository->findOneBy(['siret' => $siret]);
        if (null !== $company) {
            throw new \InvalidArgumentException('Company already exists');
        }

        foreach ($categories as $category) {
            if (!is_numeric($category)) {
                throw new \InvalidArgumentException("The provided category id is not a valid.");
            }
            $category = $categoryRepository->find($category);
            if (null === $category) {
                throw new \InvalidArgumentException('Category not found');
            }
            $this->categories[] = $category;
        }

        foreach ($sectors as $sector) {
            if (!is_numeric($sector)) {
                throw new \InvalidArgumentException("The provided sector id is not a valid.");
            }
            $sector = $sectorRepository->find($sector);
            if (null === $sector) {
                throw new \InvalidArgumentException('Sector not found');
            }
            $this->sectors[] = $sector;
        }

        $this->function = $function;
        $this->phone = $phone;
        $this->companyName = $companyName;
        $this->siret = $siret;
        $this->address = $address;
        $this->addressComplement = $addressComplement;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->companyPhone = $companyPhone;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getSectors(): array
    {
        return $this->sectors;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getAddressComplement(): string
    {
        return $this->addressComplement;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCompanyPhone(): string
    {
        return $this->companyPhone;
    }
}
