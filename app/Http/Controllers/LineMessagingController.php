<?php

namespace App\Http\Controllers;

use App\Services\LineMessagingService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LineMessagingController extends Controller
{

    public function sendNotification(Request $request)
    {

        $userId = '';
        $messageText = 'test';
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

        if ($response) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }
}
