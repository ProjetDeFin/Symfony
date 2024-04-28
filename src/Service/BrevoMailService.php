<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BrevoMailService
{
    private $client;
    private $params;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    public function sendMail(string $to, int $templateId, string $subject, array $params): void
    {
        $apiUrl = 'https://api.brevo.com/v3/smtp/email';
        $apiKey = $this->params->get('BREVO_API_KEY');
        $accountSenderEmail = $this->params->get('ACCOUNT_SENDER_EMAIL');

        try {
            $response = $this->client->request('POST', $apiUrl, [
                'headers' => [
                    'Api-Key' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => 'Tassadapi',
                        'email' => $accountSenderEmail,
                    ],
                    'to' => [
                        [
                            'name' => 'Tassadapi User',
                            'email' => $to,
                        ],
                    ],
                    'templateId' => $templateId,
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
