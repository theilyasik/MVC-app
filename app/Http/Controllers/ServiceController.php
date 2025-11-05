<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // список услуг
    public function index()
    {
    $services = \App\Models\Service::orderBy('name')->get();
    return view('services.index', compact('services'));
    }


    // просмотр конкретной услуги + связанные сеансы
    public function show(int $id)
    {
        $service = Service::with([
            'sessions.client:id,full_name',
            'sessions.cosmetologist:id,full_name',
        ])->findOrFail($id);

        return view('services.show', compact('service'));
    }
}
