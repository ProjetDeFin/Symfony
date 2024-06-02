<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Form\Type\ResetPasswordType;
use App\Repository\ResetPasswordRepository;
use App\Repository\UserRepository;
use App\Service\BrevoMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

#[Route(path: '/reset_password', name: 'app_reset_password')]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly BrevoMailService $mailService,
        private readonly UserRepository $userRepository,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $hasher,

    ) {
    }

    #[Route(path: '/', methods: ['GET'], name: '')]
    public function showResetPassword(): Response
    {
        return $this->render('app/email-reset.html.twig', [
            'message' => null,
        ]);
    }

    #[Route(path: '/send_mail', methods: ['POST'])]
    public function resetPassword(
        Request $request,
        ResetPasswordRepository $resetPasswordRepository,
    ): Response
    {
        try {
            $email = $request->get('email');
            $user = $this->userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                throw new NotFoundHttpException('User not found.');
            }

            $resetPassword = $resetPasswordRepository->findOneBy(['user' => $user]);

            if (!$resetPassword) {
                $resetPassword = new ResetPassword();
                $resetPassword
                    ->setUser($user)
                    ->setToken($this->tokenGenerator->generateToken());
            }

            $this->entityManager->persist($resetPassword);
            $this->entityManager->flush();

            $this->mailService->sendMail($email, 'Reset password',
                [
                    'title' => 'Reset password',
                    'description' => 'Click the link below to reset your password',
                    'link' => $this->generateUrl('app_reset_password_reset', ['token' => $resetPassword->getToken()]),
                    'linkTitle' => 'Reset password',
                    'buttonContent' => 'Reset password',
                ],
            );

            $message = 'An email has been sent to reset your password.';

            $this->addFlash('success', 'An email has been sent to reset your password.');
        } catch (\Exception $e) {
            // TODO log error
            $message = $e->getMessage();
            $this->addFlash('error', 'An error occurred while sending the email.');
        }

        return $this->render('app/email-reset.html.twig', [
            'message' => $message,
        ]);
    }

    #[Route(path: '/reset/{token}', name: '_reset', methods: ['GET', 'POST'])]
    public function resetPasswordForm(string $token, ResetPasswordRepository $resetPasswordRepository): Response
    {
        $resetPassword = $resetPasswordRepository->findOneBy(['token' => $token]);

        if (!$resetPassword) {
            throw new NotFoundHttpException('Reset password not found.');
        }

        $form = $this->createForm(ResetPasswordType::class, null, ['token' => $token]);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $user = $resetPassword->getUser();
                    $user->setPassword($this->hasher->hashPassword($user, $form->get('password')->getData()));
                    $this->entityManager->persist($user);
                    $this->entityManager->remove($resetPassword);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'Password reset successfully.');
                    return $this->redirectToRoute('app_login');
                } catch (\Exception $e) {
                    // TODO log error
                    $this->addFlash('error', 'An error occurred while resetting the password.');
                }
            } else {
                $this->addFlash('error', 'Invalid form data.');
            }
        }

        return $this->render('/admin/password-reset.html.twig', ['form' => $form->createView()]);
    }
}
