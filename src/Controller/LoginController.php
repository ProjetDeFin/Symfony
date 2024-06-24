<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ApiResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $JWTTokenManager,
        ApiResponseService $apiResponseService,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $response = $apiResponseService->getResponse();

        $email = $request->get('email');
        $password = $request->get('password');

        if (!$email || !$password) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setData(['error' => 'Email and password are required']);
            return $response;
        }

        $user = $userRepository->findOneBy(['email' => $email]);
        if (null === $user || !$passwordHasher->isPasswordValid($user, $password)) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'Invalid credentials']);
            return $response;
        }
        $token = $JWTTokenManager->create($user);

        $user->setApiToken($token);

        $entityManager->persist($user);
        $entityManager->flush();

        // Return token in the response
        $response->setStatusCode(Response::HTTP_OK);
        $response->setData(['token' => $token]);
        return $response;
    }
}
