@extends('layout')

@section('content')
  <h1>Услуги</h1>
  @if($services->isEmpty())
    <p>Пока услуг нет.</p>
  @else
    <ul>
      @foreach($services as $s)
        <li>
          <a href="{{ route('services.show', $s->id) }}">{{ $s->name }}</a>
          — {{ number_format($s->price_cents/100, 2, ',', ' ') }} ₽,
          {{ $s->duration_minutes }} мин.
          ({{ $s->is_active ? 'активна' : 'неактивна' }})
        </li>
      @endforeach
    </ul>
  @endif
@endsection
