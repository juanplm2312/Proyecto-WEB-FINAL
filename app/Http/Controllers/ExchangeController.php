<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Gift;
use App\Models\User;
use App\Mail\ExchangeCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExchangeController extends Controller
{
    public function store(Request $request)
    {
        // ---- VALIDACIÓN -----
        $validated = $request->validate([
            'gift_id' => 'required|exists:gifts,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000'
        ]);

        // ---- EVITAR QUE SE ENVÍE SU PROPIO REGALO ----
        $gift = Gift::findOrFail($validated['gift_id']);

        if ($gift->creator_id === $request->user()->id) {
            return back()->withErrors([
                'gift_id' => 'No puedes enviar tu propio regalo.'
            ]);
        }

        // ---- CREAR INTERCAMBIO ----
        $exchange = Exchange::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $validated['receiver_id'],
            'gift_id' => $validated['gift_id'],
            'message' => $validated['message'] ?? null
        ]);

        // ---- ENVIAR CORREO (con try/catch para evitar crash si falla) ----
        try {
            Mail::to($exchange->receiver->email)
                ->send(new ExchangeCreated($exchange));
        } catch (\Exception $e) {
            // No romper la app si falla el SMTP
            logger()->error("Error enviando correo: " . $e->getMessage());
        }

        // ---- REDIRECCIÓN ----
        return redirect()
            ->route('exchanges.show', $exchange)
            ->with('success', 'Intercambio creado correctamente.');
    }
}
