<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Beauty Salon</title>
  <style>
    nav { display:flex; justify-content:space-between; align-items:center; }
    .nav-left a, .nav-right a { margin-right:10px; text-decoration:none; color:#553c9a; font-weight:bold; }
    .nav-left a:hover, .nav-right a:hover { text-decoration:underline; }
    .error { color:#b00020; }
    .success { color:green; }
  </style>
</head>
<body>
  <nav>
    <div class="nav-left">
      <a href="{{ url('/') }}">Главная</a> |
      <a href="{{ url('/clients') }}">Клиенты</a> |
      <a href="{{ url('/cosmetologists') }}">Косметологи</a> |
      <a href="{{ url('/services') }}">Услуги</a> |
      <a href="{{ route('sessions.index') }}">Сеансы</a>
    </div>

    <div class="nav-right">
      @guest
        <a href="{{ route('login') }}">Войти</a>
      @endguest

      @auth
        <span>Привет, {{ auth()->user()->name ?? auth()->user()->email }}!</span>
        <a href="{{ url('/logout') }}">Выйти</a>
      @endauth
    </div>
  </nav>
  <hr>

  @if(session('success'))
    <p class="success">{{ session('success') }}</p>
  @endif

  @if(session('error'))
    <p class="error">{{ session('error') }}</p>
  @endif

  @yield('content')
</body>
</html>
