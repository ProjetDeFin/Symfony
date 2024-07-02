<?php

namespace App\Controller\Admin;

use App\Entity\ProfesionalExperience;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfesionalExperienceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProfesionalExperience::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('companyName', 'Nom de l\'entreprise'),
            TextField::new('position', 'Poste'),
            TextField::new('description', 'Description'),
            AssociationField::new('student', 'Étudiant'),
            DateField::new('startAt', 'Date de début'),
            DateField::new('endAt', 'Date de fin')->hideOnIndex(),
        ];
    }
}
