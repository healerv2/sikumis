<?php

namespace App\Services;

use Google\Client;
use GuzzleHttp\Client as HttpClient;

class FirebaseService
{
    protected $http;
    protected $client;
    protected $projectId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(base_path(config('services.fcm.credentials')));
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $this->client->fetchAccessTokenWithAssertion();

        $this->http = new HttpClient();
        $this->projectId = config('services.fcm.project_id');
    }

    public function sendNotification(array $fcmTokens, string $title, string $body, string $url = null)
    {
        $accessToken = $this->client->getAccessToken()['access_token'];

        foreach ($fcmTokens as $token) {
            $this->http->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'message' => [
                        'token' => $token,
                        'notification' => [
                            'title' => $title,
                            'body' => $body,
                        ],
                        'webpush' => [
                            'fcm_options' => [
                                'link' => $url ?? url('/')
                            ]
                        ]
                    ]
                ]
            ]);
        }
    }

    public function sendToDevice(string $token, string $title, string $body, string $url = null)
    {
        return $this->sendNotification([$token], $title, $body, $url);
    }
}
