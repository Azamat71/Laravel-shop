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
    <style>
        .card {
            position: relative;
        }

        .delete {
            position: absolute;
            top: 0;
            right: 0;
        }
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
                                                    <button type="submit" class="dropdown-item">Выйти</button>
                                                  </div>
                                                </div>


                                </form>
                            @endif
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <section class="main">
            <div class="container mb-5">
                <div class="row">
                    @if (sizeof($items) > 0)
                        @foreach ($items as $item)
                            <div class="col-md-12">
                                <div class="card w-100 mb-5">
                                    <div class="card-body">
                                        <form action="{{ route('user-remove', ['id' => $item -> id]) }}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            {{ $item -> id }}
                                            <button type="submit" class="close" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </form>

                                        <h5 class="card-title">Книга: {{ $item  -> name }}</h5>
                                        <p class="card-text">Жанр: {{ $item -> description }}</p>
                                        <p class="cart-text">Цена: {{ $item -> price }} * количество: {{ $item -> count }}шт = {{ (int) $item -> price * (int) $item -> count }}тг</p>
                                        <a href="item/{{ $item -> item_id  }}" class="btn btn-primary">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-md-12">
                            <form action="{{ route('take-all') }}" method="post">
                                {{ csrf_field() }}
                                <span>Сумма: {{ $sum  }}тг</span>

                                <button type="submit" class="btn btn-primary">Купить сейчас</button>
                            </form>
                        </div>
                    @else
                        <div class="col-md-12">
                            <h4 class="text-center mt-5">Ваша корзина пуста, <a href="/">на главную!</a></h4>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</body>
</html>
