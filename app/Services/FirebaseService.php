<?php

namespace App\Services;

use GuzzleHttp\Client;

class FirebaseService
{
    protected $serverKey;
    protected $client;

    public function __construct()
    {
        $this->serverKey = env('FIREBASE_SERVER_KEY');
        $this->client = new Client([
            'base_uri' => 'https://fcm.googleapis.com/fcm/',
        ]);
    }

    public function sendNotification($token, $title, $body, $data = [])
    {
        $payload = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ];

        $response = $this->client->post('send', [
            'headers' => [
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode($response->getBody(), true);
    }
}
