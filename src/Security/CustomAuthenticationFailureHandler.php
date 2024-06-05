<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use App\Service\ApiResponseService;

class CustomAuthenticationFailureHandler extends AuthenticationFailureHandler
{
private $apiResponseService;

public function __construct(ApiResponseService $apiResponseService)
{
$this->apiResponseService = $apiResponseService;
}

public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
{
$response = $this->apiResponseService->getResponse();
$response->setStatusCode(Response::HTTP_UNAUTHORIZED);
$response->setData(['error' => $exception->getMessageKey()]);

return $response;
}
}
