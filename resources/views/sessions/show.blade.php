@extends('layout')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
  <div>
    <a href="{{ route('sessions.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
      <i class="bi bi-arrow-left"></i>
      Назад к списку
    </a>
    <h1 class="h3 fw-semibold mt-3 mb-0">Сеанс #{{ $session->id }}</h1>
    <p class="text-muted mb-0">Детальная информация о визите клиента</p>
  </div>
  <div class="text-end">
    <span class="badge rounded-pill text-bg-light border border-2 px-3 py-2 text-uppercase small fw-semibold">
      {{ $session->status }}
    </span>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div>
            <div class="text-muted text-uppercase small">Клиент</div>
            <div class="fw-semibold">{{ optional($session->client)->full_name ?? '—' }}</div>
          </div>
          <div class="text-end">
            <div class="text-muted text-uppercase small">Кабинет</div>
            <div class="fw-semibold">{{ $session->room ?? '—' }}</div>
          </div>
        </div>

        <dl class="row gy-3 mb-0">
          <dt class="col-5 text-muted small">Косметолог</dt>
          <dd class="col-7 mb-0 fw-medium">{{ optional($session->cosmetologist)->full_name ?? '—' }}</dd>

          <dt class="col-5 text-muted small">Время</dt>
          <dd class="col-7 mb-0 fw-medium">
            {{ $session->starts_at }}<br>
            <span class="text-muted">→ {{ $session->ends_at }}</span>
          </dd>

          <dt class="col-5 text-muted small">Заметки</dt>
          <dd class="col-7 mb-0">
            <div class="p-3 bg-light rounded-3 border" style="border-style: dashed;">
              {{ $session->notes ?? 'Нет заметок' }}
            </div>
          </dd>
        </dl>
      </div>
      @canany(['edit-session', 'delete-session'], $session)
        <div class="card-footer bg-white border-0 pt-0">
          <div class="d-flex flex-wrap gap-2">
            @can('edit-session', $session)
              <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-brand btn-sm rounded-pill px-3">
                <i class="bi bi-pencil"></i>
                Редактировать
              </a>
            @endcan

            @can('delete-session', $session)
              <form action="{{ route('sessions.destroy', $session->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Удалить этот сеанс?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                  <i class="bi bi-trash"></i>
                  Удалить
                </button>
              </form>
            @endcan
          </div>
        </div>
      @endcanany
    </div>
  </div>

  <div class="col-lg-7">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h2 class="h5 fw-semibold mb-0">Оказанные услуги</h2>
          <span class="badge bg-white text-secondary border">{{ $session->services->count() }} шт.</span>
        </div>

        @if($session->services->isEmpty())
          <div class="text-center py-5">
            <i class="bi bi-card-checklist display-5 text-muted"></i>
            <p class="mt-3 mb-0 text-muted">Услуги не были добавлены к этому сеансу.</p>
          </div>
        @else
          <div class="table-responsive rounded-3 border">
            <table class="table align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th scope="col">Услуга</th>
                  <th scope="col" class="text-center">Кол-во</th>
                  <th scope="col" class="text-end">Цена за единицу</th>
                  <th scope="col" class="text-end">Сумма</th>
                </tr>
              </thead>
              <tbody>
                @foreach($session->services as $service)
                  @php
                    $qty  = $service->pivot->quantity;
                    $unit = $service->pivot->unit_price_cents;
                    $sum  = $qty * $unit;
                  @endphp
                  <tr>
                    <td class="fw-medium">{{ $service->name }}</td>
                    <td class="text-center">{{ $qty }}</td>
                    <td class="text-end">{{ number_format($unit/100, 2, ',', ' ') }} ₽</td>
                    <td class="text-end fw-semibold">{{ number_format($sum/100, 2, ',', ' ') }} ₽</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-end mt-4">
            <div class="text-end">
              <div class="text-muted small text-uppercase">Итого</div>
              <div class="display-6 fw-semibold" style="font-size: 1.75rem;">
                {{ number_format(($totalCents ?? 0)/100, 2, ',', ' ') }} ₽
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
