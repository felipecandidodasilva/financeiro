<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Aviso</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert">
                <p>{{$mensagem}}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>