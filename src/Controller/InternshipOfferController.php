<?php

namespace App\Controller;

use App\Repository\InternshipOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/account/offers', name: 'offers_')]
class InternshipOfferController extends AbstractController
{
    public function __construct(
        private readonly InternshipOfferRepository $internshipOfferRepository,
        private readonly SerializerInterface       $serializer
    )
    {
    }

    #[Route(path: '/', name: 'list', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
    ): Response
    {
        $filters = $request->get('filters');
        $order = $request->get('order');
        $orderBy = $request->get('orderBy');
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        $internshipOffers = $this->internshipOfferRepository->findByFilter($filters, $order, $orderBy, $page, $limit);

        $jsonContent = $this->serializer->serialize($internshipOffers, 'json', ['groups' => 'internship_offer']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }

    #[Route(path: '/{id}', name: 'show', methods: ['GET'])]
    public function show(
        int $id
    ): Response
    {
        $internshipOffer = $this->internshipOfferRepository->find($id);

        $jsonContent = $this->serializer->serialize($internshipOffer, 'json', ['groups' => 'internship_offer']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }
}
