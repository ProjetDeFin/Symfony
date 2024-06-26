<?php

namespace App\Controller;

use App\Entity\User;
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
class RegistrationController extends AbstractController
{
    #[Route(path: '/register', name: 'register', methods: ['POST'])]
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

        $firstName = $request->get('first_name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');
        $password = $request->get('password');
        $confirmPassword = $request->get('confirm_password');

        if (!$firstName || !$lastName || !$email || !$password || !$confirmPassword) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setData(['error' => 'Email and password are required']);
            return $response;
        }

        $user = $userRepository->findOneBy(['email' => $email]);
        if (null !== $user) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'User already exists']);
            return $response;
        }

        if ($password !== $confirmPassword) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'Passwords do not match']);
            return $response;
        }

        if (strlen($password) < 8) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'Password must be at least 8 characters long']);
            return $response;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'Password must contain at least one uppercase letter']);
            return $response;
        }

        if (!preg_match('/[a-z]/', $password)) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'Password must contain at least one lowercase letter']);
            return $response;
        }

        if (!preg_match('/[0-9]/', $password)) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $response->setData(['error' => 'Password must contain at least one number']);
            return $response;
        }

        $user = new User;
        $user
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPassword($passwordHasher->hashPassword($user, $password))
        ;

        $entityManager->persist($user);
        $entityManager->flush();

        // Return token in the response
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}
