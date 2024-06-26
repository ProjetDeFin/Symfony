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
        // TODO: Change this to the front-end URL
        $response->headers->set('Access-Control-Allow-Origin', $this->frontUrl);
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept');
        return $response;
    }
}
