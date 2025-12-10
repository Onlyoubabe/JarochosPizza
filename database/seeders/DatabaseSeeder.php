<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ingredient;
use App\Models\Pizza;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Ingredients
        $ingredients = [
            ['name' => 'Salsa de Tomate', 'slug' => 'tomato-sauce', 'price' => 10.00, 'category' => 'sauce'],
            ['name' => 'Queso Mozzarella', 'slug' => 'mozzarella', 'price' => 20.00, 'category' => 'cheese'],
            ['name' => 'Pepperoni', 'slug' => 'pepperoni', 'price' => 30.00, 'category' => 'meat'],
            ['name' => 'Champiñones', 'slug' => 'mushrooms', 'price' => 20.00, 'category' => 'veg'],
            ['name' => 'Cebollas', 'slug' => 'onions', 'price' => 10.00, 'category' => 'veg'],
            ['name' => 'Tocino', 'slug' => 'bacon', 'price' => 30.00, 'category' => 'meat'],
        ];

        foreach ($ingredients as $ing) {
            Ingredient::create($ing);
        }

        // Pizzas
        $margherita = Pizza::create([
            'name' => 'Margarita',
            'slug' => 'margherita',
            'description' => 'Clásica salsa de tomate y queso',
            'price' => 150.00,
            'image_url' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        ]);
        
        $margherita->ingredients()->attach(Ingredient::whereIn('slug', ['tomato-sauce', 'mozzarella'])->pluck('id'));

        $pepperoni = Pizza::create([
            'name' => 'Pepperoni',
            'slug' => 'pepperoni',
            'description' => 'Salsa de tomate, queso y pepperoni',
            'price' => 180.00,
            'image_url' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        ]);

        $pepperoni->ingredients()->attach(Ingredient::whereIn('slug', ['tomato-sauce', 'mozzarella', 'pepperoni'])->pluck('id'));

        $this->call(OrderSeeder::class);
    }
}
