<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beauty Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #5f3d9c;
            --brand-primary-light: #bfa1e0;
            --brand-accent: #d77fa1;
            --brand-beige: #fcefeb;
        }

        body {
            font-family: 'Manrope', system-ui, -apple-system, 'Segoe UI', sans-serif;
            background: linear-gradient(180deg, rgba(252, 239, 235, 0.9) 0%, rgba(248, 243, 249, 0.95) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-modern {
            background: linear-gradient(135deg, rgba(252, 239, 235, 0.95), rgba(214, 194, 235, 0.95));
            backdrop-filter: blur(12px);
        }

        .navbar-modern .nav-link,
        .navbar-modern .navbar-brand {
            color: #4b2d80 !important;
            font-weight: 600;
        }

        .navbar-modern .nav-link.active,
        .navbar-modern .nav-link:focus,
        .navbar-modern .nav-link:hover {
            color: var(--brand-primary) !important;
        }

        .btn-brand {
            background: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #fff;
        }

        .btn-brand:hover,
        .btn-brand:focus {
            background: #4b2d80;
            border-color: #4b2d80;
            color: #fff;
        }

        .badge-soft {
            background-color: rgba(95, 61, 156, 0.12);
            color: var(--brand-primary);
        }

        .toast-brand-success {
            background: #f0e6ff;
            color: #2f1a57;
            border-left: 4px solid var(--brand-primary);
        }

        .toast-brand-error {
            background: #fde3ec;
            color: #72163f;
            border-left: 4px solid var(--brand-accent);
        }

        main {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-modern sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            <span class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <span class="fw-bold" style="color: var(--brand-primary);">BS</span>
            </span>
            <span>Beauty Salon</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">Услуги</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/clients') }}">Клиенты</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/cosmetologists') }}">Косметологи</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sessions.index') }}">Сеансы</a></li>
                @endauth
            </ul>
            <div class="d-flex align-items-center gap-3">
                @guest
                    <button class="btn btn-brand rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#authModal">Войти</button>
                @endguest

                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle rounded-pill px-4" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2">{{ auth()->user()->name ?? auth()->user()->email }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                            <li class="px-3 py-2 text-muted small">{{ auth()->user()->email }}</li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/logout') }}">Выйти</a>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        @if(session('success'))
            <div class="toast toast-brand-success shadow-sm" role="alert" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="d-block mb-1">Успешно</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast toast-brand-error shadow-sm" role="alert" data-bs-delay="7000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="d-block mb-1">Ошибка</strong>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
                </div>
            </div>
        @endif
    </div>
</div>

<main class="py-5">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="py-4 bg-white border-top">
    <div class="container text-center text-muted small">
        © {{ date('Y') }} Beauty Salon. Вдохновлено заботой о красоте.
    </div>
</footer>

<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center" style="background: linear-gradient(160deg, rgba(95, 61, 156, 0.85), rgba(215, 127, 161, 0.85));">
                    <div class="text-white text-center p-4">
                        <h3 class="fw-semibold mb-3">Добро пожаловать!</h3>
                        <p class="mb-0">Управляйте расписанием сеансов, клиентами и услугами в одном месте.</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title" id="authModalLabel">Вход в систему</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body pt-0">
                        <form method="post" action="{{ route('auth') }}" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">E-mail</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="loginEmail" name="email" value="{{ old('email') }}" required>
                                <div class="invalid-feedback">
                                    @error('email') {{ $message }} @else Укажите e-mail. @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Пароль</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="loginPassword" name="password" required>
                                <div class="invalid-feedback">
                                    @error('password') {{ $message }} @else Введите пароль. @enderror
                                </div>
                            </div>
                            @error('error')
                                <div class="alert alert-danger small">{{ $message }}</div>
                            @enderror
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-brand rounded-pill py-2">Войти</button>
                            </div>
                            <div class="mt-3 small text-muted">
                                <span class="badge badge-soft rounded-pill px-3 py-2">Для администраторов и сотрудников салона</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toast').forEach(function (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });

        var authModalEl = document.getElementById('authModal');
        if (authModalEl) {
            var shouldOpenAuth = authModalEl.querySelector('.is-invalid') || authModalEl.querySelector('.alert');
            if (shouldOpenAuth) {
                var authModal = new bootstrap.Modal(authModalEl);
                authModal.show();
            }
        }

        document.querySelectorAll('.needs-validation').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@stack('scripts')
</body>
</html>
