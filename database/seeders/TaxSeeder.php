<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tax::insert([
            'tax_name'   => 'VAT',
            'rate'       => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
