@php
  // Для <input type="datetime-local"> ожидаемый формат: Y-m-d\TH:i
  $startsValue = old('starts_at', isset($session) && $session->starts_at ? $session->starts_at->format('Y-m-d\TH:i') : '');
  $endsValue   = old('ends_at',   isset($session) && $session->ends_at   ? $session->ends_at->format('Y-m-d\TH:i')   : '');
@endphp

@if ($errors->any())
  <div class="error">
    <b>Исправьте ошибки:</b>
    <ul>
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div>
  <label>Клиент:</label>
  <select name="client_id" required>
    <option value="">— выберите —</option>
    @foreach($clients as $c)
      <option value="{{ $c->id }}" @selected(old('client_id', $session->client_id ?? null) == $c->id)>
        {{ $c->full_name }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label>Косметолог:</label>
  <select name="cosmetologist_id" required>
    <option value="">— выберите —</option>
    @foreach($cosmetologists as $m)
      <option value="{{ $m->id }}" @selected(old('cosmetologist_id', $session->cosmetologist_id ?? null) == $m->id)>
        {{ $m->full_name }}
      </option>
    @endforeach
  </select>
</div>

<div>
  <label>Начало:</label>
  <input type="datetime-local" name="starts_at" value="{{ $startsValue }}" required>
</div>

<div>
  <label>Окончание:</label>
  <input type="datetime-local" name="ends_at" value="{{ $endsValue }}" required>
</div>

<div>
  <label>Кабинет:</label>
  <input type="text" name="room" value="{{ old('room', $session->room ?? '') }}" maxlength="50">
</div>

<div>
  <label>Статус:</label>
  <select name="status" required>
    @foreach($statuses as $st)
      <option value="{{ $st }}" @selected(old('status', $session->status ?? 'scheduled') === $st)>{{ $st }}</option>
    @endforeach
  </select>
</div>

<div>
  <label>Заметки:</label><br>
  <textarea name="notes" rows="3">{{ old('notes', $session->notes ?? '') }}</textarea>
</div>
