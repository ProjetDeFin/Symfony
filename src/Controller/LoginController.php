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
        ApiResponseService $apiResponseService,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ): JsonResponse
    {
        $response = $apiResponseService->getResponse();

        $email = $request->get('email');
        $password = $request->get('password');

        if (!$email || !$password) {
            return $this->createErrorResponse($response, Response::HTTP_BAD_REQUEST, 'Email and password are required');
        }

        $user = $userRepository->findOneBy(['email' => $email]);
        if (null === $user || !$passwordHasher->isPasswordValid($user, $password)) {
            return $this->createErrorResponse($response, Response::HTTP_FORBIDDEN, 'Invalid credentials');
        }

        try {
            $token = $JWTTokenManager->createFromPayload($user, [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'id' => $user->getId(),
            ]);
            $logger->info('Token generated: ' . $token);
        } catch (\Exception $e) {
            $logger->error('Error generating token: ' . $e->getMessage());
            return $this->createErrorResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred while generating the token');
        }

        $user->setApiToken($token);

        $entityManager->persist($user);
        $entityManager->flush();

        // Return token in the response
        $response->setStatusCode(Response::HTTP_OK);
        $response->setData([
            'token' => $token,
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'id' => $user->getId(),
        ]);
        return $response;
    }

    private function createErrorResponse(JsonResponse $response, int $statusCode, string $message): JsonResponse
    {
        $response->setStatusCode($statusCode);
        $response->setData(['error' => $message]);
        return $response;
    }
}
