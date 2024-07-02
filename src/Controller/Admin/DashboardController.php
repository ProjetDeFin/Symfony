<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use App\Entity\Category;
use App\Entity\Company;
use App\Entity\CompanyResponsible;
use App\Entity\DiplomaSearched;
use App\Entity\Hobby;
use App\Entity\InternshipOffer;
use App\Entity\JobProfile;
use App\Entity\Language;
use App\Entity\LanguageStudent;
use App\Entity\ProfesionalExperience;
use App\Entity\Sector;
use App\Entity\Skill;
use App\Entity\Student;
use App\Entity\StudyLevel;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('build/images/favicon.ico')
            ->renderContentMaximized()
            ->disableUrlSignatures();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Profile', 'fas fa-user', 'admin?crudAction=edit&crudControllerFqcn=App\Controller\Admin\UserCrudController&entityId=' . $this->getUser()->getId());
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Management');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Students', 'fas fa-user-graduate', Student::class);
        yield MenuItem::linkToCrud('Companies', 'fas fa-building', Company::class);
        yield MenuItem::linkToCrud('Applications', 'fas fa-file-alt', Application::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Diplomas Searched', 'fas fa-graduation-cap', DiplomaSearched::class);
        yield MenuItem::linkToCrud('Hobbies', 'fas fa-gamepad', Hobby::class);
        yield MenuItem::linkToCrud('Internship Offers', 'fas fa-briefcase', InternshipOffer::class);
        yield MenuItem::linkToCrud('Job Profiles', 'fas fa-clipboard', JobProfile::class);
        yield MenuItem::linkToCrud('Languages', 'fas fa-language', Language::class);
        yield MenuItem::linkToCrud('Professional Experiences', 'fas fa-briefcase', ProfesionalExperience::class);
        yield MenuItem::linkToCrud('Sectors', 'fas fa-industry', Sector::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-tools', Skill::class);
        yield MenuItem::linkToCrud('Study Levels', 'fas fa-graduation-cap', StudyLevel::class);
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt');
    }
}
