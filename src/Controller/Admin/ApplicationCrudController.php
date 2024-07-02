<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('offer', 'Offre de stage'),
            AssociationField::new('student', 'Étudiant'),
            ChoiceField::new('status', 'Statut'),
            TextField::new('title', 'Titre'),
            DateField::new('startAt', 'Date de début'),
            DateField::new('endAt', 'Date de fin'),
            ChoiceField::new('type', 'Type'),
        ];
    }
}

