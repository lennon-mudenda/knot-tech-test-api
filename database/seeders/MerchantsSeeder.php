<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Merchant::query()->count('*') == 0) {
            for($i = 0; $i < 5; $i++) {
                $definition = Merchant::factory()->definition();
                Merchant::create($definition);
            }
        }
    }
}
