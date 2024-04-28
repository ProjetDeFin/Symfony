<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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
        $passwordField = TextField::new('password', 'Password')
            ->hideOnIndex();

        if ($pageName === \EasyCorp\Bundle\EasyAdminBundle\Config\Crud::PAGE_EDIT || $pageName === \EasyCorp\Bundle\EasyAdminBundle\Config\Crud::PAGE_NEW) {
            $passwordField->setFormType(PasswordType::class);
        }

        return [
            IdField::new('id')->hideOnForm(), // Hide ID in form as it's not typically editable
            TextField::new('firstname', 'First Name'),
            TextField::new('name', 'Last Name'),
            EmailField::new('email', 'Email'),
            ArrayField::new('roles', 'Roles')
                ->setHelp('Roles assigned to the user, e.g., ROLE_USER, ROLE_ADMIN'),
            $passwordField,
            BooleanField::new('enabled', 'Enabled')
        ];
    }
}

