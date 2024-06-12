<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            table-layout: fixed;
        }

        td,
        th {
            border: 1px solid black;
            padding: 8px;
        }

        .container {
            width: 1200px;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .block {
            margin-top: 24px;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <tr>
                <th>名前</th>
                <th>カウンセリングアンケート</th>
                <th>施術アンケート</th>
                <th>術後アンケート</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        @if ($user->surveyResponses->contains('survey_type', 'survey1'))
                            回答済み
                        @else
                            <form action="{{ route('admin.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="line_id" value='{{ $user->line_id }}'>
                                <input type="hidden" name="ancate_type" value="1">
                                <button>アンケート１を送る</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if ($user->surveyResponses->contains('survey_type', 'survey2'))
                            回答済み
                        @else
                            <form action="{{ route('admin.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="line_id" value='{{ $user->line_id }}'>
                                <input type="hidden" name="ancate_type" value="2">
                                <button>アンケート2を送る</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if ($user->surveyResponses->contains('survey_type', 'survey3'))
                            回答済み
                        @else
                            <form action="{{ route('admin.send') }}" method="POST">
                                @csrf
                                <input type="hidden" name="line_id" value='{{ $user->line_id }}'>
                                <input type="hidden" name="ancate_type" value="3">
                                <button>アンケートを送る</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="block">
            <div>アンケート１の回答</div>
            <table>
                <tr>
                    <th>名前</th>
                    <th>Q1:テスト</th>
                    <th>Q2:テスト</th>
                    <th>Q3:テスト</th>
                    <th>Q4:テスト</th>
                    <th>Q5:テスト</th>
                    <th>ユーザー平均</th>
                </tr>
                @php
                    $totalAnswers1 = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
                    $countAnswers1 = ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0];
                @endphp
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        @php
                            // 質問番号ごとに回答を格納するための配列を初期化
                            $answers = ['1' => '', '2' => '', '3' => '', '4' => '', '5' => ''];
                        @endphp
                        @foreach ($user->surveyResponses as $data)
                            @if ($data->survey_type == 'survey1')
                                @php
                                    // 質問番号ごとに回答を格納
                                    $answers[$data->question_number] = $data->answer;
                                    $totalAnswers1[$data->question_number] += $data->answer;
                                    $countAnswers1[$data->question_number]++;
                                @endphp
                            @endif
                        @endforeach
                        @php
                            $total_num = 0;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @php
                                $total_num += $answers[$i];
                            @endphp
                            <td>{{ $answers[$i] }}</td>
                        @endfor
                        <td>{{ $total_num / 5 }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>平均</td>

                    @php
                        $total_num = 0;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @php
                            $total_num += $totalAnswers1[$i];
                        @endphp
                        <td>{{ $countAnswers1[$i] > 0 ? $totalAnswers1[$i] / $countAnswers1[$i] : 0 }}</td>
                    @endfor
                    <td>{{ $total_num / 5 }}</td>
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
