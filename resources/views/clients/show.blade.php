@extends('layout')

@section('content')
<h1>Клиент: {{ $client->full_name }}</h1>
<p><b>Телефон:</b> {{ $client->phone }}</p>
<p><b>Email:</b> {{ $client->email ?? '—' }}</p>
<p><b>Заметки:</b> {{ $client->notes ?? '—' }}</p>

<hr>
<h2>Сеансы</h2>
@if($client->sessions->isEmpty())
  <p>Сеансов нет.</p>
@else
  <ul>
    @foreach($client->sessions as $s)
      <li>
        <a href="{{ url('/sessions/'.$s->id) }}">
          {{ $s->starts_at }} → {{ $s->ends_at }} ({{ $s->status }})
        </a>
        — Косметолог: {{ optional($s->cosmetologist)->full_name }}
      </li>
    @endforeach
  </ul>
@endif
@endsection
