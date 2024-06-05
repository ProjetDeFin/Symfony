<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Service\ApiResponseService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CustomAuthenticationSuccessHandler extends AuthenticationSuccessHandler
{

    public function __construct(
        private readonly ApiResponseService $apiResponseService,
        protected JWTTokenManagerInterface  $jwtManager,
        protected EventDispatcherInterface $dispatcher,
    ) {
        parent::__construct($this->jwtManager, $this->dispatcher);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        $response = $this->apiResponseService->getResponse();
        $response->setData([
            'token' => $this->jwtManager->create($token->getUser()),
            'message' => 'Logged in successfully'
        ]);

        return $response;
    }
}
