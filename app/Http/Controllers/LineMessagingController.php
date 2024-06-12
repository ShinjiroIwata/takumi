<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LineMessagingController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }
    public function sendNotification(Request $request)
    {
        // 動的に変更できるように
        $ancateType = $request->ancate_type;
        $userId = $request->line_id;

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
                "type" => "bubble",
                "hero" => [
                    "type" => "image",
                    "url" => "https://developers-resource.landpress.line.me/fx/img/01_1_cafe.png",
                    "size" => "full",
                    "aspectRatio" => "20:13",
                    "aspectMode" => "cover",
                    "action" => [
                        "type" => "uri",
                        "uri" => "https://line.me/"
                    ]
                ],
                "footer" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "spacing" => "sm",
                    "contents" => [
                        [
                            "type" => "button",
                            "style" => "link",
                            "height" => "sm",
                            "action" => [
                                "type" => "uri",
                                "label" => "アンケートへ進む",
                                "uri" => "https://takumi.webpromotion-business.site/ancate$ancateType"
                            ]
                        ],
                        [
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => [],
                            "margin" => "sm"
                        ]
                    ],
                    "flex" => 0
                ]
            ];

            $message = [
                [
                    'type' => 'flex',
                    'altText' => 'アンケートのお願い',
                    'contents' => $flexContent,
                ],
            ];
        }

        // $users = User::all();
        // foreach ($users as $user) {
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
        // }


        if ($response->getStatusCode() != 200) {
            Log::error('Failed to send message: ' . $response->getBody());
        }

        return $response->getStatusCode() == 200 ?
            response()->json(['status' => 'success'], 200) :
            response()->json(['status' => 'error'], 500);
    }
}
