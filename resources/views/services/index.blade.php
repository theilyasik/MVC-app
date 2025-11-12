@extends('layout')

@section('content')
  <h1>Услуги</h1>

  {{-- Панель: выбор "сколько на странице" --}}
  <div style="display:flex; gap:16px; align-items:center; margin-bottom:16px;">
    <form action="{{ route('services.index') }}" method="GET">
      <label for="perpage">На странице:</label>
      @php $pp = (int) request('perpage', 10); @endphp
      <select name="perpage" id="perpage" onchange="this.form.submit()">
        @foreach([5,10,15,20,50] as $opt)
          <option value="{{ $opt }}" {{ $pp === $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
      </select>

      {{-- Сохраняем прочие GET-параметры, если появятся --}}
      @foreach(request()->except('perpage','page') as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach

      <noscript><button type="submit">Показать</button></noscript>
    </form>
  </div>

  @if($services->count() === 0)
    <p>Пока услуг нет.</p>
  @else
    <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Название</th>
          <th>Базовая цена</th>
          <th>Длительность</th>
          <th>Статус</th>
          <th>Число сеансов</th>
          <th>Открыть</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $s)
          <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->name }}</td>
            <td>{{ number_format($s->price_cents/100, 2, ',', ' ') }} ₽</td>
            <td>{{ $s->duration_minutes }} мин.</td>
            <td>{{ $s->is_active ? 'активна' : 'неактивна' }}</td>
            <td>{{ $s->sessions_count ?? $s->sessions()->count() }}</td>
            <td>
              <a href="{{ route('services.show', $s->id) }}">Открыть</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div style="margin-top:16px;">
      {{ $services->links() }}
    </div>
  @endif
@endsection
