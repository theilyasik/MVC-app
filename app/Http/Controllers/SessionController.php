<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Client;
use App\Models\Cosmetologist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::with(['client','cosmetologist','services'])
            ->orderBy('starts_at','desc')
            ->get();

        return view('sessions.index', compact('sessions'));
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
            'client_id'        => ['required','exists:clients,id'],
            'cosmetologist_id' => ['required','exists:cosmetologists,id'],
            'starts_at'        => ['required','date'],
            'ends_at'          => ['required','date','after:starts_at'],
            'room'             => ['nullable','string','max:50'],
            'status'           => ['required', Rule::in(['scheduled','done','canceled','no_show'])],
            'notes'            => ['nullable','string'],
        ]);

        $session = Session::create($data);

        return redirect()->route('sessions.show', $session->id)
            ->with('success', 'Сеанс создан');
    }

    public function show(Session $session)
    {
        $session->load(['client','cosmetologist','services']);
        return view('sessions.show', compact('session'));
    }

    public function edit(Session $session)
    {
        return view('sessions.edit', [
            'session'         => $session,
            'clients'         => Client::orderBy('full_name')->get(),
            'cosmetologists'  => Cosmetologist::orderBy('full_name')->get(),
        ]);
    }

    public function update(Request $request, Session $session)
    {
        $data = $request->validate([
            'client_id'        => ['required','exists:clients,id'],
            'cosmetologist_id' => ['required','exists:cosmetologists,id'],
            'starts_at'        => ['required','date'],
            'ends_at'          => ['required','date','after:starts_at'],
            'room'             => ['nullable','string','max:50'],
            'status'           => ['required', Rule::in(['scheduled','done','canceled','no_show'])],
            'notes'            => ['nullable','string'],
        ]);

        $session->update($data);

        return redirect()->route('sessions.show', $session->id)
            ->with('success', 'Сеанс обновлён');
    }

    public function destroy(Session $session)
    {
        $session->delete();

        return redirect()->route('sessions.index')
            ->with('success', 'Сеанс удалён');
    }
}
