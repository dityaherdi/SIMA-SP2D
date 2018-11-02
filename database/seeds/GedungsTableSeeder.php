<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class GedungsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gedungs')->insert([
            [
                'kode_gedung' => 'GED-01',
                'nama_gedung' => 'Gedung Arsip I Ahmad Yani',
                'created_at' => Carbon::now()
            ],
            [
                'kode_gedung' => 'GED-02',
                'nama_gedung' => 'Gedung Arsip II Badak Agung',
                'created_at' => Carbon::now()
            ]
        ]);
    }
}
