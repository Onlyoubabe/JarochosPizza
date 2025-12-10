<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'price', 'image_url'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }
    //
}
