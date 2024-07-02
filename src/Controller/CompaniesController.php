<?php

namespace App\Controller;

use App\Entity\CompanyResponsible;
use App\Repository\CategoryRepository;
use App\Repository\CompanyRepository;
use App\Repository\CompanyResponsibleRepository;
use App\Repository\SectorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/companies', name: 'applications_')]
class CompaniesController extends AbstractController
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly SerializerInterface $serializer,
        private readonly SectorRepository $sectorRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly CompanyResponsibleRepository $companyResponsibleRepository,
    ) {
    }

    #[Route(path: '/', name: 'list_companies', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
    ): Response {
        $filters = json_decode($request->get('filters'), true);
        $order = $request->get('order');
        $orderBy = $request->get('orderBy');
        $page = json_decode($request->get('page', 1), true);
        $limit = json_decode($request->get('limit', 10), true);
        $companies = $this->companyRepository->findByFilter($filters, $order, $orderBy, $page, $limit);

        $companies = [
            'companies' => $companies,
            'sectors' => $this->sectorRepository->findAll(),
            'categories' => $this->categoryRepository->findAll()
        ];

        $jsonContent = $this->serializer->serialize($companies, 'json', ['groups' => 'companies']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }

    #[Route(path: '/{id}', name: 'show_company', methods: ['GET'])]
    public function show(
        int $id,
    ): Response {
        $company = $this->companyRepository->find($id);
        $companyResponsables = $this->companyResponsibleRepository->findBy(['company' => $company]);

        $company = [
            'company' => $company,
            'contacts' => $companyResponsables,
        ];

        $jsonContent = $this->serializer->serialize($company, 'json', ['groups' => 'company']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }
}
