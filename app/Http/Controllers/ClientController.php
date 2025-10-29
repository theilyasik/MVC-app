<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('full_name')->get();
        return view('clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::with(['sessions.cosmetologist'])->findOrFail($id);
        return view('clients.show', compact('client'));
    }
}
