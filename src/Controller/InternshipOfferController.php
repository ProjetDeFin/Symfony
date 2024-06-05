<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\Student;
use App\Model\ApplicationDTO;
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

#[Route('/api/offers', name: 'applications_')]
class InternshipOfferController extends AbstractController
{
    public function __construct(
        private readonly InternshipOfferRepository $internshipOfferRepository,
    ) {
    }
    #[Route(path: '/', name: 'list', methods: ['GET'])]
    public function index(
        Request $request,
    ): Response {
        $filters = $request->get('filters');
        $order = $request->get('order');
        $orderBy = $request->get('orderBy');

        if ($request->get('page')) {
            $page = $request->get('page');
            $internshipOffers = $this->internshipOfferRepository->findByFilter($filters, $order, $orderBy, $page);
        } else {
            $internshipOffers = $this->internshipOfferRepository->findByFilter($filters, $order, $orderBy);
        }

        return $this->json($internshipOffers);
    }

    #[Route(path: '/{id}', name: 'show', methods: ['GET'])]
    public function show(
        int $id
    ): Response
    {
        $internshipOffer = $this->internshipOfferRepository->find($id);
        return $this->json($internshipOffer);
    }

    #[Route(path: '/home', name: 'homeList', methods: ['GET'])]
    public function homeList(): Response
    {
        $internshipOffer = $this->internshipOfferRepository->findHome();
        return $this->json($internshipOffer);
    }
}
