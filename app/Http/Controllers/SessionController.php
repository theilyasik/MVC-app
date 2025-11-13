<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Client;
use App\Models\Cosmetologist;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('perpage', 15);
        $perPage = max(1, min($perPage, 100));

        $query = Session::with(['client', 'cosmetologist', 'services']);

        $selectedClient        = null;
        $selectedCosmetologist = null;
        $selectedService       = null;
        $activeFilters         = [];

        $clientId = $request->integer('client');
        if ($clientId > 0) {
            $selectedClient = Client::find($clientId);
            if ($selectedClient) {
                $query->where('client_id', $selectedClient->id);
                $activeFilters[] = [
                    'label' => 'Клиент',
                    'value' => $selectedClient->full_name,
                ];
            }
        }

        $cosmetologistId = $request->integer('cosmetologist');
        if ($cosmetologistId > 0) {
            $selectedCosmetologist = Cosmetologist::find($cosmetologistId);
            if ($selectedCosmetologist) {
                $query->where('cosmetologist_id', $selectedCosmetologist->id);
                $activeFilters[] = [
                    'label' => 'Косметолог',
                    'value' => $selectedCosmetologist->full_name,
                ];
            }
        }

        $serviceId = $request->integer('service');
        if ($serviceId > 0) {
            $selectedService = Service::find($serviceId);
            if ($selectedService) {
                $query->whereHas('services', function ($q) use ($selectedService) {
                    $q->where('services.id', $selectedService->id);
                });
                $activeFilters[] = [
                    'label' => 'Услуга',
                    'value' => $selectedService->name,
                ];
            }
        }

        $sessions = $query
            ->orderByDesc('starts_at')
            ->paginate($perPage)
            ->withQueryString();

        return view('sessions.index', [
            'sessions'              => $sessions,
            'perPage'               => $perPage,
            'activeFilters'         => $activeFilters,
            'selectedClient'        => $selectedClient,
            'selectedCosmetologist' => $selectedCosmetologist,
            'selectedService'       => $selectedService,
        ]);
    }

    public function create()
    {
        return view('sessions.create', [
            'clients'        => Client::orderBy('full_name')->get(),
            'cosmetologists' => Cosmetologist::orderBy('full_name')->get(),
            'services'       => Service::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id'            => ['required', 'exists:clients,id'],
            'cosmetologist_id'     => ['required', 'exists:cosmetologists,id'],
            'starts_at'            => ['required', 'date'],
            'ends_at'              => ['required', 'date', 'after:starts_at'],
            'room'                 => ['nullable', 'string', 'max:50'],
            'status'               => ['required', Rule::in(['scheduled', 'done', 'canceled', 'no_show'])],
            'notes'                => ['nullable', 'string'],
            'services'             => ['required', 'array', 'min:1'],
            'services.*'           => ['distinct', 'exists:services,id'],
            'service_quantities'   => ['required', 'array'],
            'service_quantities.*' => ['nullable', 'integer', 'min:1', 'max:10'],
        ], [
            'services.required' => 'Выберите хотя бы одну услугу.',
            'services.min'      => 'Выберите хотя бы одну услугу.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $start = Carbon::parse($request->input('starts_at'));
            $end   = Carbon::parse($request->input('ends_at'));
            $clientId = (int) $request->input('client_id');
            $cosmetologistId = (int) $request->input('cosmetologist_id');

            if ($this->hasOverlap($start, $end, 'client_id', $clientId)) {
                $validator->errors()->add('starts_at', 'У клиента уже есть сеанс в указанное время.');
            }

            if ($this->hasOverlap($start, $end, 'cosmetologist_id', $cosmetologistId)) {
                $validator->errors()->add('starts_at', 'У выбранного косметолога уже есть сеанс в указанное время.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $session = Session::create([
            'client_id'        => $data['client_id'],
            'cosmetologist_id' => $data['cosmetologist_id'],
            'starts_at'        => $data['starts_at'],
            'ends_at'          => $data['ends_at'],
            'room'             => Arr::get($data, 'room'),
            'status'           => $data['status'],
            'notes'            => Arr::get($data, 'notes'),
        ]);

        $this->syncServices($session, $data['services'], $data['service_quantities']);

        return redirect()->route('sessions.show', $session->id)
            ->with('success', 'Сеанс создан');
    }

    public function show(Session $session)
    {
        $session->load(['client', 'cosmetologist', 'services']);

        return view('sessions.show', compact('session'));
    }

    public function edit(Session $session)
{
    {
        if (Gate::denies('edit-session', $session)) {
            return redirect()->route('error')
                ->with('message', "Недостаточно прав для редактирования сеанса #{$session->id}");
        }
    }
        return view('sessions.edit', [
            'session'        => $session->load(['client', 'cosmetologist', 'services']),
            'clients'        => Client::orderBy('full_name')->get(),
            'cosmetologists' => Cosmetologist::orderBy('full_name')->get(),
            'services'       => Service::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Session $session)
    {
        if (Gate::denies('edit-session', $session)) {
            return redirect()->route('error')
                ->with('message', "Недостаточно прав для редактирования сеанса #{$session->id}");
        }

        $validator = Validator::make($request->all(), [
            'client_id'            => ['required', 'exists:clients,id'],
            'cosmetologist_id'     => ['required', 'exists:cosmetologists,id'],
            'starts_at'            => ['required', 'date'],
            'ends_at'              => ['required', 'date', 'after:starts_at'],
            'room'                 => ['nullable', 'string', 'max:50'],
            'status'               => ['required', Rule::in(['scheduled', 'done', 'canceled', 'no_show'])],
            'notes'                => ['nullable', 'string'],
            'services'             => ['required', 'array', 'min:1'],
            'services.*'           => ['distinct', 'exists:services,id'],
            'service_quantities'   => ['required', 'array'],
            'service_quantities.*' => ['nullable', 'integer', 'min:1', 'max:10'],
        ], [
            'services.required' => 'Выберите хотя бы одну услугу.',
            'services.min'      => 'Выберите хотя бы одну услугу.',
        ]);

        $validator->after(function ($validator) use ($request, $session) {
            $start = Carbon::parse($request->input('starts_at'));
            $end   = Carbon::parse($request->input('ends_at'));
            $clientId = (int) $request->input('client_id');
            $cosmetologistId = (int) $request->input('cosmetologist_id');

            if ($this->hasOverlap($start, $end, 'client_id', $clientId, $session->id)) {
                $validator->errors()->add('starts_at', 'У клиента уже есть сеанс в указанное время.');
            }

            if ($this->hasOverlap($start, $end, 'cosmetologist_id', $cosmetologistId, $session->id)) {
                $validator->errors()->add('starts_at', 'У выбранного косметолога уже есть сеанс в указанное время.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $session->update([
            'client_id'        => $data['client_id'],
            'cosmetologist_id' => $data['cosmetologist_id'],
            'starts_at'        => $data['starts_at'],
            'ends_at'          => $data['ends_at'],
            'room'             => Arr::get($data, 'room'),
            'status'           => $data['status'],
            'notes'            => Arr::get($data, 'notes'),
        ]);

        $this->syncServices($session, $data['services'], $data['service_quantities']);

        return redirect()->route('sessions.show', $session->id)
            ->with('success', 'Сеанс обновлён');
    }
    public function destroy(Session $session)
    {
        if (Gate::denies('delete-session', $session)) {
            return redirect()->route('error')
                ->with('message', "Недостаточно прав для удаления сеанса #{$session->id}");
        }

        $session->delete();

        return redirect()->route('sessions.index')
            ->with('success', 'Сеанс удалён');
    }

    protected function hasOverlap(Carbon $start, Carbon $end, string $column, int $entityId, ?int $ignoreId = null): bool
    {
        if ($entityId <= 0) {
            return false;
        }

        return Session::where($column, $entityId)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($overlap) use ($start, $end) {
                    $overlap->where('starts_at', '<', $end)
                        ->where('ends_at', '>', $start);
                });
            })
            ->exists();
    }

    protected function syncServices(Session $session, array $serviceIds, array $quantities): void
    {
        $serviceIds = array_map('intval', $serviceIds);
        $services = Service::whereIn('id', $serviceIds)->get();

        $payload = [];

        foreach ($services as $service) {
            $quantity = (int) ($quantities[$service->id] ?? 1);
            $payload[$service->id] = [
                'quantity'         => max(1, $quantity),
                'unit_price_cents' => $service->price_cents,
            ];
        }

        $session->services()->sync($payload);
    }
}