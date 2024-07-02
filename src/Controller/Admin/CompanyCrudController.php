<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom de l\'entreprise'),
            TextField::new('socialReason', 'Raison sociale'),
            TextField::new('address1', 'Adresse')->hideOnIndex(),
            TextField::new('zipCode', 'Code postal'),
            TextField::new('city', 'Ville'),
            TextField::new('country', 'Pays')->hideOnIndex(),
            IntegerField::new('siret', 'Numéro SIRET'),
            TextField::new('workforce', 'Effectif'),
            NumberField::new('sellFigure', 'Chiffre d\'affaires')->setNumDecimals(2),
            DateField::new('creation', 'Date de création'),
            TextField::new('phone', 'Numéro de téléphone'),
            EmailField::new('email', 'Adresse email'),
            UrlField::new('websiteUrl', 'URL du site web')->hideOnIndex(),
            TextField::new('fax', 'Numéro de fax')->hideOnIndex(),
            UrlField::new('linkedinUrl', 'URL LinkedIn')->hideOnIndex(),
            UrlField::new('facebookUrl', 'URL Facebook')->hideOnIndex(),
            UrlField::new('instagramUrl', 'URL Instagram')->hideOnIndex(),
            UrlField::new('xUrl', 'Autre URL')->hideOnIndex(),
            ImageField::new('logo', 'Logo de l\'entreprise')->setBasePath('uploads/logo')->setUploadDir('public/uploads/logo'),
            AssociationField::new('sectors', 'Secteurs')->hideOnIndex(),
            AssociationField::new('categories', 'Catégories')->hideOnIndex(),
        ];
    }
}
