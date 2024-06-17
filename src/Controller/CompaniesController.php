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
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/companies', name: 'applications_')]
class CompaniesController extends AbstractController
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: '/api/companies', name: 'list', methods: ['POST'])]
    public function index(
        Request $request,
        CompanyRepository $companyRepository,
        SerializerInterface $serializer
    ): Response {
        $filters = json_decode($request->getContent(), true)['filters'];
        $order = json_decode($request->getContent(), true)['order'];
        $orderBy = json_decode($request->getContent(), true)['orderBy'];
        $page = json_decode($request->getContent(), true)['page'];
        $limit = json_decode($request->getContent(), true)['limit'];

        $companies = $companyRepository->findByFilter($filters, $order, $orderBy, $page, $limit);

        $jsonContent = $serializer->serialize($companies, 'json', ['groups' => 'companies']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }

    #[Route(path: '/{id}', name: 'show', methods: ['GET'])]
    public function show(
        int $id,
    ): Response {
        $company = $this->companyRepository->find($id);

        if (!$company) {
            return new Response('Company not found', 404);
        }

        $jsonContent = $this->serializer->serialize($company, 'json', ['groups' => 'company']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }
}
