<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>@yield('title', 'Beauty Salon')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <header>
    <nav>
      <a href="{{ url('/clients') }}">Клиенты</a> |
      <a href="{{ url('/cosmetologists') }}">Косметологи</a> |
      <a href="{{ url('/services') }}">Услуги</a>
    </nav>
  </header>

  <main style="padding:1rem;">
    @yield('content')
  </main>
</body>
</html>
