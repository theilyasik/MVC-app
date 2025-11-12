@extends('layout')

@section('content')
  <h1>Сеансы</h1>

  {{-- Панель управления: выбор количества на странице + (для авторизованных) кнопка создания --}}
  <div style="display:flex; gap:16px; align-items:center; margin-bottom:16px;">
    <form action="{{ route('sessions.index') }}" method="GET">
      <label for="perpage">На странице:</label>
      <select name="perpage" id="perpage" onchange="this.form.submit()">
        @php $pp = (int) request('perpage', 10); @endphp
        @foreach([5,10,15,20,50] as $opt)
          <option value="{{ $opt }}" {{ $pp === $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
      </select>

      {{-- Сохраняем прочие GET-параметры, если появятся в будущем --}}
      @foreach(request()->except('perpage','page') as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <noscript><button type="submit">Показать</button></noscript>
    </form>

    @auth
      <a href="{{ route('sessions.create') }}">+ Создать сеанс</a>
    @endauth
  </div>

  {{-- Сообщение об успехе --}}
  @if(session('success'))
    <div style="color: green; margin-bottom:12px;">{{ session('success') }}</div>
  @endif

  @if($sessions->count() === 0)
    <p>Пока нет сеансов.</p>
  @else
    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Клиент</th>
          <th>Косметолог</th>
          <th>Время</th>
          <th>Услуги</th>
          <th style="width:200px;">Действия</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sessions as $s)
          <tr>
            <td><a href="{{ route('sessions.show', $s->id) }}">#{{ $s->id }}</a></td>
            <td>{{ optional($s->client)->full_name ?? '—' }}</td>
            <td>{{ optional($s->cosmetologist)->full_name ?? '—' }}</td>
            <td>{{ $s->starts_at }} → {{ $s->ends_at }}</td>
            <td>
              @if($s->services->isNotEmpty())
                @foreach($s->services as $srv)
                  {{ $srv->name }} (x{{ $srv->pivot->quantity }})@if(!$loop->last), @endif
                @endforeach
              @else
                —
              @endif
            </td>
            <td>
            @auth
              @can('edit-session', $s)
                <a href="{{ route('sessions.edit', $s->id) }}">Редактировать</a>
              @endcan

              @can('delete-session', $s)
                &nbsp;|&nbsp;
                <form action="{{ route('sessions.destroy', $s->id) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Удалить этот сеанс?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit">Удалить</button>
                </form>
             @endcan
            @else
    —
            @endauth
          </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div style="margin-top:16px;">
      {{ $sessions->links() }}
    </div>
  @endif
@endsection
