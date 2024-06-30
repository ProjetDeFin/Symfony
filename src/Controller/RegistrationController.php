<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\User;
use App\Model\CompanyRegisterDTO;
use App\Model\StudentRegisterDTO;
use App\Model\UserRegisterDTO;
use App\Repository\CategoryRepository;
use App\Repository\CompanyRepository;
use App\Repository\DiplomaSearchedRepository;
use App\Repository\SectorRepository;
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
        EntityManagerInterface $entityManager,
        DiplomaSearchedRepository $diplomaSearchedRepository,
        CompanyRepository $companyRepository,
        CategoryRepository $categoryRepository,
        SectorRepository $sectorRepository,
    ): JsonResponse
    {
        $data = $request->request->all();
        $response = $apiResponseService->getResponse();

        $userDTO = new UserRegisterDTO($data, $userRepository);
        $user = User::fromDTO($userDTO);
        $user->setPassword($passwordHasher->hashPassword($user, $userDTO->getPassword()));

        if (true === $data['isStudent']) {
            $studentDTO = new StudentRegisterDTO($data, $diplomaSearchedRepository);
            $student = Student::fromDTO($studentDTO);
        } elseif (true === $data['isCompany']) {
            $companyDTO = new CompanyRegisterDTO($data, $companyRepository, $categoryRepository, $sectorRepository);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}
