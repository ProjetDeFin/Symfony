<?php

namespace App\Controller;

use App\Service\ApiResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/login')]
class LoginController extends AbstractController
{
    #[Route(path: '/', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        ApiResponseService $apiResponseService,
    ): JsonResponse
    {
        $response = $apiResponseService->getResponse();

        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error) {
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            $response->setData(['error' => $error->getMessageKey()]);
            return $response;
        }
        $response->setData(['message' => 'Logged in successfully']);
        return $response;
    }
}
