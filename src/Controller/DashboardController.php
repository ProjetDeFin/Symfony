<?php

namespace App\Controller;

use App\Repository\CompanyResponsibleRepository;
use App\Repository\StudentRepository;
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

    #[Route(path: '/profile/{role}', name: 'profile', methods: ['GET'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
        StudentRepository $studentRepository,
        CompanyResponsibleRepository $companyResponsableRepository,
        string $role,
    ): JsonResponse
    {
        $data = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $data);
        $user = $userRepository->findOneBy(['apiToken' => $token]);
        if (!$user) {
            return new JsonResponse('Invalid token', 400);
        }
        if ($role === 'ROLE_STUDENT') {
            $student = $studentRepository->findOneBy(['user' => $user]);
            $toSerialize = [
                'role' => $student,
                'user' => $user,
            ];
        } elseif ($role === 'ROLE_COMPANY_RESPONSIBLE') {
            $companyResponsible = $companyResponsableRepository->findOneBy(['user' => $user]);
            $toSerialize = [
                'role' => $companyResponsible,
                'user' => $user,
            ];
        } else {
            return new JsonResponse('Invalid role', 400);
        }

        return new JsonResponse($toSerialize, 200, ['Content-Type' => 'application/json']);
    }
}
