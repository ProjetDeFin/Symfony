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

    public function sendMail(string $to, string $subject, array $params): void
    {
        try {
            $response = $this->client->request('POST', $this->apiUrl, [
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
                    'templateId' => 1,
                    'subject' => $subject,
                    'params' => $params,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Failed to send email');
            }
        } catch (\Exception $e) {
            // Handle exceptions or log errors
            error_log('Error sending mail: ' . $e->getMessage());
            throw $e;
        }
    }
}
