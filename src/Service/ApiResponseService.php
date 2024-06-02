<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class ApiResponseService
{
    public function __construct(
        private string $frontUrl,
    ) {
    }
    public function getResponse(): JsonResponse
    {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', $this->frontUrl);
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept');
        return $response;
    }
}
