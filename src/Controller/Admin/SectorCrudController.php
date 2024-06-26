<?php

namespace App\Controller\Admin;

use App\Entity\Sector;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SectorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sector::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom du secteur'),
            TextField::new('color', 'Couleur'),
        ];
    }
}

