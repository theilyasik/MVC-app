<?php

namespace App\Http\Controllers;

use App\Models\Cosmetologist;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CosmetologistController extends Controller
{
    public function index()
    {
        $cosmetologists = Cosmetologist::orderBy('full_name')->get();

        return view('cosmetologists.index', compact('cosmetologists'));
    }

    public function store(Request $request)
    {
        $data = $request->validateWithBag('createCosmetologist', [
            'full_name'     => ['required', 'string', 'max:150'],
            'specialization' => ['nullable', 'string', 'max:150'],
            'phone'         => ['nullable', 'string', 'max:50', Rule::unique('cosmetologists', 'phone')],
            'email'         => ['nullable', 'email', 'max:254', Rule::unique('cosmetologists', 'email')],
        ], [
            'full_name.required' => 'Введите имя специалиста.',
            'phone.unique'       => 'Такой номер телефона уже зарегистрирован.',
            'email.unique'       => 'Такой e-mail уже зарегистрирован.',
        ]);

        $cosmetologist = Cosmetologist::create([
            'full_name'     => trim($data['full_name']),
            'specialization'=> Arr::has($data, 'specialization') ? trim((string) $data['specialization']) : null,
            'phone'         => Arr::has($data, 'phone') ? trim((string) $data['phone']) : null,
            'email'         => Arr::has($data, 'email') ? trim((string) $data['email']) : null,
        ]);

        return redirect()->route('cosmetologists.index')
            ->with('success', "Косметолог «{$cosmetologist->full_name}» добавлен");
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