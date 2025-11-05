@extends('layout')

@section('content')
  <h1>Редактировать сеанс #{{ $session->id }}</h1>

  @if ($errors->any())
    <div style="color:red">
      <ul>
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('sessions.update', $session->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
      <label>Клиент</label>
      <select name="client_id" required>
        @foreach($clients as $c)
          <option value="{{ $c->id }}" @selected(old('client_id', $session->client_id)==$c->id)>
            {{ $c->full_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Косметолог</label>
      <select name="cosmetologist_id" required>
        @foreach($cosmetologists as $m)
          <option value="{{ $m->id }}" @selected(old('cosmetologist_id', $session->cosmetologist_id)==$m->id)>
            {{ $m->full_name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Начало</label>
      <input type="datetime-local" name="starts_at"
             value="{{ old('starts_at', \Carbon\Carbon::parse($session->starts_at)->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div>
      <label>Окончание</label>
      <input type="datetime-local" name="ends_at"
             value="{{ old('ends_at', \Carbon\Carbon::parse($session->ends_at)->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div>
      <label>Кабинет</label>
      <input type="text" name="room" value="{{ old('room', $session->room) }}" maxlength="50">
    </div>

    <div>
      <label>Статус</label>
      <select name="status" required>
        @foreach(['scheduled'=>'запланирован','done'=>'проведён','canceled'=>'отменён','no_show'=>'не явился'] as $k=>$v)
          <option value="{{ $k }}" @selected(old('status', $session->status)==$k)>{{ $v }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Заметки</label>
      <textarea name="notes">{{ old('notes', $session->notes) }}</textarea>
    </div>

    <button type="submit">Сохранить</button>
    <a href="{{ route('sessions.index') }}">Отмена</a>
  </form>
@endsection
