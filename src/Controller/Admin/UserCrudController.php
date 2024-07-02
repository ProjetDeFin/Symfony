<?php

namespace App\Controller\Admin;

use App\Entity\CompanyResponsible;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
        private readonly AdminUrlGenerator $adminUrlGenerator,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = [
            'Étudiant' => 'ROLE_STUDENT',
            'Super Admin' => 'ROLE_SUPER_ADMIN',
            'Responsable d\'entreprise' => 'ROLE_COMPANY_RESPONSIBLE',
        ];

        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('civility', 'Genre'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastName', 'Nom de famille'),
            EmailField::new('email', 'Email'),
            ChoiceField::new('roles', 'Rôles')->allowMultipleChoices()->setChoices($roles),
            TextField::new('password', 'Mot de passe')->hideOnIndex()->hideOnForm(),
            BooleanField::new('enabled', 'Activé'),
            ImageField::new('picture', 'L\'avatar')->setBasePath('uploads/profil-picture')->setUploadDir('public/uploads/profil-picture'),
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && in_array('ROLE_SUPER_ADMIN', $entityInstance->getRoles())) {
            if ($entityInstance->getId() === $this->getUser()->getId()) {
                $this->addFlash('warning', 'Vous ne pouvez pas vous supprimer vous-même.');
                return;
            }

            $superAdminCount = $entityManager->getRepository(User::class)->count(['roles' => 'ROLE_SUPER_ADMIN']);
            if ($superAdminCount <= 1) {
                $this->addFlash('warning', 'Vous ne pouvez pas supprimer le dernier super administrateur.');
                return;
            }
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $password = $entityInstance->getPassword();
        if ($password !== null && $password !== '') {
            $entityInstance->setPassword($this->hasher->hashPassword($entityInstance, $password));
        } else {
            $existingUser = $entityManager->getRepository(User::class)->find($entityInstance->getId());
            if ($existingUser !== null) {
                $entityInstance->setPassword($existingUser->getPassword());
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
