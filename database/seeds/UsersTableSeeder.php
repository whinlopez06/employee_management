<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ordinary   
        $users = factory(App\User::class, 30)->create();
    }
}
