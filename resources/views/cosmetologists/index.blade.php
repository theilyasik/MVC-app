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

            @auth
                @php $cosmetologistFormErrors = $errors->createCosmetologist; @endphp
                <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, rgba(214,194,235,0.85), rgba(215,127,161,0.6));">
                    <div class="card-body p-4 p-lg-5">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-5 text-white">
                                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(255,255,255,0.25);">Новый специалист</span>
                                <h2 class="fw-semibold mb-3">Добавьте косметолога</h2>
                                <p class="small mb-4">Заполните профиль мастера, чтобы он появлялся в расписании и был доступен для записи клиентов.</p>
                                @if($cosmetologistFormErrors->any())
                                    <div class="alert alert-light border-0 shadow-sm small mb-0 text-start">
                                        <strong class="d-block mb-1">Проверьте данные:</strong>
                                        <ul class="mb-0 ps-3">
                                            @foreach($cosmetologistFormErrors->all() as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-7">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body p-4">
                                        <form action="{{ route('cosmetologists.store') }}" method="POST" class="needs-validation" novalidate>
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="cosmetologist_full_name" class="form-label">ФИО <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                           id="cosmetologist_full_name"
                                                           name="full_name"
                                                           value="{{ old('full_name') }}"
                                                           class="form-control @error('full_name','createCosmetologist') is-invalid @enderror"
                                                           placeholder="Например, Ольга Смирнова"
                                                           required>
                                                    <div class="invalid-feedback">
                                                        @error('full_name','createCosmetologist') {{ $message }} @else Укажите имя специалиста. @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cosmetologist_specialization" class="form-label">Специализация</label>
                                                    <input type="text"
                                                           id="cosmetologist_specialization"
                                                           name="specialization"
                                                           value="{{ old('specialization') }}"
                                                           class="form-control @error('specialization','createCosmetologist') is-invalid @enderror"
                                                           placeholder="Например, уход за лицом">
                                                    <div class="invalid-feedback">
                                                        @error('specialization','createCosmetologist') {{ $message }} @else Уточните основное направление (необязательно). @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cosmetologist_phone" class="form-label">Телефон</label>
                                                    <input type="tel"
                                                           id="cosmetologist_phone"
                                                           name="phone"
                                                           value="{{ old('phone') }}"
                                                           class="form-control @error('phone','createCosmetologist') is-invalid @enderror"
                                                           placeholder="+7 (900) 000-00-00">
                                                    <div class="invalid-feedback">
                                                        @error('phone','createCosmetologist') {{ $message }} @else Добавьте номер для связи (необязательно). @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cosmetologist_email" class="form-label">E-mail</label>
                                                    <input type="email"
                                                           id="cosmetologist_email"
                                                           name="email"
                                                           value="{{ old('email') }}"
                                                           class="form-control @error('email','createCosmetologist') is-invalid @enderror"
                                                           placeholder="master@example.com">
                                                    <div class="invalid-feedback">
                                                        @error('email','createCosmetologist') {{ $message }} @else Укажите рабочий e-mail (необязательно). @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-brand rounded-pill px-4">Добавить косметолога</button>
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
                        <div class="fw-semibold">Войдите, чтобы пополнить команду</div>
                        <div class="small text-muted">Форма добавления специалистов доступна после авторизации.</div>
                    </div>
                </div>
            @endauth

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
                                    <a href="{{ route('cosmetologists.show', $person->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">Профиль специалиста</a>                                </div>
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