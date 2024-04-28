<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Service\BrevoMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ResetPassword;
use App\Repository\UserRepository;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

#[Route(path: '/reset_password', name: 'app_reset_password')]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly BrevoMailService $mailService,
        private readonly UserRepository $userRepository,
        private TokenGeneratorInterface $tokenGenerator
    ) {
    }

    #[Route(path: '/', methods: ['GET'])]
    public function showResetPassword(): Response
    {
        return $this->render('/admin/reset.html.twig',);
    }

    #[Route(path: '/send_mail', methods: ['POST'])]
    public function resetPassword(Request $request): Response
    {
        $email = $request->get('email');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user === null) {
            throw new NotFoundHttpException('User not found.');
        }

        $newToken = $this->tokenGenerator->generateToken();
    }
}
