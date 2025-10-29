<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beauty Salon')</title>
</head>
<body>
    <h2>@yield('page_heading', 'Заголовок')</h2>

    <main>
        @yield('content')
    </main>
</body>
</html>
