<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        td,
        th {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>名前</th>
            <th>アンケート１</th>
            <th>アンケート２</th>
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
                            <input type="hidden" name="ancate_type" value="1">
                            <button>アンケート2を送る</button>
                        </form>
                    @endif

                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
