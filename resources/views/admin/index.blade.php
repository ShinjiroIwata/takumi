<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('admin.send') }}" method="POST">
        <input type="hidden" name="ancate_type" value="1">
        <button>アンケート１を全員へ送る</button>
    </form>
    <form action="{{ route('admin.send') }}" method="POST">
        <input type="hidden" name="ancate_type" value="2">
        <button>アンケート２を全員へ送る</button>
    </form>
</body>

</html>
