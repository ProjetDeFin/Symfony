<?php

namespace App\Controller\Admin;

use App\Entity\JobProfile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobProfile::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom du profil de poste'),
            TextField::new('color', 'Couleur'),
        ];
    }
}

