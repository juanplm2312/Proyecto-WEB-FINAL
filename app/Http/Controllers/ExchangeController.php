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
        $validated = $request->validate([
            'gift_id' => 'required|exists:gifts,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000'
        ]);

        $gift = Gift::findOrFail($validated['gift_id']);
        if ($gift->creator_id == $request->user()->id) {
            return back()->withErrors(['gift_id'=>'No puedes enviar tu propio regalo.']);
        }

        $exchange = Exchange::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $validated['receiver_id'],
            'gift_id' => $validated['gift_id'],
            'message' => $validated['message'] ?? null
        ]);

        // Enviar correo personalizado al receiver (Mail::to(...)->send(...))
        Mail::to($exchange->receiver->email)->send(new ExchangeCreated($exchange));

        return redirect()->route('exchanges.show',$exchange)->with('success','Intercambio creado.');
    }
}
