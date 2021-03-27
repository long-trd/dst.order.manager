<?php

use Illuminate\Database\Seeder;
use Cms\Modules\Core\Database\Seeds\SampleAuthSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SampleAuthSeeder::class);
    }
}
