<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StudentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('user', 'Utilisateur'),
            DateField::new('birthday', 'Date de naissance'),
            TextField::new('mobile', 'Numéro de téléphone mobile'),
            TextField::new('schoolName', 'Nom de l\'école'),
            AssociationField::new('profesionalExperiences', 'Expériences professionnelles')->hideOnIndex(),
            AssociationField::new('hobbies', 'Loisirs')->hideOnIndex(),
            AssociationField::new('skills', 'Compétences')->hideOnIndex(),
            AssociationField::new('studyLevel', 'Niveau d\'études')->hideOnIndex(),
            AssociationField::new('diplomasSearched', 'Niveau de diplome')->hideOnIndex(),
        ];
    }
}
