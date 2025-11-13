<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('full_name')->get();

        return view('clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validateWithBag('createClient', [
            'full_name' => ['required', 'string', 'max:150'],
            'phone'     => ['required', 'string', 'max:50', Rule::unique('clients', 'phone')],
            'email'     => ['nullable', 'email', 'max:254', Rule::unique('clients', 'email')],
            'notes'     => ['nullable', 'string', 'max:500'],
        ], [
            'full_name.required' => 'Введите ФИО клиента.',
            'phone.required'     => 'Укажите номер телефона.',
            'phone.unique'       => 'Такой номер телефона уже зарегистрирован.',
            'email.unique'       => 'Такой e-mail уже зарегистрирован.',
        ]);

        $client = Client::create([
            'full_name' => trim($data['full_name']),
            'phone'     => trim($data['phone']),
            'email'     => Arr::has($data, 'email') ? trim((string) $data['email']) : null,
            'notes'     => Arr::has($data, 'notes') ? trim((string) $data['notes']) : null,
        ]);

        return redirect()->route('clients.index')
            ->with('success', "Клиент «{$client->full_name}» добавлен");
    }

    public function show($id)
    {
        $client = Client::withCount('sessions')->findOrFail($id);

        return view('clients.show', compact('client'));
    }

    public function destroy($id): RedirectResponse
    {
        $client = Client::withCount('sessions')->findOrFail($id);

        if ($client->sessions_count > 0) {
            return redirect()
                ->route('clients.show', $client->id)
                ->with('error', 'Нельзя удалить клиента с историей сеансов. Сначала удалите связанные записи.');
        }

        $name = $client->full_name;
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', "Клиент «{$name}» удалён.");
    }
}