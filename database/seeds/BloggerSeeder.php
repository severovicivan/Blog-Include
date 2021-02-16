<?php

use Illuminate\Database\Seeder;
use App\User;

class BloggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first' => 'Ivan',
            'last' => 'Severovic',
            'email' => 'vetapp4you@gmail.com',
            'password' => bcrypt('seve1234'),
            'role' => 'blogger'
        ]);
    }
}
