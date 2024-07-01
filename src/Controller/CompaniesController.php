<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
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
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route(path: '/', name: 'list_companies', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        CompanyRepository $companyRepository,
        SerializerInterface $serializer
    ): Response {
        $filters = json_decode($request->get('filters'), true);
        $order = $request->get('order');
        $orderBy = $request->get('orderBy');
        $page = json_decode($request->get('page', 1), true);
        $limit = json_decode($request->get('limit', 10), true);
        $companies = $this->companyRepository->findByFilter($filters, $order, $orderBy, $page, $limit);

        $jsonContent = $serializer->serialize($companies, 'json', ['groups' => 'companies']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }

    #[Route(path: '/{id}', name: 'show_company', methods: ['GET'])]
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
