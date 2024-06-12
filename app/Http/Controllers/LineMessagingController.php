<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LineMessagingController extends Controller
{
    public function sendNotification(Request $request)
    {
        $userId = 'Ub9d0df0a71679d127a5cf7482555df9a'; // リクエストからユーザーIDを取得
        $messageType = 'flex'; // メッセージタイプ（textまたはflex）をリクエストから取得
        $messageText = 'test'; // テキストメッセージ
        $httpClient = new Client();
        $channelAccessToken = config('services.line.channel_access_token');

        $message = [];

        if ($messageType === 'text') {
            $message = [
                [
                    'type' => 'text',
                    'text' => $messageText,
                ],
            ];
        } elseif ($messageType === 'flex') {
            $flexContent = [
                'type' => 'bubble',
                'body' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => 'Hello, World!',
                            'weight' => 'bold',
                            'size' => 'xl'
                        ],
                        [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'margin' => 'lg',
                            'spacing' => 'sm',
                            'contents' => [
                                [
                                    'type' => 'text',
                                    'text' => 'Line Flex Message Example',
                                    'size' => 'sm',
                                    'color' => '#AAAAAA',
                                    'wrap' => true
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $message = [
                [
                    'type' => 'flex',
                    'altText' => 'This is a Flex Message',
                    'contents' => $flexContent,
                ],
            ];
        }

        $response = $httpClient->post('https://api.line.me/v2/bot/message/push', [
            'headers' => [
                'Authorization' => 'Bearer ' . $channelAccessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $userId,
                'messages' => $message,
            ],
        ]);

        if ($response->getStatusCode() != 200) {
            Log::error('Failed to send message: ' . $response->getBody());
        }

        return $response->getStatusCode() == 200 ?
            response()->json(['status' => 'success'], 200) :
            response()->json(['status' => 'error'], 500);
    }
}
