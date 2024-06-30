<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyResponsible;
use App\Entity\Student;
use App\Entity\User;
use App\Model\CompanyRegisterDTO;
use App\Model\StudentRegisterDTO;
use App\Model\UserRegisterDTO;
use App\Repository\CategoryRepository;
use App\Repository\CompanyRepository;
use App\Repository\DiplomaSearchedRepository;
use App\Repository\SectorRepository;
use App\Repository\StudyLevelRepository;
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
        StudyLevelRepository $studyLevelRepository,
    ): JsonResponse
    {
        $data = $request->request->all();
        $response = $apiResponseService->getResponse();

        $userDTO = new UserRegisterDTO($data, $userRepository);
        $user = User::fromDTO($userDTO);
        $user->setPassword($passwordHasher->hashPassword($user, $userDTO->getPassword()));
        $entityManager->persist($user);

        if (true === $data['isStudent']) {
            $studentDTO = new StudentRegisterDTO($data, $diplomaSearchedRepository, $studyLevelRepository);
            $student = Student::fromDTO($studentDTO);
            $entityManager->persist($student);
        } elseif (true === $data['isCompany']) {
            $companyDTO = new CompanyRegisterDTO($data, $companyRepository, $categoryRepository, $sectorRepository);
            $company = Company::fromDTO($companyDTO);
            $companyResponsible = CompanyResponsible::fromDTO($companyDTO, $user, $company);
            $entityManager->persist($companyResponsible);
            $entityManager->persist($company);
        }

        $entityManager->flush();

        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}
