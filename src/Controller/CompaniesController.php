<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\Student;
use App\Model\ApplicationDTO;
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

#[Route('/api/companies', name: 'applications_')]
class CompaniesController extends AbstractController
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
    ) {
    }

    #[Route(path: '/', name: 'list', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
    ): Response {
        $filters = $request->get('filters');
        $order = $request->get('order');
        $orderBy = $request->get('orderBy');
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $companies = $this->companyRepository->findByFilter($filters, $order, $orderBy, $page, $limit);

        return $this->json($companies);
    }
}
