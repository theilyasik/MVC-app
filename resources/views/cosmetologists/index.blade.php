@extends('layout')

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-xl-10 col-lg-11">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-6 p-5">
                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Команда салона</span>
                        <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">Наши косметологи</h1>
                        <p class="text-muted mb-4">Эксперты, которые создают красоту каждый день. Ознакомьтесь со специализациями и назначайте процедуры исходя из опыта мастеров.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="bi bi-award text-primary"></i>
                                </div>
                                <div class="small text-muted">Профессиональная сертификация</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                     style="width: 48px; height: 48px;">
                                    <i class="bi bi-stars text-primary"></i>
                                </div>
                                <div class="small text-muted">Уникальные техники и подход</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ratio ratio-4x3">
                            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80" class="w-100 h-100 object-fit-cover" alt="Команда косметологов">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @forelse($cosmetologists as $person)
                    <div class="col-xl-4 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-start gap-3 mb-3">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                         style="width: 56px; height: 56px;">
                                        <i class="bi bi-person-bounding-box fs-4" style="color: var(--brand-primary);"></i>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-2">Косметолог</span>
                                        <h5 class="fw-semibold mb-0" style="color: var(--brand-primary);">{{ $person->full_name }}</h5>
                                        @if ($person->specialization)
                                            <div class="small text-muted">{{ $person->specialization }}</div>
                                        @endif
                                    </div>
                                </div>
                                @if ($person->phone || $person->email)
                                    <div class="mb-3">
                                        @if ($person->phone)
                                            <div class="d-flex align-items-center gap-2 text-muted mb-2">
                                                <i class="bi bi-telephone"></i>
                                                <span>{{ $person->phone }}</span>
                                            </div>
                                        @endif
                                        @if ($person->email)
                                            <div class="d-flex align-items-center gap-2 text-muted">
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ $person->email }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <div class="mt-auto">
                                    <a href="{{ url('/cosmetologists/'.$person->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">Профиль специалиста</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-5 text-center text-muted">
                                Пока косметологов нет. Добавьте специалистов, чтобы клиенты могли записываться.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection