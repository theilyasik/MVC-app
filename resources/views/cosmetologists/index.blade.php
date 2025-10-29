@extends('layout')

@section('content')
<h1>Косметологи</h1>
<ul>
  @foreach($cosmetologists as $p)
    <li><a href="{{ url('/cosmetologists/'.$p->id) }}">{{ $p->full_name }}</a></li>
  @endforeach
</ul>
@endsection
