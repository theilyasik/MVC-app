@extends('layout')

@section('content')
    @if($user)
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Вы уже вошли</span>
                        <h2 class="fw-semibold mb-3">Здравствуйте, {{ $user->name ?? $user->email }}</h2>
                        <p class="text-muted mb-4">Используйте навигацию, чтобы управлять данными салона.</p>
                        <a href="{{ url('/') }}" class="btn btn-brand rounded-pill px-4">На главную</a>
                        <a href="{{ route('logout') }}" class="btn btn-outline-secondary rounded-pill px-4 ms-2">Выйти</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">Войти в Beauty Salon</h1>
            <p class="text-muted mb-4">Используйте кнопку ниже, чтобы открыть форму авторизации.</p>
            <button class="btn btn-brand rounded-pill px-5 py-2" data-bs-toggle="modal" data-bs-target="#authModal">Открыть форму</button>
        </div>
    @endif
@endsection

@push('scripts')
    @if(!$user)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var authModalEl = document.getElementById('authModal');
                if (authModalEl) {
                    var authModal = new bootstrap.Modal(authModalEl);
                    authModal.show();
                }
            });
        </script>
    @endif
@endpush
