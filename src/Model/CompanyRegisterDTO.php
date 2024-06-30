<?php

namespace App\Model;

use App\Enum\UserGenderEnum;

class CompanyRegisterDTO {
    private string $function;
    private string $phone;
    private string $companyName;
    private string $siret;
    // TODO activity sector
    private CompanyCategory $category;

}
