<?php

namespace App\Controller;

use App\Repository\ApplicationRepository;
use App\Repository\CompanyRepository;
use App\Repository\InternshipOfferRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function index(SerializerInterface $serializer): Response {
        $companies = $this->companyRepository->findAll();
        $applications = $this->applicationRepository->findAll();
        $internshipOffers = $this->internshipOfferRepository->findAll();

        $homeResponse = [
            'companies' => $companies,
            'applications' => $applications,
            'offers' => $internshipOffers,
        ];

        $jsonContent = $serializer->serialize($homeResponse, 'json', ['groups' => 'home']);

        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }

}
