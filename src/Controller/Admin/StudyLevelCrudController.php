<?php

namespace App\Controller\Admin;

use App\Entity\StudyLevel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class StudyLevelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StudyLevel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            IntegerField::new('level', 'Niveau d\'étude'),
        ];
    }
}

