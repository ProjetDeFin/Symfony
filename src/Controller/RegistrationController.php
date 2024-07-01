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
use App\Service\BrevoMailService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly string $frontUrl
    ) {
    }

    #[Route(path: '/register', name: 'register', methods: ['POST'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        ApiResponseService $apiResponseService,
        EntityManagerInterface $entityManager,
        DiplomaSearchedRepository $diplomaSearchedRepository,
        CompanyRepository $companyRepository,
        CategoryRepository $categoryRepository,
        SectorRepository $sectorRepository,
        StudyLevelRepository $studyLevelRepository,
        BrevoMailService $mailService,
    ): JsonResponse
    {
        $data = $request->request->all();
        $response = $apiResponseService->getResponse();

        try {
            $userDTO = new UserRegisterDTO($data, $userRepository);
            $user = User::fromDTO($userDTO);
            $user->setPassword($passwordHasher->hashPassword($user, $userDTO->getPassword()));

            if ('true' === $data['isStudent']) {
                $user->setRoles(['ROLE_STUDENT']);
                $studentDTO = new StudentRegisterDTO($data, $diplomaSearchedRepository, $studyLevelRepository);
                $student = Student::fromDTO($studentDTO);
                $entityManager->persist($student);
            } elseif ('true' === $data['isCompany']) {
                $user->setRoles(['ROLE_COMPANY_RESPONSIBLE']);
                $companyDTO = new CompanyRegisterDTO($data, $companyRepository, $categoryRepository, $sectorRepository);
                $company = Company::fromDTO($companyDTO);
                $companyResponsible = CompanyResponsible::fromDTO($companyDTO, $user, $company);
                $entityManager->persist($companyResponsible);
                $entityManager->persist($company);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $mailService->sendMail($user->getEmail(), 3,
                [
                    'link' => $this->frontUrl.'/profil/validation/'.$user->getId(),
                ],
            );

            $response->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($e->getMessage());
        }
        return $response;
    }

    #[Route(path: '/register/confirm/{id}', name: 'register_confirm', methods: ['GET'])]
    public function confirm(
        UserRepository $userRepository,
        JWTTokenManagerInterface $JWTTokenManager,
        ApiResponseService $apiResponseService,
        EntityManagerInterface $entityManager,
        int $id,
    ): JsonResponse
    {
        $response = $apiResponseService->getResponse();
        try {
            $user = $userRepository->find($id);
            if (null === $user) {
                throw new \InvalidArgumentException('User not found');
            }
            $user->setEnabled(true);

            $token = $JWTTokenManager->createFromPayload($user, [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'id' => $user->getId(),
            ]);

            $user->setApiToken($token);

            $entityManager->persist($user);
            $entityManager->flush();

            $response->setData(['token' => $token]);
            $response->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

    #[Route(path: '/register/selects/company', name: 'register_selects_company', methods: ['get'])]
    public function selects(
        CategoryRepository $categoryRepository,
        SectorRepository $sectorRepository,
    ): Response
    {
        $selects = [
            'categories' => $categoryRepository->findAll(),
            'sectors' => $sectorRepository->findAll(),
        ];

        $jsonContent = $this->serializer->serialize($selects, 'json', ['groups' => 'selectsRegisterCompany']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }

    #[Route(path: '/register/selects/student', name: 'register_selects_student', methods: ['get'])]
    public function selectsStudent(
        StudyLevelRepository $studyLevelRepository,
        DiplomaSearchedRepository $diplomaSearchedRepository,
    ): Response
    {
        $selects = [
            'studyLevels' => $studyLevelRepository->findAll(),
            'diplomasSearched' => $diplomaSearchedRepository->findAll(),
        ];

        $jsonContent = $this->serializer->serialize($selects, 'json', ['groups' => 'selectsRegisterStudent']);
        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);
    }
}
