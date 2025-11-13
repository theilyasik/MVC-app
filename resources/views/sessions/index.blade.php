@extends('layout')

@section('content')
    @php
        $statusLabels = [
            'scheduled' => 'Запланирован',
            'done'      => 'Проведён',
            'canceled'  => 'Отменён',
            'no_show'   => 'Не явился',
        ];
    @endphp
    <div class="row justify-content-center mb-4">
        <div class="col-xl-10 col-lg-11">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div>
                    <span class="badge badge-soft rounded-pill px-3 py-2 mb-2">Расписание</span>
                    <h1 class="fw-semibold mb-0" style="color: var(--brand-primary);">
                        @if($selectedClient)
                            Сеансы клиента
                        @elseif($selectedCosmetologist)
                            График косметолога
                        @elseif($selectedService)
                            Сеансы по услуге
                        @else
                            Сеансы
                        @endif
                    </h1>
                    <p class="text-muted mb-0">
                        @if($selectedClient)
                            Управление встречами для гостя {{ $selectedClient->full_name }}.
                        @elseif($selectedCosmetologist)
                            Записи, закреплённые за специалистом {{ $selectedCosметologist->full_name }}.
                        @elseif($selectedService)
                            Все визиты, в которые входит услуга «{{ $selectedService->name }}».
                        @else
                            Отслеживайте встречи, управляйте клиентами и косметологами.
                        @endif
                    </p>
                </div>
                @auth
                    <a href="{{ route('sessions.create') }}" class="btn btn-brand rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i> Новый сеанс
                    </a>
                @endauth
            </div>

            @if(!empty($activeFilters))
                <div class="alert alert-light border-0 shadow-sm mb-4 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted small">Активные фильтры:</span>
                    @foreach($activeFilters as $filter)
                        <span class="badge rounded-pill text-bg-light border" style="border-color: var(--brand-primary); color: var(--brand-primary);">
                            {{ $filter['label'] }}: {{ $filter['value'] }}
                        </span>
                    @endforeach
                    <a href="{{ route('sessions.index') }}" class="ms-auto small text-decoration-none">
                        Сбросить
                    </a>
                </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
                        <form action="{{ route('sessions.index') }}" method="GET" class="d-flex flex-column flex-sm-row gap-3">
                            <div>
                                <label for="perpage" class="form-label text-muted small mb-1">Записей на странице</label>
                                <select name="perpage" id="perpage" class="form-select rounded-pill" onchange="this.form.submit()">
                                    @php $pp = (int) request('perpage', 15); @endphp
                                    @foreach([5,10,15,20,50] as $opt)
                                        <option value="{{ $opt }}" {{ $pp === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @foreach(request()->except('perpage','page') as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <noscript>
                                <div class="align-self-end">
                                    <button type="submit" class="btn btn-brand btn-sm rounded-pill">Показать</button>
                                </div>
                            </noscript>
                        </form>
                    </div>
                </div>
            </div>

            @if($sessions->count() === 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5 text-center text-muted">
                        @if(!empty($activeFilters))
                            Нет сеансов, соответствующих выбранным фильтрам.
                        @else
                            Пока нет сеансов. Добавьте первый, чтобы сформировать расписание.
                        @endif
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Клиент</th>
                                    <th scope="col">Косметолог</th>
                                    <th scope="col">Время</th>
                                    <th scope="col">Услуги</th>
                                    <th scope="col" class="text-end">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $s)
                                    <tr>
                                        <td><a href="{{ route('sessions.show', $s->id) }}" class="text-decoration-none fw-semibold" style="color: var(--brand-primary);">#{{ $s->id }}</a></td>
                                        <td>{{ optional($s->client)->full_name ?? '—' }}</td>
                                        <td>{{ optional($s->cosmetologist)->full_name ?? '—' }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $s->starts_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY, HH:mm') }}</div>
                                            <div class="text-muted small">до {{ $s->ends_at->locale(app()->getLocale())->isoFormat('HH:mm') }}</div>
                                        </td>
                                        <td class="small">
                                            @if($s->services->isNotEmpty())
                                                @foreach($s->services as $srv)
                                                    <span class="d-inline-flex align-items-center bg-light rounded-pill px-3 py-1 me-2 mb-2">
                                                        {{ $srv->name }} <span class="text-muted ms-2">×{{ $srv->pivot->quantity }}</span>
                                                    </span>
                                                @endforeach
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @auth
                                                <div class="d-flex flex-column align-items-end gap-2">
                                                    <div class="d-flex flex-wrap justify-content-end gap-2">
                                                        <span class="badge rounded-pill text-bg-light">
                                                            {{ $statusLabels[$s->status] ?? $s->status }}
                                                        </span>
                                                        @can('edit-session', $s)
                                                            @if($s->status !== 'done')
                                                                <form action="{{ route('sessions.update-status', $s->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="done">
                                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill d-inline-flex align-items-center gap-1">
                                                                        <i class="bi bi-check-lg"></i>
                                                                        Отметить как проведён
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="text-success small d-inline-flex align-items-center gap-1">
                                                                    <i class="bi bi-check-circle-fill"></i>
                                                                    Отмечен как проведён
                                                                </span>
                                                            @endif
                                                        @endcan
                                                    </div>

                                                    <div class="btn-group" role="group" aria-label="Действия">
                                                        @can('edit-session', $s)
                                                            <a href="{{ route('sessions.edit', $s->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill">Редактировать</a>
                                                        @endcan
                                                        @can('delete-session', $s)
                                                            <form action="{{ route('sessions.destroy', $s->id) }}" method="POST" class="ms-2 d-inline" onsubmit="return confirm('Удалить этот сеанс?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Удалить</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted small">Требуется вход</span>
                                            @endauth
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <div class="d-flex justify-content-between flex-column flex-md-row align-items-md-center gap-3">
                            <div class="small text-muted">Всего записей: {{ $sessions->total() }}</div>
                            <div class="mb-0">{{ $sessions->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
