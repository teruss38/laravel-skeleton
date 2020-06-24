<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dbConnection = DB::connection();
        if ($dbConnection->getConfig('driver') == 'mysql') {
            $tablePrefix = DB::connection()->getTablePrefix();
            DB::statement('ALTER TABLE ' . $tablePrefix . 'users AUTO_INCREMENT = 10000000');
            DB::statement('ALTER TABLE ' . $tablePrefix . 'user_social_accounts AUTO_INCREMENT = 10000000');
            DB::statement('ALTER TABLE ' . $tablePrefix . 'user_login_history AUTO_INCREMENT = 10000000');
            DB::statement('ALTER TABLE ' . $tablePrefix . 'messages AUTO_INCREMENT = 10000000');
            DB::statement('ALTER TABLE ' . $tablePrefix . 'oauth_clients AUTO_INCREMENT = 10000000');
        }

        $this->call(AdminSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PassportSeeder::class);
    }
}
