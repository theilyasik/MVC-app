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

           @auth
                @php $clientFormErrors = $errors->createClient; @endphp
                <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, rgba(252,239,235,0.9), rgba(214,194,235,0.7));">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-5">
                                <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Новый гость салона</span>
                                <h2 class="fw-semibold mb-3" style="color: var(--brand-primary);">Добавьте клиента</h2>
                                <p class="text-muted small mb-4">Заполните контактные данные, чтобы напоминать о визитах и сохранять историю общения.</p>
                                @if($clientFormErrors->any())
                                    <div class="alert alert-danger border-0 shadow-sm small mb-0">
                                        <strong class="d-block mb-1">Проверьте введённые данные:</strong>
                                        <ul class="mb-0 ps-3">
                                            @foreach($clientFormErrors->all() as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-7">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <form action="{{ route('clients.store') }}" method="POST" class="needs-validation" novalidate>
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="client_full_name" class="form-label">ФИО <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                           id="client_full_name"
                                                           name="full_name"
                                                           value="{{ old('full_name') }}"
                                                           class="form-control @error('full_name','createClient') is-invalid @enderror"
                                                           placeholder="Например, Анна Петрова"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        @error('full_name','createClient') {{ $message }} @else Укажите полное имя клиента. @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="client_phone" class="form-label">Телефон <span class="text-danger">*</span></label>
                                                    <input type="tel"
                                                           id="client_phone"
                                                           name="phone"
                                                           value="{{ old('phone') }}"
                                                           class="form-control @error('phone','createClient') is-invalid @enderror"
                                                           placeholder="+7 (999) 123-45-67"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        @error('phone','createClient') {{ $message }} @else Добавьте номер для связи. @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="client_email" class="form-label">E-mail</label>
                                                    <input type="email"
                                                           id="client_email"
                                                           name="email"
                                                           value="{{ old('email') }}"
                                                           class="form-control @error('email','createClient') is-invalid @enderror"
                                                           placeholder="client@example.com">
                                                    <div class="invalid-feedback">
                                                        @error('email','createClient') {{ $message }} @else Укажите e-mail для напоминаний (необязательно). @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="client_notes" class="form-label">Заметки</label>
                                                    <textarea id="client_notes"
                                                              name="notes"
                                                              rows="3"
                                                              class="form-control @error('notes','createClient') is-invalid @enderror"
                                                              placeholder="Предпочитаемые процедуры, важные детали">{{ old('notes') }}</textarea>
                                                    <div class="invalid-feedback">
                                                        @error('notes','createClient') {{ $message }} @else Добавьте памятку для команды (необязательно). @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-brand rounded-pill px-4">Сохранить клиента</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-light border-0 shadow-sm mb-4 d-flex align-items-center gap-3">
                    <i class="bi bi-lock text-primary fs-4"></i>
                    <div>
                        <div class="fw-semibold">Авторизуйтесь, чтобы добавлять клиентов</div>
                        <div class="small text-muted">Войдите как сотрудник салона через кнопку «Войти», чтобы открылась форма добавления.</div>
                    </div>
                </div>
            @endauth
            
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
                                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">Профиль</a>                                </div>
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