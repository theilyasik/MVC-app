@extends('layout')

@section('title','Услуги')

@section('content')
<h1>Услуги</h1>

@if($services->isEmpty())
  <p>Записей нет.</p>
@else
  <ul>
    @foreach($services as $s)
      <li>
        <a href="{{ url('/services/'.$s->id) }}">{{ $s->name }}</a>
        — {{ number_format($s->price_cents/100, 2, ',', ' ') }} ₽,
        {{ $s->duration_minutes }} мин.
        ({{ $s->is_active ? 'активна' : 'скрыта' }})
      </li>
    @endforeach
  </ul>
@endif
@endsection
