@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div>
                    <span class="badge badge-soft rounded-pill px-3 py-2 mb-2">Новый сеанс</span>
                    <h1 class="fw-semibold mb-0" style="color: var(--brand-primary);">Создание сеанса</h1>
                    <p class="text-muted mb-0">Добавьте клиента, выберите косметолога и укажите детали процедуры.</p>
                </div>
                <a href="{{ route('sessions.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Назад к списку</a>
            </div>

            <form action="{{ route('sessions.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @include('sessions._form', [
                    'clients' => $clients,
                    'cosmetologists' => $cosmetologists,
                    'services' => $services,
                    'statuses' => [
                        'scheduled' => 'Запланирован',
                        'done' => 'Проведён',
                        'canceled' => 'Отменён',
                        'no_show' => 'Не явился',
                    ],
                    'submitLabel' => 'Сохранить сеанс',
                    'title' => 'Создание сеанса',
                ])
            </form>
        </div>
    </div>
@endsection