<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class SessionStatusController extends Controller
{
    public function __invoke(Request $request, Session $session)
    {
        if (Gate::denies('edit-session', $session)) {
            return redirect()->route('error')
                ->with('message', "Недостаточно прав для изменения статуса сеанса #{$session->id}");
        }

        $data = $request->validate([
            'status' => ['required', Rule::in(Session::STATUSES)],
        ]);

        $session->update([
            'status' => $data['status'],
        ]);

        return redirect()->back()->with('success', 'Статус сеанса обновлён.');
    }
}