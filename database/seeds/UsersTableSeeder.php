<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nip' => '00000000 000000 0 000',
            'nama' => 'Master',
            'username' => 'master',
            'password' => bcrypt('123456'),
            'tipe' => 'Master'
        ]);
    }
}
