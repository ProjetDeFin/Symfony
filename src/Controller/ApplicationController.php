<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\Student;
use App\Model\ApplicationDTO;
use App\Repository\ApplicationRepository;
use App\Repository\InternshipOfferRepository;
use App\Repository\ResetPasswordRepository;
use App\Repository\StudentRepository;
use App\Service\ApiResponseService;
use App\Service\BrevoMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Application;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

#[Route('/api/applications', name: 'applications_')]
class ApplicationController extends AbstractController
{
    public function __construct(
        private string $apiUrl,
    ) {
    }
    #[Route(path: '/apply', name: 'new', methods: ['POST'])]
    public function apply(
        Request $request,
        ApiResponseService $apiResponseService,
        StudentRepository $studentRepository,
        InternshipOfferRepository $internshipOfferRepository,
        EntityManagerInterface $entityManager,
        BrevoMailService $brevoMailService,
        ResetPasswordRepository $resetPasswordRepository,
        TokenGeneratorInterface $tokenGenerator,
        RouterInterface $router,
    ): Response
    {
        $data = $request->request->all();
        $response = $apiResponseService->getResponse();
        try {
            $applicationDTO = new ApplicationDTO($data);
            $internshipOffer = $internshipOfferRepository->find($applicationDTO->getOfferId());
            if (!$internshipOffer) {
                throw new \InvalidArgumentException('Offer not found');
            }
            $student = $studentRepository->findOneBy(['email' => $applicationDTO->getEmail()]) ?? Student::fromApplicationDTO($applicationDTO);
            $application = Application::fromDTO($applicationDTO, $student, $internshipOffer);
            $entityManager->persist($application);
            if ($applicationDTO->getCreateAccount()) {
                $resetPassword = $resetPasswordRepository->findOneBy(['user' => $student->getUser()]);

                if (!$resetPassword) {
                    $resetPassword = new ResetPassword();
                    $resetPassword
                        ->setUser($student->getUser())
                        ->setToken($tokenGenerator->generateToken());
                }

                $entityManager->persist($resetPassword);
                $brevoMailService->sendMail($student->getUser()->getEmail(), 'Account creation', [
                    'title' => 'Account creation',
                    'description' => 'Thank you for you account creation ! Click the link below to confirm your account creation.',
                    'link' => $router->generate('app_reset_password_reset', ['token' => $resetPassword->getToken(), 'domain' => $this->apiUrl], UrlGeneratorInterface::ABSOLUTE_URL),
                    'linkTitle' => 'Create password',
                    'buttonContent' => 'Create password',
                ]);
            }
            $entityManager->flush();
            $response
                ->setStatusCode(Response::HTTP_OK)
                ->setContent('Apply confirmed');
        } catch(\InvalidArgumentException|\Exception $e) {
            $response
                ->setStatusCode(Response::HTTP_BAD_REQUEST)
                ->setContent($e->getMessage());
        }

        return $response;
    }
}
