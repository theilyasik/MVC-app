@extends('layout')

@section('content')
<h1>Сеанс #{{ $session->id }}</h1>

<p><b>Клиент:</b> {{ optional($session->client)->full_name }}</p>
<p><b>Косметолог:</b> {{ optional($session->cosmetologist)->full_name }}</p>
<p><b>Время:</b> {{ $session->starts_at }} → {{ $session->ends_at }}</p>
<p><b>Кабинет:</b> {{ $session->room ?? '—' }}</p>
<p><b>Статус:</b> {{ $session->status }}</p>
<p><b>Заметки:</b> {{ $session->notes ?? '—' }}</p>

{{-- Действия над сеансом — только по правам --}}
<div style="margin:10px 0;">
  @can('edit-session', $session)
    <a href="{{ route('sessions.edit', $session->id) }}">Редактировать</a>
  @endcan

  @can('edit-session', $session)
    @can('delete-session', $session)
      &nbsp;|&nbsp;
    @endcan
  @endcan

  @can('delete-session', $session)
    <form action="{{ route('sessions.destroy', $session->id) }}"
          method="POST" style="display:inline"
          onsubmit="return confirm('Удалить этот сеанс?');">
      @csrf
      @method('DELETE')
      <button type="submit">Удалить</button>
    </form>
  @endcan
</div>

<hr>
<h2>Оказанные услуги</h2>
@if($session->services->isEmpty())
  <p>Нет услуг.</p>
@else
  <table border="1" cellpadding="6">
    <tr>
      <th>Услуга</th>
      <th>Кол-во</th>
      <th>Цена за единицу</th>
      <th>Сумма</th>
    </tr>
    @foreach($session->services as $service)
      @php
        $qty  = $service->pivot->quantity;
        $unit = $service->pivot->unit_price_cents;
        $sum  = $qty * $unit;
      @endphp
      <tr>
        <td>{{ $service->name }}</td>
        <td>{{ $qty }}</td>
        <td>{{ number_format($unit/100, 2, ',', ' ') }} ₽</td>
        <td>{{ number_format($sum/100, 2, ',', ' ') }} ₽</td>
      </tr>
    @endforeach
  </table>

  <h3 style="margin-top:12px">
    Итого: {{ number_format(($totalCents ?? 0)/100, 2, ',', ' ') }} ₽
  </h3>
@endif
@endsection
