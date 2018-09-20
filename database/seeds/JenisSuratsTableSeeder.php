<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JenisSuratsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_surats')->insert([
            [
                'kode_jenis_sp2d' => 'UP',
                'nama_jenis_sp2d' => 'Uang Persediaan',
                'created_at' => Carbon::now()
            ],
            [
                'kode_jenis_sp2d' => 'GU',
                'nama_jenis_sp2d' => 'Ganti Uang',
                'created_at' => Carbon::now()
            ],
            [
                'kode_jenis_sp2d' => 'TU',
                'nama_jenis_sp2d' => 'Tambah Uang',
                'created_at' => Carbon::now()
            ],
            [
                'kode_jenis_sp2d' => 'LS',
                'nama_jenis_sp2d' => 'Lumpsum Gaji dan Tunjangan',
                'created_at' => Carbon::now()
            ],
            [
                'kode_jenis_sp2d' => 'LS',
                'nama_jenis_sp2d' => 'Lumpsum Barang dan Jasa',
                'created_at' => Carbon::now()
            ],
            [
                'kode_jenis_sp2d' => 'LS',
                'nama_jenis_sp2d' => 'Lumpsum Barang dan Jasa Non-Pihak Ketiga',
                'created_at' => Carbon::now()
            ],
            [
                'kode_jenis_sp2d' => 'LS',
                'nama_jenis_sp2d' => 'Lumpsum Bunga, Subsidi, Hibah, Bantuan, Bagi Hasil, dan Pembiayaan',
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
