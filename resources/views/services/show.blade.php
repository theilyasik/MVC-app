@extends('layout')

@section('title', 'Услуга: '.$service->name)

@section('content')
    @php
        $statusLabels = [
            'scheduled' => 'Запланирован',
            'done'       => 'Проведён',
            'canceled'   => 'Отменён',
            'no_show'    => 'Не явился',
        ];
    @endphp

    <div class="row justify-content-center mb-5">
        <div class="col-xl-9 col-lg-10">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-6 p-5">
                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Услуга салона</span>
                        <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">{{ $service->name }}</h1>
                        <ul class="list-unstyled text-muted small mb-4">
                            <li class="mb-2"><i class="bi bi-cash-stack me-2 text-primary"></i> Стоимость: <strong class="text-dark">{{ number_format($service->price_cents / 100, 2, ',', ' ') }} ₽</strong></li>
                            <li class="mb-2"><i class="bi bi-clock me-2 text-primary"></i> Длительность: <strong class="text-dark">{{ $service->duration_minutes }} минут</strong></li>
                            <li><i class="bi bi-circle-fill me-2 {{ $service->is_active ? 'text-success' : 'text-secondary' }}"></i> {{ $service->is_active ? 'Активна в прайс-листе' : 'Временно недоступна' }}</li>
                        </ul>
                        <p class="text-muted mb-0">Следите за популярностью процедуры и просматривайте записи клиентов, в рамках которых была заказана услуга.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="ratio ratio-4x3">
                            <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80" class="w-100 h-100 object-fit-cover" alt="Процедура в салоне">
                        </div>
                    </div>
                </div>
            </div>

            @auth
                @if($service->sessions->isEmpty())
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-5 text-center text-muted">
                            Пока нет сеансов с этой услугой. Добавьте её в расписание, чтобы отслеживать востребованность.
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0 px-4 px-md-5 pt-4">
                            <h2 class="h4 fw-semibold mb-1" style="color: var(--brand-primary);">Сеансы с услугой «{{ $service->name }}»</h2>
                            <p class="text-muted small mb-0">Каждая запись содержит информацию о клиенте, косметологе и количестве оказанных процедур.</p>
                        </div>
                        <div class="card-body px-4 px-md-5">
                            <div class="list-group list-group-flush">
                                @foreach($service->sessions as $session)
                                    <div class="list-group-item px-0 py-4">
                                        <div class="d-flex flex-column flex-md-row gap-3 align-items-md-start justify-content-between">
                                            <div>
                                                <a href="{{ route('sessions.show', $session->id) }}" class="text-decoration-none">
                                                    <h3 class="h5 fw-semibold mb-1" style="color: var(--brand-primary);">{{ $session->starts_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY, HH:mm') }}</h3>
                                                </a>
                                                <div class="text-muted small mb-3">до {{ $session->ends_at->locale(app()->getLocale())->isoFormat('HH:mm') }} · Кабинет {{ $session->room ?? 'не указан' }}</div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill text-bg-light" style="color: var(--brand-primary);">Клиент: {{ optional($session->client)->full_name ?? '—' }}</span>
                                                    <span class="badge rounded-pill text-bg-light">Косметолог: {{ optional($session->cosmetologist)->full_name ?? '—' }}</span>
                                                    <span class="badge rounded-pill text-bg-light">Статус: {{ $statusLabels[$session->status] ?? $session->status }}</span>
                                                    <span class="badge badge-soft rounded-pill px-3 py-2">Количество: ×{{ $session->pivot->quantity }}</span>
                                                    <span class="badge badge-soft rounded-pill px-3 py-2">Цена: {{ number_format($session->pivot->unit_price_cents / 100, 2, ',', ' ') }} ₽</span>
                                                </div>
                                            </div>
                                            <div class="text-md-end">
                                                <a href="{{ route('sessions.show', $session->id) }}" class="btn btn-outline-secondary rounded-pill">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5 text-center text-muted">
                        История сеансов доступна после входа в систему.
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection
