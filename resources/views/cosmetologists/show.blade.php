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
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge badge-soft rounded-pill px-3 py-2">Специалист</span>
                            @auth
                                <form action="{{ route('cosmetologists.destroy', $cosmetologist->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Удалить косметолога {{ $cosmetologist->full_name }}? Это действие нельзя отменить.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                        <i class="bi bi-trash me-1"></i> Удалить
                                    </button>
                                </form>
                            @endauth
                        </div>
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
                        @if($cosmetologist->specialization)
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-stars text-primary"></i>
                                    </div>
                                    <div class="small text-muted">Специализация: {{ $cosmetologist->specialization }}</div>
                                </div>
                            @endif
                            <div class="d-flex flex-wrap gap-3">
                                @if($cosmetologist->phone)
                                    <span class="badge rounded-pill text-bg-light text-break">Телефон: {{ $cosmetologist->phone }}</span>
                                @endif
                                @if($cosmetologist->email)
                                    <span class="badge rounded-pill text-bg-light text-break">E-mail: {{ $cosmetologist->email }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none d-md-block">
                        <div class="ratio ratio-4x3">
                            <img src="{{ asset('images/cosmetologist-placeholder.svg') }}" class="w-100 h-100 object-fit-cover" alt="Косметологический кабинет">
                        </div>
                    </div>
                </div>
            </div>

            @auth
                @if($cosmetologist->sessions->isEmpty())
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-5 text-center text-muted">
                            Пока нет сеансов, связанных с косметологом. Запланируйте процедуру, чтобы она появилась в истории.
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pb-0 px-4 px-md-5 pt-4">
                            <h2 class="h4 fw-semibold mb-1" style="color: var(--brand-primary);">Сеансы косметолога</h2>
                            <p class="text-muted small mb-0">Актуальные и прошедшие записи с указанием клиента, услуг и статуса.</p>
                        </div>
                        <div class="card-body px-4 px-md-5">
                            <div class="list-group list-group-flush">
                                @foreach($cosmetologist->sessions as $session)
                                    <div class="list-group-item px-0 py-4">
                                        <div class="row g-3 align-items-start">
                                            <div class="col-md">
                                                <a href="{{ route('sessions.show', $session->id) }}" class="text-decoration-none">
                                                    <h3 class="h5 fw-semibold mb-1" style="color: var(--brand-primary);">{{ $session->starts_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY, HH:mm') }}</h3>
                                                </a>
                                                <div class="text-muted small mb-3">до {{ $session->ends_at->locale(app()->getLocale())->isoFormat('HH:mm') }} · Кабинет {{ $session->room ?? 'не указан' }}</div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="badge rounded-pill text-bg-light text-break" style="color: var(--brand-primary);">Клиент: {{ optional($session->client)->full_name ?? '—' }}</span>
                                                    <span class="badge rounded-pill text-bg-light">Статус: {{ $statusLabels[$session->status] ?? $session->status }}</span>
                                                    @if($session->services->isNotEmpty())
                                                        <span class="badge badge-soft rounded-pill px-3 py-2 text-break">Услуги: {{ $session->services->pluck('name')->join(', ') }}</span>
                                                    @else
                                                        <span class="badge badge-soft rounded-pill px-3 py-2">Услуги не указаны</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-auto d-flex align-items-start justify-content-md-end">
                                                <a href="{{ route('sessions.show', $session->id) }}" class="btn btn-outline-secondary rounded-pill px-4 w-100 w-md-auto">Подробнее</a>
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