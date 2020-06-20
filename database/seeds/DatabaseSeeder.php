<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTablesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(PassportSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
