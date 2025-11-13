<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Client;
use App\Models\Cosmetologist;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

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
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'        => ['required', 'exists:clients,id'],
            'cosmetologist_id' => ['required', 'exists:cosmetologists,id'],
            'starts_at'        => ['required', 'date'],
            'ends_at'          => ['required', 'date', 'after:starts_at'],
            'room'             => ['nullable', 'string', 'max:50'],
            'status'           => ['required', Rule::in(['scheduled', 'done', 'canceled', 'no_show'])],
            'notes'            => ['nullable', 'string'],
        ]);

        $session = Session::create($data);

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
        if (Gate::denies('edit-session', $session)) {
            return redirect()->route('error')
                ->with('message', "Недостаточно прав для редактирования сеанса #{$session->id}");
        }

        return view('sessions.edit', [
            'session'        => $session->load(['client', 'cosmetologist', 'services']),
            'clients'        => Client::orderBy('full_name')->get(),
            'cosmetologists' => Cosmetologist::orderBy('full_name')->get(),
        ]);
    }

    public function update(Request $request, Session $session)
    {
        if (Gate::denies('edit-session', $session)) {
            return redirect()->route('error')
                ->with('message', "Недостаточно прав для редактирования сеанса #{$session->id}");
        }

        $data = $request->validate([
            'client_id'        => ['required', 'exists:clients,id'],
            'cosmetologist_id' => ['required', 'exists:cosmetologists,id'],
            'starts_at'        => ['required', 'date'],
            'ends_at'          => ['required', 'date', 'after:starts_at'],
            'room'             => ['nullable', 'string', 'max:50'],
            'status'           => ['required', Rule::in(['scheduled', 'done', 'canceled', 'no_show'])],
            'notes'            => ['nullable', 'string'],
        ]);

        $session->update($data);

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
}
