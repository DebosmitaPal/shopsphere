<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create(['name' => 'Admin User', 'email' => 'admin@shopsphere.test', 'password' => Hash::make('password'), 'role' => 'admin']);
        $customer = User::create(['name' => 'Customer User', 'email' => 'customer@shopsphere.test', 'password' => Hash::make('password'), 'role' => 'customer', 'address' => 'MG Road, Bengaluru, Karnataka']);
        $sellerUser = User::create(['name' => 'Seller User', 'email' => 'seller@shopsphere.test', 'password' => Hash::make('password'), 'role' => 'seller']);

        $seller = Seller::create([
            'user_id' => $sellerUser->id,
            'store_name' => 'Urban Utility Co',
            'slug' => 'urban-utility-co',
            'description' => 'Everyday electronics, workspace gear, and lifestyle essentials.',
            'business_email' => 'seller@shopsphere.test',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $categories = collect(['Electronics', 'Fashion', 'Home', 'Books', 'Beauty'])->map(fn ($name) => Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => "{$name} products from verified ShopSphere sellers.",
        ]));

        foreach ([
            ['Bluetooth Speaker', 'Electronics', 2499, 12],
            ['Wireless Keyboard', 'Electronics', 1799, 4],
            ['Cotton Overshirt', 'Fashion', 1299, 25],
            ['Desk Organizer', 'Home', 799, 8],
            ['Laravel Quick Notes', 'Books', 499, 18],
            ['Skin Care Kit', 'Beauty', 2199, 5],
        ] as [$name, $category, $price, $stock]) {
            $product = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $categories->firstWhere('name', $category)->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Premium {$name} with reliable seller support and fast order tracking.",
                'price' => $price,
                'stock_quantity' => $stock,
                'status' => 'active',
            ]);

            Review::create([
                'user_id' => $customer->id,
                'product_id' => $product->id,
                'rating' => 5,
                'comment' => 'Good quality and smooth delivery experience.',
            ]);
        }
    }
}
