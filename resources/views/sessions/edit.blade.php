@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div>
                    <span class="badge badge-soft rounded-pill px-3 py-2 mb-2">Редактирование</span>
                    <h1 class="fw-semibold mb-0" style="color: var(--brand-primary);">Сеанс #{{ $session->id }}</h1>
                    <p class="text-muted mb-0">Обновите данные процедуры, при необходимости скорректируйте статус.</p>
                </div>
                <a href="{{ route('sessions.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Вернуться к списку</a>
            </div>

            <form action="{{ route('sessions.update', $session->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                @include('sessions._form', [
                    'clients' => $clients,
                    'cosmetologists' => $cosmetologists,
                    'session' => $session,
                    'statuses' => [
                        'scheduled' => 'Запланирован',
                        'done' => 'Проведён',
                        'canceled' => 'Отменён',
                        'no_show' => 'Не явился',
                    ],
                    'submitLabel' => 'Сохранить изменения',
                    'title' => 'Редактирование сеанса',
                ])
            </form>
        </div>
    </div>
@endsection
