@extends('layout')

@section('title', 'Косметолог: '.$cosmetologist->full_name)

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
                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Специалист</span>
                        <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">{{ $cosmetologist->full_name }}</h1>
                        <p class="text-muted mb-4">Ведущий мастер салона. Ниже представлены предстоящие и прошедшие процедуры с участием специалиста.</p>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-person-hearts text-primary"></i>
                                </div>
                                <div class="small text-muted">{{ $cosmetologist->sessions->count() }} активных и архивных сеансов</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-calendar-week text-primary"></i>
                                </div>
                                <div class="small text-muted">Гибкий график, синхронизированный с расписанием салона</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ratio ratio-4x3">
                            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80" class="w-100 h-100 object-fit-cover" alt="Косметолог за работой">
                        </div>
                    </div>
                </div>
            </div>

            @if($cosmetologist->sessions->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5 text-center text-muted">
                        Для этого косметолога пока нет записей. Добавьте сеанс, чтобы сформировать расписание.
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0 px-4 px-md-5 pt-4">
                        <h2 class="h4 fw-semibold mb-1" style="color: var(--brand-primary);">Сеансы косметолога</h2>
                        <p class="text-muted small mb-0">Список отсортирован по времени начала. Откройте карточку, чтобы перейти к подробностям записи.</p>
                    </div>
                    <div class="card-body px-4 px-md-5">
                        <div class="timeline">
                            @foreach($cosmetologist->sessions as $session)
                                <div class="timeline-item py-4 border-bottom">
                                    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center justify-content-between">
                                        <div>
                                            <a href="{{ route('sessions.show', $session->id) }}" class="text-decoration-none">
                                                <h3 class="h5 fw-semibold mb-1" style="color: var(--brand-primary);">{{ $session->starts_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY, HH:mm') }}</h3>
                                            </a>
                                            <div class="text-muted small">до {{ $session->ends_at->locale(app()->getLocale())->isoFormat('HH:mm') }} · Кабинет {{ $session->room ?? 'не указан' }}</div>
                                            <div class="mt-3 d-flex flex-wrap gap-2">
                                                <span class="badge rounded-pill text-bg-light" style="color: var(--brand-primary);">Клиент: {{ optional($session->client)->full_name ?? '—' }}</span>
                                                <span class="badge rounded-pill text-bg-light">Статус: {{ $statusLabels[$session->status] ?? $session->status }}</span>
                                                @foreach($session->services as $service)
                                                    <span class="badge badge-soft rounded-pill px-3 py-2">{{ $service->name }} ×{{ $service->pivot->quantity }}</span>
                                                @endforeach
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
        </div>
    </div>
@endsection
