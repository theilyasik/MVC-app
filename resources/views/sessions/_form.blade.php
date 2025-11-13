@php
    $startsValue = old('starts_at', isset($session) && $session->starts_at ? $session->starts_at->format('Y-m-d\TH:i') : '');
    $endsValue   = old('ends_at', isset($session) && $session->ends_at ? $session->ends_at->format('Y-m-d\TH:i') : '');
    $statusOptions = $statuses ?? [
        'scheduled' => 'Запланирован',
        'done' => 'Проведён',
        'canceled' => 'Отменён',
        'no_show' => 'Не явился',
    ];
    $submitLabel = $submitLabel ?? 'Сохранить';
@endphp

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <strong class="d-block mb-1">Исправьте ошибки:</strong>
        <ul class="mb-0 small">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm session-wizard" data-step-count="3">
    <div class="card-body p-4 p-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <div>
                <span class="badge badge-soft rounded-pill px-3 py-2">Шаг <span class="wizard-current-step">1</span> из 3</span>
                <h2 class="fw-semibold mt-2 mb-0" style="color: var(--brand-primary);">{{ $title ?? 'Детали сеанса' }}</h2>
            </div>
            <div class="text-muted small text-md-end">
                Заполните информацию о клиенте, времени и дополнительных сведениях.
            </div>
        </div>

        <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" style="width: 33%" data-progress-bar></div>
        </div>

        <div class="mt-4">
            <div class="wizard-step" data-step="1">
                <h5 class="fw-semibold mb-3">Клиенты и специалисты</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="client_id" class="form-label">Клиент</label>
                        <select name="client_id" id="client_id" class="form-select" required>
                            <option value="">— выберите —</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" @selected(old('client_id', $session->client_id ?? null) == $c->id)>{{ $c->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Для записи обязательно укажите клиента.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="cosmetologist_id" class="form-label">Косметолог</label>
                        <select name="cosmetologist_id" id="cosmetologist_id" class="form-select" required>
                            <option value="">— выберите —</option>
                            @foreach($cosmetologists as $m)
                                <option value="{{ $m->id }}" @selected(old('cosmetologist_id', $session->cosmetologist_id ?? null) == $m->id)>{{ $m->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Укажите исполнителя процедуры.</div>
                    </div>
                </div>
            </div>

            <div class="wizard-step d-none" data-step="2">
                <h5 class="fw-semibold mb-3">Время проведения</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="starts_at" class="form-label">Начало</label>
                        <input type="datetime-local" id="starts_at" name="starts_at" value="{{ $startsValue }}" class="form-control" required>
                        <div class="form-text">Дата и время старта процедуры.</div>
                    </div>
                    <div class="col-md-6">
                        <label for="ends_at" class="form-label">Окончание</label>
                        <input type="datetime-local" id="ends_at" name="ends_at" value="{{ $endsValue }}" class="form-control" required>
                        <div class="form-text">Предполагаемое время завершения.</div>
                    </div>
                </div>
            </div>

            <div class="wizard-step d-none" data-step="3">
                <h5 class="fw-semibold mb-3">Дополнительная информация</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="room" class="form-label">Кабинет</label>
                        <input type="text" id="room" name="room" value="{{ old('room', $session->room ?? '') }}" class="form-control" maxlength="50" placeholder="Например, Кабинет №3">
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Статус</label>
                        <select name="status" id="status" class="form-select" required>
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $session->status ?? 'scheduled') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label">Заметки</label>
                        <textarea id="notes" name="notes" rows="4" class="form-control" placeholder="Например, пожелания клиента, комментарии по процедуре">{{ old('notes', $session->notes ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2 gap-sm-3 mt-4">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 wizard-prev" disabled>Назад</button>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-brand rounded-pill px-4 wizard-next">Далее</button>
                <button type="submit" class="btn btn-brand rounded-pill px-4 wizard-submit d-none">{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @once
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.session-wizard').forEach(function (wizard) {
                    var steps = wizard.querySelectorAll('.wizard-step');
                    if (!steps.length) return;

                    var currentIndex = 0;
                    var progressBar = wizard.querySelector('[data-progress-bar]');
                    var currentStepLabel = wizard.querySelector('.wizard-current-step');
                    var prevButton = wizard.querySelector('.wizard-prev');
                    var nextButton = wizard.querySelector('.wizard-next');
                    var submitButton = wizard.querySelector('.wizard-submit');
                    var totalSteps = steps.length;

                    function updateView() {
                        steps.forEach(function (step, index) {
                            step.classList.toggle('d-none', index !== currentIndex);
                        });

                        if (currentStepLabel) {
                            currentStepLabel.textContent = currentIndex + 1;
                        }

                        if (progressBar) {
                            var percent = ((currentIndex + 1) / totalSteps) * 100;
                            progressBar.style.width = percent + '%';
                        }

                        if (prevButton) {
                            prevButton.disabled = currentIndex === 0;
                        }

                        if (nextButton) {
                            nextButton.classList.toggle('d-none', currentIndex === totalSteps - 1);
                        }

                        if (submitButton) {
                            submitButton.classList.toggle('d-none', currentIndex !== totalSteps - 1);
                        }
                    }

                    if (nextButton) {
                        nextButton.addEventListener('click', function () {
                            if (currentIndex < totalSteps - 1) {
                                currentIndex++;
                                updateView();
                            }
                        });
                    }

                    if (prevButton) {
                        prevButton.addEventListener('click', function () {
                            if (currentIndex > 0) {
                                currentIndex--;
                                updateView();
                            }
                        });
                    }

                    updateView();
                });
            });
        </script>
    @endonce
@endpush