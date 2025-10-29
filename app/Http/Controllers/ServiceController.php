<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->get();
        return view('services.index', compact('services'));
    }

    public function show(int $id)
    {
        $service = Service::with(['sessions.client', 'sessions.cosmetologist'])->findOrFail($id);
        return view('services.show', compact('service'));
    }
}

