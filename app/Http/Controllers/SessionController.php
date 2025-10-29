<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function show($id)
    {
        $session = Session::with(['client', 'cosmetologist', 'services'])->findOrFail($id);

        // Итог по пивоту: сумма quantity * unit_price_cents
        $total = DB::table('provided_services')
            ->where('session_id', $id)
            ->selectRaw('coalesce(sum(quantity * unit_price_cents), 0) AS total_cents')
            ->first();

        return view('sessions.show', [
            'session' => $session,
            'totalCents' => $total->total_cents ?? 0,
        ]);
    }
}
