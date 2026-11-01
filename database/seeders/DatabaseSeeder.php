<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('settings')->insert([
            'shop_name' => 'My POS System',
            'logo' => 'logo.png'
        ]);

        DB::table('brands')->insert([
            ['name' => 'Bamburi Cement'],
            ['name' => 'Crown Paints'],
            ['name' => 'Devki Steel']
        ]);

        DB::table('categories')->insert([
                ['name' => 'Cement'],
                ['name' => 'Paint'],
                ['name' => 'Iron Sheets'],
                ['name' => 'Tools']
                    ]);

        DB::table('customers')->insert([
            [
                'name' => 'John Otieno',
                'phone' => '0712345678',
                'email' => 'john@gmail.com',
                'address' => 'Siaya, Kenya',
            ],
            [
                'name' => 'Mary Akinyi',
                'phone' => '0798765432',
                'email' => 'mary@gmail.com',
                'address' => 'Kisumu, Kenya'
            ]
        ]);

        DB::table('suppliers')->insert([
            [
                'name' => 'Kenya Builders Ltd',
                'phone' => '0700111222',
                'email' => 'info@builders.co.ke',
                'address' => 'Nairobi, Kenya',
            ],
            [
                'name' => 'East Africa Supplies',
                'phone' => '0722333444',
                'email' => 'supply@ea.com',
                'address' => 'Mombasa, Kenya'
            ]
        ]);

        DB::table('products')->insert([
            [
                'name' => 'Bamburi Cement 50kg',
                'description' => 'High quality cement',
                'brand_id' => '1',
                'image' => 'cement.jpg',
            ],
            [
                'name' => 'Crown Paint 20L',
                'description' => 'Durable wall paint',
                'brand_id' => '2',
                'image' => 'paint.jpg',
            ],
            [
                'name' => 'Iron Sheet Gauge 28',
                'description' => 'Strong roofing sheet',
                'brand_id' => '3',
                'image' => 'iron.jpg',
            ]
        ]);

        DB::table('batches')->insert([
            [
                'batch_no' => 'january-1',
                'product_id' => '1',
                'quantity' => '10',
                'rem_quantity' => '10',
                'purchase_price' => '10000',
                'sell_price' => '12000',
                'supplier_id' => '1',
                'total_purchase_cost' => '100000',
            ],
            [
                'batch_no' => 'february-1',
                'product_id' => '2',
                'quantity' => '10',
                'rem_quantity' => '10',
                'purchase_price' => '10000',
                'sell_price' => '12000',
                'supplier_id' => '1',
                'total_purchase_cost' => '1000000',
            ],
            [
                'batch_no' => 'january-2',
                'product_id' => '3',
                'quantity' => '10',
                'rem_quantity' => '10',
                'purchase_price' => '10000',
                'sell_price' => '12000',
                'supplier_id' => '2',
                'total_purchase_cost' => '1000000',
            ],
            [
                'batch_no' => 'february-2',
                'product_id' => '4',
                'quantity' => '10',
                'rem_quantity' => '10',
                'purchase_price' => '10000',
                'sell_price' => '12000',
                'supplier_id' => '2',
                'total_purchase_cost' => '1000000',
            ]
        ]);

        DB::table('category_product')->insert([
            [
                'category_id' => '1',
                'product_id' => '1'
            ],
            [
                'category_id' => '1',
                'product_id' => '2'
            ],
            [
                'category_id' => '2',
                'product_id' => '3'
            ],
            [
                'category_id' => '2',
                'product_id' => '4'
            ]
        ]);
    }
}
