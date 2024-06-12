<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AncateController extends Controller
{
    //

    public function ancate1()
    {
        $user = Auth::user();
        return view('ancates.style1', compact('user'));
    }
    public function ancate1store(Request $request)
    {
        // dd('finish');

        $answer1 = $request->rating1;
        $answer2 = $request->rating2;
        $answer3 = $request->rating3;
        $answer4 = $request->rating4;
        $answer5 = $request->rating5;
        $line_id = $request->line_id;

        $answers = [
            1 => $answer1,
            2 => $answer2,
            3 => $answer3,
            4 => $answer4,
            5 => $answer5
        ];
        foreach ($answers as $currentQuestion => $answer) {

            SurveyResponse::updateOrCreate(
                [
                    'clinic_id' => 1,
                    'line_id' => $line_id,
                    'survey_type' => 'survey1',
                    'question_number' => $currentQuestion,
                ],
                [
                    'answer' => $answer,
                ]
            );
        }
        $userId = $line_id;
        $messageText = 'ありがとうございました。';
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

        if ($response->getStatusCode() == 200) {
            return view('ancates.thanks');
        } else {
        }

        if ($response) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }
    public function ancate2()
    {
        $user = Auth::user();
        return view('ancates.style2', compact('user'));
    }
    public function ancate2store(Request $request)
    {
        // dd('finish');

        $answer1 = $request->rating1;
        $answer2 = $request->rating2;
        $answer3 = $request->rating3;
        $answer4 = $request->rating4;
        $answer5 = $request->rating5;
        $line_id = $request->line_id;

        $answers = [
            1 => $answer1,
            2 => $answer2,
            3 => $answer3,
            4 => $answer4,
            5 => $answer5
        ];
        foreach ($answers as $currentQuestion => $answer) {

            SurveyResponse::updateOrCreate(
                [
                    'clinic_id' => 1,
                    'user_id' => $line_id,
                    'survey_type' => 'survey2',
                    'question_number' => $currentQuestion,
                ],
                [
                    'answer' => $answer,
                ]
            );
        }
        $userId = $line_id;
        $messageText = 'ありがとうございました。';
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

        if ($response->getStatusCode() == 200) {
            return view('ancates.thanks');
        } else {
        }

        if ($response) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }
}
