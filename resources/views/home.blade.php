@extends('layout')

@section('content')
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6">
            <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Современный салон</span>
            <h1 class="display-5 fw-bold" style="color: var(--brand-primary);">Красота начинается с идеального расписания</h1>
            <p class="lead text-muted">Управляйте записями клиентов, услугами и командой косметологов в едином пространстве. Профессиональный опыт начинается с первой записи.</p>
            <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                <a href="{{ route('sessions.index') }}" class="btn btn-brand btn-lg rounded-pill px-4 shadow-sm">
                    <i class="bi bi-calendar-heart me-2"></i> Перейти к расписанию
                </a>
                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                    <i class="bi bi-stars me-2"></i> Посмотреть услуги
                </a>
            </div>
            <div class="d-flex align-items-center gap-4 mt-5">
                <div class="d-flex align-items-center gap-3">
                    <span class="display-6 fw-bold" style="color: var(--brand-primary);">1200+</span>
                    <div class="text-muted small">Довольных клиентов доверяют нашему салону ежедневно.</div>
                </div>
                <div class="vr d-none d-lg-block" style="height: 70px;"></div>
                <div class="d-flex align-items-center gap-3">
                    <span class="display-6 fw-bold" style="color: var(--brand-primary);">15</span>
                    <div class="text-muted small">Сертифицированных косметологов в команде.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative">
                <div class="ratio ratio-4x3 rounded-4 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80" alt="Салон красоты" class="w-100 h-100 object-fit-cover">
                </div>
                <div class="card border-0 shadow position-absolute bottom-0 start-0 translate-middle-y" style="max-width: 280px; background: rgba(255,255,255,0.95);">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-2" style="color: var(--brand-primary);">Привилегии клуба</h5>
                        <p class="card-text text-muted small mb-3">Автоматические напоминания, персонализированные процедуры и стильный сервис.</p>
                        <ul class="list-unstyled small mb-0">
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check2-circle text-success"></i> Индивидуальные предложения</li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check2-circle text-success"></i> Онлайн-управление расписанием</li>
                            <li class="d-flex align-items-center gap-2"><i class="bi bi-check2-circle text-success"></i> Команда экспертов</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="icon-square bg-light text-primary rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <h5 class="fw-semibold" style="color: var(--brand-primary);">CRM для клиентов</h5>
                    <p class="text-muted">Создавайте профили клиентов, отслеживайте историю посещений и персональные предпочтения.</p>
                    <a href="{{ url('/clients') }}" class="text-decoration-none">Посмотреть клиентов <i class="bi bi-arrow-right-short"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="icon-square bg-light text-primary rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-person-hearts fs-4"></i>
                    </div>
                    <h5 class="fw-semibold" style="color: var(--brand-primary);">Команда профессионалов</h5>
                    <p class="text-muted">Отслеживайте расписание косметологов и распределяйте процедуры по специализациям.</p>
                    <a href="{{ url('/cosmetologists') }}" class="text-decoration-none">Наша команда <i class="bi bi-arrow-right-short"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="icon-square bg-light text-primary rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-flower1 fs-4"></i>
                    </div>
                    <h5 class="fw-semibold" style="color: var(--brand-primary);">Меню услуг</h5>
                    <p class="text-muted">Поддерживайте актуальное меню процедур с ценами, длительностью и статусами.</p>
                    <a href="{{ url('/services') }}" class="text-decoration-none">Каталог процедур <i class="bi bi-arrow-right-short"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="row g-0 align-items-center">
            <div class="col-lg-7 p-5">
                <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Для администраторов</span>
                <h2 class="fw-semibold mb-3" style="color: var(--brand-primary);">Контроль качества сервиса</h2>
                <p class="text-muted mb-4">Следите за статусами сеансов, собирайте отзывы клиентов и отслеживайте эффективность команды. Встроенные отчёты помогают принимать решения оперативно.</p>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-pie-chart-fill text-primary"></i>
                        </div>
                        <div class="small text-muted">Аналитика сеансов и загрузки.</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-chat-dots-fill text-primary"></i>
                        </div>
                        <div class="small text-muted">Персональные рекомендации клиентам.</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="h-100" style="background: linear-gradient(160deg, rgba(95,61,156,0.15), rgba(215,127,161,0.15));">
                    <div class="p-5">
                        <h4 class="fw-semibold mb-3" style="color: var(--brand-primary);">Экосистема салона</h4>
                        <ul class="list-unstyled text-muted small mb-4">
                            <li class="mb-2"><i class="bi bi-circle-fill me-2 text-primary" style="font-size: 0.5rem;"></i> Интеграция с расписанием косметологов</li>
                            <li class="mb-2"><i class="bi bi-circle-fill me-2 text-primary" style="font-size: 0.5rem;"></i> Управление услугами и пакетами процедур</li>
                            <li class="mb-2"><i class="bi bi-circle-fill me-2 text-primary" style="font-size: 0.5rem;"></i> Уведомления о важных событиях</li>
                        </ul>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-1">Готовы начать?</h6>
                                <p class="text-muted small mb-3">Войдите, чтобы управлять расписанием и услугами салона.</p>
                                @guest
                                    <button class="btn btn-brand rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#authModal">Войти</button>
                                @else
                                    <a href="{{ route('sessions.index') }}" class="btn btn-brand rounded-pill w-100">Перейти к сеансам</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection