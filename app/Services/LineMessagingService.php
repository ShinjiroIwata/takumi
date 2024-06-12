<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LineMessagingService
{
    protected $httpClient;
    protected $channelAccessToken;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->channelAccessToken = config('services.line.channel_access_token');
    }

    public function pushMessage($userId, $messageText)
    {
        $httpClient = new Client();
        $channelAccessToken = config('services.line.channel_access_token');
        $response = $httpClient->post('https://api.line.me/v2/bot/message/push', [
            'headers' => [
                'Authorization' => 'Bearer ' . $channelAccessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $userId,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => $messageText,
                    ],
                ],
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            Log::error('Failed to send message: ' . $response->getBody());
        }

        return $response->getStatusCode() == 200;
    }
}
