<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

final readonly class ApiResponseService
{
    public function __construct(
        private string $frontUrl,
    ) {
    }
    public function getResponse(): Response
    {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', $this->frontUrl);
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        return $response;
    }
}
