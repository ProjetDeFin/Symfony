<?php

namespace App\Controller;

use App\Service\ApiResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_jwt_')]
class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        UserProviderInterface $userProvider,
        UserPasswordHasherInterface $passwordHasher,
        ApiResponseService $apiResponseService,
    ): JsonResponse
    {
        $response = $apiResponseService->getResponse();
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $user = $userProvider->loadUserByIdentifier($email);
        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            $response->setData(['error' => 'Invalid credentials']);
            return $response;
        }
        return $response;
    }
}
