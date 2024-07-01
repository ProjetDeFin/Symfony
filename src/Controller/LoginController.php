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
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if (!$email || !$password) {
            return $this->json(['error' => 'Email and password are required'], Response::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->findOneBy(['email' => $email]);
        if (null === $user || !$passwordHasher->isPasswordValid($user, $password)) {
            return $this->json(['error' => 'Invalid credentials'], Response::HTTP_FORBIDDEN);
        }

        try {
            $token = $JWTTokenManager->createFromPayload($user, [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'id' => $user->getId(),
            ]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while generating the token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user->setApiToken($token);
        $entityManager->persist($user);
        $entityManager->flush();

        // Ensure response includes all necessary data
        $response = new JsonResponse([
            'token' => $token,
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'picture' => $user->getPicture(),
            'id' => $user->getId(),
        ], Response::HTTP_OK);

        // Disable caching
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    // TODO: change this to /account/details/{email} to add security
    #[Route(path: '/login/details/{email}', name: 'details', methods: ['GET'])]
    public function details(
        UserRepository $userRepository,
        ApiResponseService $apiResponseService,
        string $email,
    ): JsonResponse
    {
        $response = $apiResponseService->getResponse();
        $user = $userRepository->findOneBy(['email' => $email]);
        if (null === $user) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent(json_encode(['error' => 'Invalid token']));
            return $response;
        }
        $response->setContent(json_encode([
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'picture' => $user->getPicture(),
            'id' => $user->getId(),
        ]));
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}
