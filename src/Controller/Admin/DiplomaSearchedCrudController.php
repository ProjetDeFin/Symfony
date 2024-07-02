<?php

namespace App\Controller\Admin;

use App\Entity\DiplomaSearched;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DiplomaSearchedCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DiplomaSearched::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom du diplôme recherché'),
        ];
    }
}

