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
            width: 1000px;
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
                    <th>Q1:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q2:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q3:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q4:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q5:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        @foreach ($user->surveyResponses as $data)
                            @if ($data->survey_type == 'survey1')
                                <td>{{ $data->answer }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>

        <div>
            <div>アンケート２の回答</div>
            <table>
                <tr>
                    <th>名前</th>
                    <th>Q1:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q2:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q3:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q4:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                    <th>Q5:⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎⚪︎</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }}
                        </td>
                        @foreach ($user->surveyResponses as $data)
                            @if ($data->survey_type == 'survey2')
                                <td>{{ $data->answer }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
