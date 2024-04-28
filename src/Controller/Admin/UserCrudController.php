<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = [
            'Etudiant' => 'ROLE_STUDENT',
            'Super Admin' => 'ROLE_SUPER_ADMIN',
            'Responsable d\'entreprise' => 'ROLE_COMPANY_RESPONSIBLE',
        ];

        $civilities = [
            'M.' => 'M.',
            'Mme' => 'Mme',
            'Autres' => 'Autres',
        ];

        $passwordField = TextField::new('password', 'Password')
            ->hideOnIndex();

        if ($pageName === Crud::PAGE_EDIT || $pageName === Crud::PAGE_NEW) {
            $passwordField->setFormType(PasswordType::class);
        }

        return [
            IdField::new('id')->hideOnForm(), // Hide ID in form as it's not typically editable
            ChoiceField::new('civility', 'Genre')
                ->setChoices($civilities),
            TextField::new('firstname', 'First Name'),
            TextField::new('name', 'Last Name'),
            EmailField::new('email', 'Email'),
            ChoiceField::new('roles', 'Roles')
                ->allowMultipleChoices()
                ->setChoices($roles),
            $passwordField,
            BooleanField::new('enabled', 'Enabled')
        ];
    }
}

