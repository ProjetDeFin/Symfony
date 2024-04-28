<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface $entityManager
    ){
    }

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
            TextField::new('password', 'Password')
                ->hideOnIndex()
                ->setFormType(PasswordType::class),
            BooleanField::new('enabled', 'Enabled')
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {


        if ($entityInstance instanceof User && in_array('ROLE_SUPER_ADMIN', $entityInstance->getRoles())) {
            if ($entityInstance->getId() === $this->getUser()->getId()) {
                $this->addFlash('warning', 'Ne peut pas se supprimer.');
                return;
            }

            $superAdminCount = $entityManager->getRepository(User::class)->count(['roles' => 'ROLE_SUPER_ADMIN']);
            if ($superAdminCount <= 1) {
                $this->addFlash('warning', 'Vous ne peut pas supprimer le dernier administrate.');
                return;
            }
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && !empty($entityInstance->getPassword())) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword($entityInstance, $entityInstance->getPassword())
            );
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}

