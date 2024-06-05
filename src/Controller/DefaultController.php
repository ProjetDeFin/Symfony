<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\Student;
use App\Model\ApplicationDTO;
use App\Repository\ApplicationRepository;
use App\Repository\CompanyRepository;
use App\Repository\InternshipOfferRepository;
use App\Repository\ResetPasswordRepository;
use App\Repository\StudentRepository;
use App\Service\ApiResponseService;
use App\Service\BrevoMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Application;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

#[Route('/api/home', name: 'home_')]
class DefaultController extends AbstractController
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly ApplicationRepository $applicationRepository,
        private readonly InternshipOfferRepository $internshipOfferRepository,
    ) {
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response {
        $homeResponse = [
            'companies' => $this->companyRepository->findHome(),
            'applications' => $this->applicationRepository->findHome(),
            'internshipOffers' => $this->internshipOfferRepository->findHome(),
        ];

        return $this->json($homeResponse, 200, [], ['groups' => 'company']);
    }
}
