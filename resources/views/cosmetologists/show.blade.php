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
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ratio ratio-4x3">
                            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80" class="w-100 h-100 object-fit-cover" alt="Косметолог за работой">
                        </div>
                    </div>
                </div>
            </div>