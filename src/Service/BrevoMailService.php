<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class BrevoMailService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $apiKey,
        private string $accountSenderEmail,
        private string $apiUrl,
    ) {
    }

    public function sendMail(string $to, int $templateId, array $params = []): void
    {
        try {
            $this->client->request('POST', $this->apiUrl, [
                'headers' => [
                    'Api-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => 'Bourse aux stages',
                        'email' => $this->accountSenderEmail,
                    ],
                    'to' => [
                        [
                            'name' => 'Bourse aux stages User',
                            'email' => $to,
                        ],
                    ],
                    'templateId' => $templateId,
                    'params' => $params,
                ],
            ]);
        } catch (\Exception $e) {
            // Handle exceptions or log errors
            error_log('Error sending mail: ' . $e->getMessage());
            throw $e;
        }
    }
}
