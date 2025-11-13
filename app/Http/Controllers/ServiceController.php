<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // список услуг
    public function index(Request $request)
    {
        $perpage = (int) $request->query('perpage', 15);
        $perpage = $perpage > 0 ? $perpage : 15;

        $services = Service::withCount('sessions')
            ->orderBy('name')
            ->paginate($perpage)
            ->withQueryString();

        return view('services.index', compact('services'));
    }

    // просмотр конкретной услуги + связанные сеансы
    public function show(int $id)
    {
        $service = Service::with([
            'sessions' => fn ($query) => $query
                ->with([
                    'client:id,full_name',
                    'cosmetologist:id,full_name',
                ])
                ->orderByDesc('starts_at'),
        ])->findOrFail($id);

        return view('services.show', compact('service'));
    }
}
