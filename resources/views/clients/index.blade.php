@extends('layout')

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-xl-10 col-lg-11">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-7 p-5">
                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Наши гости</span>
                        <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">Клиентская база салона</h1>
                        <p class="text-muted mb-4">Просматривайте профили гостей, связывайтесь напрямую и узнавайте больше об их предпочтениях. Поддерживайте высокий уровень сервиса на каждом этапе визита.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-emoji-smile text-primary"></i>
                                </div>
                                <div class="small text-muted">{{ $clients->count() }} активных клиентов</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-chat-heart text-primary"></i>
                                </div>
                                <div class="small text-muted">Персональные рекомендации и заметки</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 h-100">
                        <div class="h-100" style="background: linear-gradient(180deg, rgba(95,61,156,0.1), rgba(215,127,161,0.1));">
                            <div class="p-4 p-md-5">
                                <h5 class="fw-semibold mb-3" style="color: var(--brand-primary);">Управление клиентами</h5>
                                <p class="text-muted small mb-4">Напоминайте о сеансах, отслеживайте любимые процедуры и создавайте постоянные связи с гостями салона.</p>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-1">Быстрый доступ</h6>
                                        <p class="text-muted small mb-3">Открывайте карточку клиента, чтобы увидеть историю посещений и активные записи.</p>
                                        <a href="{{ route('sessions.index') }}" class="btn btn-brand btn-sm rounded-pill px-4">К расписанию</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @forelse($clients as $client)
                    <div class="col-xl-4 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-2">Клиент</span>
                                        <h5 class="fw-semibold mb-0" style="color: var(--brand-primary);">{{ $client->full_name }}</h5>
                                    </div>
                                    <a href="{{ url('/clients/'.$client->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">Профиль</a>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center gap-2 text-muted mb-2">
                                        <i class="bi bi-telephone"></i>
                                        <span>{{ $client->phone ?? '—' }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted">
                                        <i class="bi bi-envelope"></i>
                                        <span>{{ $client->email ?? '—' }}</span>
                                    </div>
                                </div>
                                @if ($client->birthdate)
                                    <div class="mb-3 small text-muted">
                                        <i class="bi bi-gift-fill me-2 text-primary"></i> Дата рождения: {{ \Carbon\Carbon::parse($client->birthdate)->translatedFormat('d F Y') }}
                                    </div>
                                @endif
                                <div class="mt-auto">
                                    <a href="{{ route('sessions.index', ['client' => $client->id]) }}" class="text-decoration-none small">
                                        <i class="bi bi-journal-text me-2"></i> Посмотреть сеансы клиента
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-5 text-center text-muted">
                                Пока клиентов нет. Добавьте первого, чтобы начать историю салона.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection