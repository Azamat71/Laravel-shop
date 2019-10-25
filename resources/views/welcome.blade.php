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

        .number {
            position: absolute;
            border-radius: 5px;
            right: 5%;
        }
        body{
            background: #4CCEB2;
         }
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
                            <ul class="nav nav-tabs">
                            <li class="nav-item">    <a href="/login" class="nav-link">Войти</a></li>
                                <li class="nav-item"><a href="/registration" class="nav-link">Зарегистрироваться</a> </li>
                            </ul>
                            @elseif (session() -> get('user') && (session() -> get('user'))['type'] == 1)
                                <a href="/admin">Админская панель</a>

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
                    @foreach ($items as $item)
                        <div class="col-md-12">
                            <div class="card w-100 mb-5">
                                <div class="card-body">
                                    <form action="{{ route('user-add', ['id' => $item -> id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="number" name="count" placeholder="Количество" class="number" required="required" min="0">
                                        <button type="submit" class="close" aria-label="Close">
                                            <span aria-hidden="true">+</span>
                                        </button>
                                    </form>

                                    <h5 class="card-title">Книга
                                        : {{ $item -> name }}</h5>
                                    <p class="card-text">Жанр: {{ $item -> description }}</p>
                                    <p class="cart-text">Цена: {{ $item -> price }}</p>
                                    <a href="item/{{ $item -> id  }}" class="btn btn-primary">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change the password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('change-password') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputPassword1">New password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required="required" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
