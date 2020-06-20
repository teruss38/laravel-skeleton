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
        //$this->call(Dcat\Admin\Models\AdminTablesSeeder::class);
        $this->call(AdminTablesSeeder::class);
        $this->call(SettingsSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
