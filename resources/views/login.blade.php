<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <style>.is-invalid{color:red}</style>
</head>
<body>
@if($user)
  <h2>Здравствуйте, {{ $user->name ?? $user->email }}</h2>
  <p><a href="{{ route('logout') }}">Выйти из системы</a></p>
@else
  <h2>Вход в систему</h2>
  <form method="post" action="{{ route('auth') }}">
    @csrf

    <label>E-mail</label>
    <input type="text" name="email" value="{{ old('email') }}">
    @error('email') <div class="is-invalid">{{ $message }}</div> @enderror
    <br>

    <label>Пароль</label>
    <input type="password" name="password" value="{{ old('password') }}">
    @error('password') <div class="is-invalid">{{ $message }}</div> @enderror
    <br>

    <input type="submit" value="Отправить">

    @error('error') <div class="is-invalid">{{ $message }}</div> @enderror
  </form>
@endif
</body>
</html>
