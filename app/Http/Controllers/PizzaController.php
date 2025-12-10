<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index()
    {
        $pizzas = Pizza::with('ingredients')->get();
        return view('pizzas.index', compact('pizzas'));
    }

    public function show(Pizza $pizza)
    {
        $pizza->load('ingredients');
        $allIngredients = Ingredient::all()->groupBy('category');
        return view('pizzas.show', compact('pizza', 'allIngredients'));
    }
}
