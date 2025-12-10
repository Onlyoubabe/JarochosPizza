<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class AdminPizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pizzas = Pizza::orderBy('name')->get();
        return view('admin.pizzas.index', compact('pizzas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pizzas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pizzas', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        unset($validated['image']);
        
        $validated['slug'] = Str::slug($validated['name']);

        Pizza::create($validated);

        return redirect()->route('admin.pizzas.index')
            ->with('success', 'Pizza creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pizza $pizza)
    {
        return view('admin.pizzas.edit', compact('pizza'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pizza $pizza)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists and is not an external URL
            if ($pizza->image_url && strpos($pizza->image_url, '/storage/') !== false) {
                // Extract relative path from URL: /storage/pizzas/start.jpg -> pizzas/start.jpg
                $oldPath = str_replace('/storage/', '', $pizza->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('pizzas', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        // Remove 'image' from validated data as it's not a column, 'image_url' is
        unset($validated['image']);
        
        $validated['slug'] = Str::slug($validated['name']);

        $pizza->update($validated);

        return redirect()->route('admin.pizzas.index')
            ->with('success', 'Pizza actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pizza $pizza)
    {
        $pizza->delete();

        return redirect()->route('admin.pizzas.index')
            ->with('success', 'Pizza eliminada exitosamente.');
    }
}
