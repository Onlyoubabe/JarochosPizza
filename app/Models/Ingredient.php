<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pizza;

class Ingredient extends Model
{
    protected $fillable = ['name', 'slug', 'price', 'category', 'image_url'];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class);
    }
}
