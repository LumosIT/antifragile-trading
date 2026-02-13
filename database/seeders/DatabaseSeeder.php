<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cache::clear();

        $this->call(OptionsSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(TextsSeeder::class);

        if(env('APP_TEST')){
            $this->call(TestSeeder::class);
        }
    }
}
