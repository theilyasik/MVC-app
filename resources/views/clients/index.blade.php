@extends('layout')

@section('content')
<h1>Клиенты</h1>
<ul>
  @foreach($clients as $c)
    <li>
      <a href="{{ url('/clients/'.$c->id) }}">{{ $c->full_name }}</a>
      — {{ $c->phone }} @if($c->email) / {{ $c->email }} @endif
    </li>
  @endforeach
</ul>
@endsection
