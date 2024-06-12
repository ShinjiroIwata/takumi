<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        @foreach ($users as $user)
            <tr>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    <form action="{{ route('admin.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="line_id" value='{{ $user->line_id }}'>
                        <input type="hidden" name="ancate_type" value="1">
                        <button>アンケート１を送る</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('admin.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="line_id" value='{{ $user->line_id }}'>
                        <input type="hidden" name="ancate_type" value="1">
                        <button>アンケート2を送る</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
