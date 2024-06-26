<?php

namespace App\Controller;

use App\Repository\InternshipOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/offers', name: 'offers_')]
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
        $filters = json_decode($request->get('filters'), true);
        $order = $request->get('order');
        $orderBy = $request->get('orderBy', 'title');
        $page = json_decode($request->get('page', 1), true);
        $limit = json_decode($request->get('limit', 10), true);

        $internshipOffers = $this->internshipOfferRepository->findByFilter($filters, $order, $orderBy, $page, $limit);

        $jsonContent = $this->serializer->serialize($internshipOffers, 'json', ['groups' => 'internship_offers']);
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

    #[Route(path: '/last-offer/{id}', name: 'last-offer', methods: ['GET'])]
    public function lastOffer(
        int $id
    ): Response
    {
        $internshipOffer = $this->internshipOfferRepository->find($id);

        $jsonContent = $this->serializer->serialize($internshipOffer, 'json', ['groups' => 'internship_offer']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }
}
