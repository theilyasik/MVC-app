<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Салон')</title>
  <style>
    body { font-family: system-ui, Arial, sans-serif; max-width: 900px; margin: 24px auto; line-height: 1.5; }
    nav a { margin-right: 8px; }
    hr { margin: 16px 0; }
  </style>
</head>
<body>
  <nav>
    <a href="{{ url('/clients') }}">Клиенты</a> |
    <a href="{{ url('/cosmetologists') }}">Косметологи</a> |
    <a href="{{ url('/services') }}">Услуги</a>
  </nav>
  <hr>
  @yield('content')
</body>
</html>
