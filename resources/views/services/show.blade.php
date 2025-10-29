@extends('layout')

@section('content')
<h1>Услуга: {{ $service->name }}</h1>
<p><b>Базовая цена:</b> {{ number_format($service->price_cents/100, 2, ',', ' ') }} ₽</p>
<p><b>Длительность:</b> {{ $service->duration_minutes }} мин.</p>
<p><b>Активна:</b> {{ $service->is_active ? 'да' : 'нет' }}</p>

<hr>
<h2>Сеансы с этой услугой</h2>
@if($service->sessions->isEmpty())
  <p>Нет сеансов.</p>
@else
  <ul>
    @foreach($service->sessions as $s)
      <li>
        <a href="{{ url('/sessions/'.$s->id) }}">Сеанс #{{ $s->id }}</a> —
        Клиент: {{ optional($s->client)->full_name }},
        Косметолог: {{ optional($s->cosmetologist)->full_name }},
        {{ $s->starts_at }} → {{ $s->ends_at }}
        (x{{ $s->pivot->quantity }},
         {{ number_format($s->pivot->unit_price_cents/100, 2, ',', ' ') }} ₽)
      </li>
    @endforeach
  </ul>
@endif
@endsection
