@extends('layout')

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-xl-10 col-lg-11">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-7 p-5">
                        <span class="badge badge-soft rounded-pill px-3 py-2 mb-3">Каталог процедур</span>
                        <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">Меню услуг Beauty Salon</h1>
                        <p class="text-muted mb-4">Создайте идеальное впечатление для клиентов: от комплексного ухода до экспресс-процедур. Управляйте ценами, длительностью и статусами в один клик.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-clock-history text-primary"></i>
                                </div>
                                <div class="small text-muted">Чёткое планирование длительности процедур</div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                    <i class="bi bi-cash-coin text-primary"></i>
                                </div>
                                <div class="small text-muted">Прозрачная стоимость для клиентов и команды</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="ratio ratio-4x3">
                            <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1200&q=80" class="w-100 h-100 object-fit-cover" alt="Процедуры салона">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('services.index') }}" method="GET" class="row gy-3 gx-4 align-items-end">
                        <div class="col-sm-4 col-md-3">
                            <label for="perpage" class="form-label text-muted small">Услуг на странице</label>
                            @php $pp = (int) request('perpage', 15); @endphp
                            <select name="perpage" id="perpage" class="form-select rounded-pill" onchange="this.form.submit()">
                                @foreach([5,10,15,20,50] as $opt)
                                    <option value="{{ $opt }}" {{ $pp === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-8 col-md-9 text-sm-end">
                            <div class="small text-muted">Всего услуг в каталоге: {{ $services->total() }}</div>
                        </div>
                        @foreach(request()->except('perpage','page') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <noscript>
                            <div class="col-12">
                                <button type="submit" class="btn btn-brand btn-sm rounded-pill">Применить</button>
                            </div>
                        </noscript>
                    </form>
                </div>
            </div>

            @if($services->count() === 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5 text-center text-muted">
                        Пока услуг нет. Добавьте первую процедуру, чтобы сформировать предложение салона.
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Базовая цена</th>
                                    <th scope="col">Длительность</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Сеансов</th>
                                    <th scope="col" class="text-end">Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($services as $service)
                                    <tr>
                                        <td><span class="fw-semibold" style="color: var(--brand-primary);">#{{ $service->id }}</span></td>
                                        <td>
                                            <div class="fw-semibold">{{ $service->name }}</div>
                                            @if($service->description)
                                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</div>
                                            @endif
                                        </td>
                                        <td>{{ number_format($service->price_cents/100, 2, ',', ' ') }} ₽</td>
                                        <td>{{ $service->duration_minutes }} мин.</td>
                                        <td>
                                            @if($service->is_active)
                                                <span class="badge rounded-pill text-bg-success-subtle text-success">Активна</span>
                                            @else
                                                <span class="badge rounded-pill text-bg-secondary">Неактивна</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-soft rounded-pill px-3 py-2">{{ $service->sessions_count ?? $service->sessions()->count() }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">Открыть</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <div class="d-flex justify-content-between flex-column flex-md-row align-items-md-center gap-3">
                            <div class="small text-muted">Показано {{ $services->count() }} из {{ $services->total() }}</div>
                            <div class="mb-0">{{ $services->links('vendor.pagination.bootstrap-4') }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
