<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\ApiResponseService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
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
        LoggerInterface $logger,
        ApiResponseService $apiResponseService,
    ): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $response = $apiResponseService->getResponse();

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
            if (0 === strlen($token)) {
                throw new \Exception('Token generation failed');
            }
            $logger->info('Token generated: ' . $token);
            $user->setApiToken($token);

            $entityManager->persist($user);
            $entityManager->flush();

            $response->setData([
                'token' => $token,
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'id' => $user->getId(),
            ]);
        } catch (\Exception $e) {
            $logger->error('Error generating token: ' . $e->getMessage());
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setData(['error' => 'An error occurred while generating the token']);
        }

        return $response;
    }
}
