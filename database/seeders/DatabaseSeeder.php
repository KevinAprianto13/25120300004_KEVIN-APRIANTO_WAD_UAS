<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo accounts and warehouse inventory.
     */
    public function run(): void
    {
        // 1. Seed Accounts specified in Rubric (Section G)
        $admin = User::firstOrCreate(
            ['email' => 'admin@gudangku.test'],
            [
                'name' => 'Admin GudangKu',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        $staff = User::firstOrCreate(
            ['email' => 'staff@gudangku.test'],
            [
                'name' => 'Staff Inventaris',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        // 2. Seed Categories
        $catElectronics = Category::firstOrCreate(
            ['name' => 'Elektronik & Gadget'],
            ['description' => 'Perangkat elektronik kantor, periferal komputer, dan aksesoris audio']
        );

        $catStationery = Category::firstOrCreate(
            ['name' => 'Alat Tulis & Kantor (ATK)'],
            ['description' => 'Kebutuhan dokumen, kertas, pulpen, buku, dan perlengkapan meja kerja']
        );

        $catTools = Category::firstOrCreate(
            ['name' => 'Perkakas & Teknik'],
            ['description' => 'Peralatan mekanik, kelistrikan, dan pemeliharaan fasilitas']
        );

        $catPackaging = Category::firstOrCreate(
            ['name' => 'Bahan Kemasan & Logistik'],
            ['description' => 'Kardus, lakban, bubble wrap, stretch film, dan strapping band']
        );

        // 3. Seed Products
        $p1 = Product::firstOrCreate(
            ['sku' => 'ELK-001'],
            [
                'category_id' => $catElectronics->id,
                'name' => 'Mouse Wireless Silent Click',
                'stock' => 28,
                'min_stock' => 10,
                'price' => 125000,
            ]
        );

        $p2 = Product::firstOrCreate(
            ['sku' => 'ELK-002'],
            [
                'category_id' => $catElectronics->id,
                'name' => 'Keyboard Mechanical TKL Blue Switch',
                'stock' => 4, // Below min_stock (5) -> Low stock alert
                'min_stock' => 5,
                'price' => 380000,
            ]
        );

        $p3 = Product::firstOrCreate(
            ['sku' => 'ELK-003'],
            [
                'category_id' => $catElectronics->id,
                'name' => 'Monitor LED 24 Inch Full HD IPS',
                'stock' => 2, // Low stock
                'min_stock' => 5,
                'price' => 1650000,
            ]
        );

        $p4 = Product::firstOrCreate(
            ['sku' => 'ATK-001'],
            [
                'category_id' => $catStationery->id,
                'name' => 'Kertas HVS A4 80 Gram (1 Rim/500 Lembar)',
                'stock' => 65,
                'min_stock' => 15,
                'price' => 49500,
            ]
        );

        $p5 = Product::firstOrCreate(
            ['sku' => 'ATK-002'],
            [
                'category_id' => $catStationery->id,
                'name' => 'Ballpoint Gel Hitam 0.5mm (Pack isi 12)',
                'stock' => 3, // Low stock
                'min_stock' => 8,
                'price' => 32000,
            ]
        );

        $p6 = Product::firstOrCreate(
            ['sku' => 'TEK-001'],
            [
                'category_id' => $catTools->id,
                'name' => 'Set Obeng Presisi Magnetik 32-in-1',
                'stock' => 16,
                'min_stock' => 5,
                'price' => 85000,
            ]
        );

        $p7 = Product::firstOrCreate(
            ['sku' => 'LOG-001'],
            [
                'category_id' => $catPackaging->id,
                'name' => 'Kardus Box Corrugated (30x20x15 cm)',
                'stock' => 140,
                'min_stock' => 30,
                'price' => 6500,
            ]
        );

        $p8 = Product::firstOrCreate(
            ['sku' => 'LOG-002'],
            [
                'category_id' => $catPackaging->id,
                'name' => 'Bubble Wrap Tebal Roll 50m x 125cm',
                'stock' => 0, // Out of stock!
                'min_stock' => 5,
                'price' => 110000,
            ]
        );

        // 4. Seed Initial Stock Transactions
        $transactions = [
            [
                'product_id' => $p1->id,
                'user_id' => $admin->id,
                'type' => 'in',
                'quantity' => 30,
                'note' => 'Penerimaan stok batch awal dari supplier',
                'transaction_date' => Carbon::now()->subDays(10)->toDateString(),
            ],
            [
                'product_id' => $p1->id,
                'user_id' => $staff->id,
                'type' => 'out',
                'quantity' => 2,
                'note' => 'Pengeluaran untuk tim customer care',
                'transaction_date' => Carbon::now()->subDays(6)->toDateString(),
            ],
            [
                'product_id' => $p2->id,
                'user_id' => $admin->id,
                'type' => 'in',
                'quantity' => 10,
                'note' => 'Restock periferal komputer',
                'transaction_date' => Carbon::now()->subDays(8)->toDateString(),
            ],
            [
                'product_id' => $p2->id,
                'user_id' => $staff->id,
                'type' => 'out',
                'quantity' => 6,
                'note' => 'Distribusi unit ke workstation engineer',
                'transaction_date' => Carbon::now()->subDays(2)->toDateString(),
            ],
            [
                'product_id' => $p4->id,
                'user_id' => $admin->id,
                'type' => 'in',
                'quantity' => 80,
                'note' => 'Pengadaan kertas kantor bulanan',
                'transaction_date' => Carbon::now()->subDays(5)->toDateString(),
            ],
            [
                'product_id' => $p4->id,
                'user_id' => $staff->id,
                'type' => 'out',
                'quantity' => 15,
                'note' => 'Pengambilan untuk bagian administrasi keuangan',
                'transaction_date' => Carbon::now()->subDay()->toDateString(),
            ],
            [
                'product_id' => $p7->id,
                'user_id' => $staff->id,
                'type' => 'in',
                'quantity' => 150,
                'note' => 'Pasokan karton box packing',
                'transaction_date' => Carbon::now()->subDays(4)->toDateString(),
            ],
            [
                'product_id' => $p7->id,
                'user_id' => $staff->id,
                'type' => 'out',
                'quantity' => 10,
                'note' => 'Packing pengiriman order keluar',
                'transaction_date' => Carbon::now()->toDateString(),
            ],
        ];

        foreach ($transactions as $tx) {
            StockTransaction::create($tx);
        }
    }
}
