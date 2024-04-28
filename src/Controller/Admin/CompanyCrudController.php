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

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // It's good practice to hide ID on forms
            TextField::new('name', 'Company Name'),
            TextField::new('socialReason', 'Social Reason')->hideOnIndex(),
            IntegerField::new('siret', 'SIRET Number'),
            TextField::new('workforce', 'Workforce'),
            NumberField::new('sellFigure', 'Sell Figure')->setNumDecimals(2),
            DateField::new('creation', 'Creation Date'),
            TextField::new('phone', 'Phone Number'),
            EmailField::new('email', 'Email Address'),
            UrlField::new('websiteUrl', 'Website URL')->hideOnIndex(),
            TextField::new('fax', 'Fax Number')->hideOnIndex(),
            UrlField::new('linkedinUrl', 'LinkedIn URL')->hideOnIndex(),
            UrlField::new('facebookUrl', 'Facebook URL')->hideOnIndex(),
            UrlField::new('instagramUrl', 'Instagram URL')->hideOnIndex(),
            UrlField::new('xUrl', 'Other URL')->hideOnIndex(),
        ];
    }

}
