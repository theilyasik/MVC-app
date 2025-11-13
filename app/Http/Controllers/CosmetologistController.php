<?php

namespace App\Http\Controllers;

use App\Models\Cosmetologist;

class CosmetologistController extends Controller
{
    public function index()
    {
        $cosmetologists = Cosmetologist::orderBy('full_name')->get();
        return view('cosmetologists.index', compact('cosmetologists'));
    }

    public function show($id)
    {
        $cosmetologist = Cosmetologist::with([
            'sessions' => fn ($query) => $query
                ->with(['client', 'services'])
                ->orderByDesc('starts_at'),
        ])->findOrFail($id);

        return view('cosmetologists.show', compact('cosmetologist'));
    }
}
