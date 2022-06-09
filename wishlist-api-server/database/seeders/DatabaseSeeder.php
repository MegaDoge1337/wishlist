<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wish;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->has(
                Wish::factory()
                    ->count(10)
            )
            ->count(5)
            ->create();
    }
}
