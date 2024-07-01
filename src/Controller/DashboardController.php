<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/account', name: 'api_')]
class DashboardController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route(path: '/profile', name: 'profile', methods: ['GET'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
    ): JsonResponse
    {
        $data = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $data);
        $user = $userRepository->findOneBy(['apiToken' => $token]);
        $serialized = $this->serializer->serialize($user, 'json', ['groups' => 'user']);

        return new JsonResponse($serialized, 200, ['Content-Type' => 'application/json']);
    }
}
