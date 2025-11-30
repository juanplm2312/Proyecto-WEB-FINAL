<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
{
    public function index()
    {
        // Eager load creator to evitar N+1
        $gifts = Gift::with('creator')->latest()->paginate(12);
        return view('gifts.index', compact('gifts'));
    }

    public function create()
    {
        $this->authorize('create', Gift::class);
        return view('gifts.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Gift::class);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string',
            'suggested_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gifts','public');
            $validated['image_path'] = $path;
        }
        $validated['creator_id'] = $request->user()->id;

        $gift = Gift::create($validated);

        return redirect()->route('gifts.show', $gift)->with('success','Regalo creado.');
    }

    public function show(Gift $gift)
    {
        $gift->load('creator','wishedBy');
        return view('gifts.show', compact('gift'));
    }

    public function edit(Gift $gift)
    {
        $this->authorize('update', $gift);
        return view('gifts.edit', compact('gift'));
    }

    public function update(Request $request, Gift $gift)
    {
        $this->authorize('update', $gift);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'description' => 'nullable|string',
            'suggested_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // eliminar anterior si existe
            if ($gift->image_path) Storage::disk('public')->delete($gift->image_path);
            $validated['image_path'] = $request->file('image')->store('gifts','public');
        }

        $gift->update($validated);
        return redirect()->route('gifts.show',$gift)->with('success','Regalo actualizado.');
    }

    public function destroy(Gift $gift)
    {
        $this->authorize('delete', $gift);
        // soft delete
        $gift->delete();
        return redirect()->route('gifts.index')->with('success','Regalo eliminado (soft).');
    }
}
