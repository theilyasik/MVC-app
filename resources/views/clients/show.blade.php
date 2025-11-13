@extends('layout')

@section('title', 'Клиент: '.$client->full_name)

@section('content')
    <div class="row justify-content-center mb-5">
        <div class="col-xl-9 col-lg-10">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-7 p-5">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge badge-soft rounded-pill px-3 py-2">Клиент</span>
                            @auth
                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Удалить клиента {{ $client->full_name }}? Это действие нельзя отменить.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                        <i class="bi bi-trash me-1"></i> Удалить
                                    </button>
                                </form>
                            @endauth
                        </div>
                        <h1 class="fw-semibold mb-3" style="color: var(--brand-primary);">{{ $client->full_name }}</h1>
                        <p class="text-muted mb-4">Персональная карточка гостя салона. Здесь собраны основные контактные данные и важные пометки команды.</p>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                            <div class="col">
                                <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-4 shadow-sm h-100">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-telephone text-primary"></i>
                                    </div>
                                    <div class="small">
                                        <div class="fw-semibold text-dark">Телефон</div>
                                        <div class="text-muted text-break" style="word-break: break-word;">{{ $client->phone ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-4 shadow-sm h-100">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </div>
                                    <div class="small">
                                        <div class="fw-semibold text-dark">E-mail</div>
                                        <div class="text-muted text-break" style="word-break: break-word;">{{ $client->email ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-4 shadow-sm h-100">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <i class="bi bi-journal-text text-primary"></i>
                                    </div>
                                    <div class="small">
                                        <div class="fw-semibold text-dark">Сеансы</div>
                                        <div class="text-muted text-break" style="word-break: break-word;">{{ $client->sessions_count }} в истории</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <a href="{{ route('sessions.index', ['client' => $client->id]) }}" class="btn btn-brand rounded-pill px-4">
                                Открыть расписание клиента
                            </a>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Управляйте записями в разделе «Сеансы».
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 d-none d-md-block">
                        <div class="ratio ratio-4x3">
                            <img src="{{ asset('images/client-placeholder.svg') }}" class="w-100 h-100 object-fit-cover" alt="Гость салона">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h5 fw-semibold mb-3" style="color: var(--brand-primary);">Заметки команды</h2>
                    @if($client->notes)
                        <p class="mb-0 text-muted">{{ $client->notes }}</p>
                    @else
                        <div class="text-muted small">Заметок пока нет. Добавьте важные детали о предпочтениях гостя при следующем обновлении профиля.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection