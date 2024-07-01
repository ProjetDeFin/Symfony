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

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    public function __construct(private readonly string $frontUrl)
    {
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

        dump($data);

        try {
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

            $mailService->sendMail($user->getEmail(), 3,
                [
                    'link' => $this->frontUrl.'/profil/validation/'.$user->getId(),
                ],
            );

            $entityManager->flush();

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
}
