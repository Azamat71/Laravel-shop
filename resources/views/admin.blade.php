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

    </style>
</head>

<body>
    <div id="app">
        <header class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                   <a class="navbar-text" href="/">Главная</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarText">
                        <div class="d-flex align-items-center ml-auto">
                            @if (!session() -> get('user'))
                                <a href="/login">Login</a>
                                <a href="/registration" class="ml-3">Зарегистрироваться</a>
                            @elseif (session() -> get('user') && (session() -> get('user'))['type'] == 1)

                                <a href="/admin/history" class="mx-3">Все заказы</a>

                                <form action="{{ route('logout') }}" method="post" class="ml-4">
                                    {{ csrf_field() }}
                                    <button type="submit">
                                        Выйти
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('logout') }}" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit">
                                        Logout
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <section class="main">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="main__block">
                            <h4 class="text-center mb-3">Добавить продукт</h4>

                            <form class="form" role="form" method="POST" action="{{ route('admin') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Категория: </label>
                                    <input type="number" name="category" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Категория продукта" autocomplete="off" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Название: </label>
                                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Название продукта" autocomplete="off" required="required">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Описание</label>
                                    <textarea type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="Опишите продукт" autocomplete="off" required="required"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Цена</label>
                                    <input type="number" name="price" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Введите цену" autocomplete="off" required="required">
                                </div>

                                <button type="submit" class="btn btn-primary mt-2" style="margin-bottom: 25px">Добавить продукт</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="main__block">
                            <h4 class="text-center mb-3">Весь ассортимент</h4>

                            <ul>
                                @foreach ($items as $item)
                                    <div class="card w-100 mb-3">
                                        <div class="card-body">
                                            <form action="{{ route('admin-remove', ['id' => $item -> id]) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="close" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </form>

                                            <h5 class="card-title">{{ $item -> name }}</h5>
                                            <p class="card-text">{{ $item -> category }}</p>
                                            <p class="card-text">{{ $item -> description }}</p>
                                            <p class="cart-text">Цена: {{ $item -> price }}</p>
                                            <a href="item/{{ $item -> id  }}" class="btn btn-primary">Подробнее</a>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
