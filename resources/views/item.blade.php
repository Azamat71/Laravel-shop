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
 background: -webkit-radial-gradient(#4CCEB2, #2F8FD8); }
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
                        @if (!session() -> get('user'))
                            <a href="/login">Login</a>
                            <a href="/registration" class="ml-3">Register</a>
                        @elseif (session() -> get('user') && (session() -> get('user'))['type'] == 1)
                            <a href="/admin">Admin Panel</a>

                            <form action="{{ route('logout') }}" method="post" class="ml-4">
                                {{ csrf_field() }}
                                <button type="submit">
                                    Logout
                                </button>
                            </form>
                        @else
                            <form action="{{ route('logout') }}" method="post" class="d-flex align-items-center">
                                    {{ csrf_field() }}
                                                <div class="dropdown">
                                                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ session() -> get('user')['username'] }}
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <a href="/history"><button type="button" class="dropdown-item">Ваша история</button></a>
                                                    <a href="/basket"><button type="button" class="dropdown-item">Корзина</button></a>
                                                    <button type="submit" class="dropdown-item">выйти</button>
                                                  </div>
                                                </div>


                                </form>
                        @endif
                    </div>
                </div>
            </nav>
        </div>

    <section class="main">
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5 class="card-title">Книга: {{ $item -> name }}</h5>
                            <p class="card-text">Жанр: {{ $item -> description }}</p>
                            <p class="cart-text">Цена: {{ $item -> price }}тг</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="comments">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Комментарий:</h4>

                    @foreach ($comments as $comment)
                        <div class="card w-100">
                            <div class="card-body">
                                @if ($comment -> is_admin == 0)
                                    <h5 class="card-title">User: {{$comment -> name}}</h5>
                                @else
                                    <h5 class="cart-title">Admin: {{$comment -> name}}</h5>
                                @endif
                                <p class="card-text">Description: {{ $comment -> description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-12 mt-5">
                    @if (session() -> get('user'))
                        <h4>Оставьте комментарий:</h4>

                        <form action="{{ route('comments-add') }}" method="post" class="d-flex flex-column">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea type="text" name="description" required="required" autocomplete="off" class="px-3" placeholder="Коммент"></textarea>
                                <input type="text" class="d-none" name="id" value="{{ $item -> id }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </div>
                        </form>
                    @else
                        <h4 class="text-center mb-4">Please <a href="/login">authorize</a></h4>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
