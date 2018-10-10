<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nip' => '00000000 000000 0 000',
                'nama' => 'Master',
                'username' => 'master',
                'password' => bcrypt('123456'),
                'tipe' => 'Master'
            ],
            [
                'nip' => '11111111 111111 1 111',
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'tipe' => 'Admin'
            ],
            [
                'nip' => '22222222 222222 2 222',
                'nama' => 'Pimpinan',
                'username' => 'pimpinan',
                'password' => bcrypt('123456'),
                'tipe' => 'Pimpinan'
            ]
        ]);
    }
}
