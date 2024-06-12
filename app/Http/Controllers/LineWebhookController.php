<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class LineWebhookController extends Controller
{
    public function webhook(Request $request)
    {
        // LINEからの署名検証
        $signature = $request->header('X-Line-Signature');
        if (!$this->validateSignature($request->getContent(), env('LINE_CHANNEL_SECRET'), $signature)) {
            return response('Invalid signature', 400);
        }

        $events = json_decode($request->getContent(), true);

        Log::info('イベントを受信しました:', $events);
        foreach ($events['events'] as $event) {
            if ($event['type'] === 'message' && $event['message']['type'] === 'text') {
                $userId = $event['source']['userId'];
                $messageText = $event['message']['text'];

                // 入力値に応じてアンケートを開始
                if ($messageText == 'アンケート1') {
                    $this->sendSurveyQuestion($event['replyToken'], 1, 'survey1');
                } elseif ($messageText == 'アンケート2') {
                    $this->sendSurveyQuestion($event['replyToken'], 1, 'survey2');
                } elseif ($messageText == 'アンケート3') {
                    $this->sendSurveyQuestion($event['replyToken'], 1, 'survey3');
                }
            } elseif ($event['type'] === 'postback') {
                $userId = $event['source']['userId'];
                $postbackData = $event['postback']['data'];

                // ポストバックデータに基づいて処理を行う
                $this->handlePostback($event['replyToken'], $userId, $postbackData);
            }
        }

        return response('OK', 200);
    }

    private function validateSignature($body, $secret, $signature)
    {
        $hash = hash_hmac('sha256', $body, $secret, true);
        $expectedSignature = base64_encode($hash);

        return hash_equals($expectedSignature, $signature);
    }

    private function replyTextMessage($replyToken, $messageText)
    {
        $url = 'https://api.line.me/v2/bot/message/reply';
        $data = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'text',
                    'text' => $messageText
                ]
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('LINE_CHANNEL_ACCESS_TOKEN')
        ];

        $client = new Client();
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);

        Log::info('LINE返信メッセージのレスポンス: ' . $response->getBody());
    }

    private function sendSurveyQuestion($replyToken, $questionNumber, $surveyType)
    {
        $surveys = [
            'survey1' => [
                1 => [
                    'text' => '話やすさはいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                2 => [
                    'text' => 'サービスの質はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                3 => [
                    'text' => 'スタッフの対応はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                4 => [
                    'text' => '施設の清潔さはいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                5 => [
                    'text' => '総合的な満足度はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ]
            ],
            'survey2' => [
                1 => [
                    'text' => '商品の品質はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                2 => [
                    'text' => '価格に満足していますか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                3 => [
                    'text' => 'スタッフの対応はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                4 => [
                    'text' => '配達のスピードはいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                5 => [
                    'text' => '総合的な満足度はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ]
            ],
            'survey3' => [
                1 => [
                    'text' => '学習の質はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                2 => [
                    'text' => '教材の満足度はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                3 => [
                    'text' => '講師の対応はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                4 => [
                    'text' => '授業の進行速度はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ],
                5 => [
                    'text' => '総合的な満足度はいかがでしたか？',
                    'options' => [
                        'ひどい' => '1',
                        '良くない' => '2',
                        '普通' => '3',
                        '良い' => '4',
                    ]
                ]
            ]
        ];

        if (!isset($surveys[$surveyType][$questionNumber])) {
            $this->replyTextMessage($replyToken, 'アンケートへのご協力ありがとうございました！');
            return;
        }

        $question = $surveys[$surveyType][$questionNumber];
        $actions = [];

        foreach ($question['options'] as $label => $data) {
            $actions[] = [
                'type' => 'postback',
                'label' => $label,
                'data' => "q{$questionNumber}_{$surveyType}_$data"  // データに質問番号とアンケートタイプを含める
            ];
        }

        // アクションの数が4を超えないようにする
        $actions = array_slice($actions, 0, 4);

        $url = 'https://api.line.me/v2/bot/message/reply';
        $data = [
            'replyToken' => $replyToken,
            'messages' => [
                [
                    'type' => 'template',
                    'altText' => $question['text'],
                    'template' => [
                        'type' => 'buttons',
                        'text' => $question['text'],
                        'actions' => $actions
                    ]
                ]
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('LINE_CHANNEL_ACCESS_TOKEN')
        ];

        $client = new Client();
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $data
        ]);

        Log::info("LINEアンケート質問 $questionNumber のレスポンス: " . $response->getBody());
    }
    private function handlePostback($replyToken, $userId, $postbackData)
    {
        Log::info("ユーザー $userId が $postbackData で回答しました");

        // ポストバックデータから質問番号とアンケートタイプを取得
        list($questionNumber, $surveyType, $answer) = explode('_', $postbackData);
        $currentQuestion = intval(substr($questionNumber, 1));  // 質問番号を正しく解析
        $nextQuestion = $currentQuestion + 1;

        Log::info("次の質問番号: $nextQuestion, アンケートタイプ: $surveyType");

        // 回答をデータベースに保存または更新
        SurveyResponse::updateOrCreate(
            [
                'clinic_id' => 1,
                'user_id' => $userId,
                'survey_type' => $surveyType,
                'question_number' => $currentQuestion,
            ],
            [
                'answer' => $answer,
            ]
        );
        // 次の質問を送信
        $this->sendSurveyQuestion($replyToken, $nextQuestion, $surveyType);
    }
}
