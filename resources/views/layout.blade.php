<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Beauty Salon</title>
  <style>
    nav a { margin-right: 10px; text-decoration: none; color: #553c9a; font-weight: bold; }
    nav a:hover { text-decoration: underline; }
    .error { color: #b00020; }
  </style>
</head>
<body>
  <nav>
    <a href="{{ url('/') }}">Главная</a> |
    <a href="{{ url('/clients') }}">Клиенты</a> |
    <a href="{{ url('/cosmetologists') }}">Косметологи</a> |
    <a href="{{ url('/services') }}">Услуги</a> |
    <a href="{{ route('sessions.index') }}">Сеансы</a>
  </nav>
  <hr>

  @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
  @endif

  @yield('content')
</body>
</html>

