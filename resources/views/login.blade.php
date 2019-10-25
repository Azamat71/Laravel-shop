<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style type="text/css">
        body{
 background: #4CCEB2; /* Для браузеров, которые не поддерживают градиенты */
 background: -webkit-radial-gradient(#4CCEB2, #2F8FD8);   }
    </style>
</head>

<body>
<div id="app">
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-text" href="/" style="font-size:25px; border: 5px solid gray;border-radius: 10px;padding: 10px;">Главная</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarText">
                    <div class="d-flex align-items-center ml-auto">
                        <ul class="nav nav-tabs">

                                <li class="nav-item"><a href="/registration" class="nav-link">Зарегистрироваться</a> </li>
                            </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <section class="main mt-5">
        <div class="container">
            <div class="row mt-5 justify-content-center align-items-center">
                <!-- Grid column -->
                <div class="col-md-6">
                    <h4 class="text-center mb-3">Войти</h4>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form class="form" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ник</label>
                            <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ваш ник:" autocomplete="off" required="required">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">пароль</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль" autocomplete="off" required="required">
                        </div>


                        <button type="submit" class="btn btn-primary mt-4">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
