<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}
