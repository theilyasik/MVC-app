@extends('layout')

@section('content')
  <h1>Сеансы</h1>

  <p>
    <a href="{{ route('sessions.create') }}">+ Создать сеанс</a>
  </p>

  @if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
  @endif

  @if($sessions->isEmpty())
    <p>Пока нет сеансов.</p>
  @else
    <ul>
      @foreach($sessions as $s)
        <li>
          <a href="{{ route('sessions.show', $s->id) }}">Сеанс #{{ $s->id }}</a>
          — {{ optional($s->client)->full_name ?? 'без клиента' }}
          / {{ optional($s->cosmetologist)->full_name ?? 'без косметолога' }}
          / {{ $s->starts_at }} → {{ $s->ends_at }}

          {{-- КНОПКИ --}}
          &nbsp; | &nbsp;
          <a href="{{ route('sessions.edit', $s->id) }}">Редактировать</a>

          <form action="{{ route('sessions.destroy', $s->id) }}"
                method="POST"
                style="display:inline"
                onsubmit="return confirm('Удалить этот сеанс?');">
            @csrf
            @method('DELETE')
            <button type="submit">Удалить</button>
          </form>

          @if($s->services->isNotEmpty())
            — услуги:
            @foreach($s->services as $srv)
              {{ $srv->name }} (x{{ $srv->pivot->quantity }})
              @if(!$loop->last), @endif
            @endforeach
          @endif
        </li>
      @endforeach
    </ul>
  @endif
@endsection
