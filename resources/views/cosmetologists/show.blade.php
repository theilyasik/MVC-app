@extends('layout')

@section('content')
<h1>Косметолог: {{ $cosmetologist->full_name }}</h1>

<h2>Сеансы</h2>
@if($cosmetologist->sessions->isEmpty())
  <p>Сеансов нет.</p>
@else
  <ul>
    @foreach($cosmetologist->sessions as $s)
      <li>
        <a href="{{ url('/sessions/'.$s->id) }}">
          {{ $s->starts_at }} → {{ $s->ends_at }} ({{ $s->status }})
        </a>
        — Клиент: {{ optional($s->client)->full_name }}
      </li>
    @endforeach
  </ul>
@endif
@endsection
