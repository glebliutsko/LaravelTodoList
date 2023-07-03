<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Список задач - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"></head>
<body class="h-100">
    <header class="border-bottom py-3 px-2">
        <div class="w-100 m-auto d-flex align-items-center justify-content-between" style="max-width: 1320px">
            <h1>@yield('title')</h1>

            <nav class="nav nav-pills mx-1">
                @auth
                <li class="nav-item me-3">
                    <a class="btn btn-outline-primary" href="{{ route('tasklists') }}">Задачи</a>
                </li>
                <li class="nav-item me-3">
                    <a class="btn btn-outline-primary" href="{{ route('logout') }}">Выход</a>
                </li>
                @else
                <li class="nav-item me-3">
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">Вход</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-primary" href="{{ route('registration') }}">Регистрация</a>
                </li> 
                @endauth
            </nav>
        </div>
    </header>

    <main class="w-100 pt-5 bg-light" style="min-height: 100%">
        <div class="w-100 m-auto" style="max-width: 1320px">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>