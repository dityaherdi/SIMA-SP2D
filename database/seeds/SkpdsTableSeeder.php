<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SkpdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skpds')->insert([
            [
                'kode_skpd' => '1.01.01.',
                'nama_skpd' => 'DINAS PENDIDIKAN',
                'alias_skpd' => 'DISDIK',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.02.01.',
                'nama_skpd' => 'DINAS KESEHATAN',
                'alias_skpd' => 'DINKES',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.02.02.',
                'nama_skpd' => 'RUMAH SAKIT MATA BALI MANDARA',
                'alias_skpd' => 'RS BALI MANDARA',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.02.03.',
                'nama_skpd' => 'RUMAH SAKIT JIWA',
                'alias_skpd' => 'RSJ',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.03.01.',
                'nama_skpd' => 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG',
                'alias_skpd' => 'PUPR',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.04.01.',
                'nama_skpd' => 'DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN',
                'alias_skpd' => 'DISPERUMKIM',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.05.01.',
                'nama_skpd' => 'SATUAN POLISI PAMONG PRAJA',
                'alias_skpd' => 'SATPOLPP',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '1.06.01.',
                'nama_skpd' => 'DINAS SOSIAL',
                'alias_skpd' => 'DINSOS',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.01.01.',
                'nama_skpd' => 'DINAS TENAGA KERJA DAN ENERGI SUMBER DAYA MINERAL',
                'alias_skpd' => 'DISNAKER DAN ESDM',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.02.01.',
                'nama_skpd' => 'DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK',
                'alias_skpd' => 'DP3A',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.03.01.',
                'nama_skpd' => 'DINAS KETAHANAN PANGAN',
                'alias_skpd' => 'DINAS KETAHANAN PANGAN',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.05.01.',
                'nama_skpd' => 'DINAS LINGKUNGAN HIDUP',
                'alias_skpd' => 'DINAS LINGKUNGAN HIDUP',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.06.01.',
                'nama_skpd' => 'DINAS KEPENDUDUKAN, PENCATATAN SIPIL DAN KELUARGA BERENCANA',
                'alias_skpd' => 'DISDUKCAPIL DAN KB',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.07.01.',
                'nama_skpd' => 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA',
                'alias_skpd' => 'DPMD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.09.01.',
                'nama_skpd' => 'DINAS PERHUBUNGAN',
                'alias_skpd' => 'DISHUB',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.10.01.',
                'nama_skpd' => 'DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK',
                'alias_skpd' => 'DISKOMINFOS',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.11.01.',
                'nama_skpd' => 'DINAS KOPERASI, USAHA KECIL DAN MENENGAH',
                'alias_skpd' => 'DISKOPUKM',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.12.01.',
                'nama_skpd' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU',
                'alias_skpd' => 'DPMPTSP',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.13.01.',
                'nama_skpd' => 'DINAS KEPEMUDAAN DAN OLAHRAGA',
                'alias_skpd' => 'DISPORA',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.16.01.',
                'nama_skpd' => 'DINAS KEBUDAYAAN',
                'alias_skpd' => 'DISBUD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '2.17.01.',
                'nama_skpd' => 'DINAS KEARSIPAN DAN PERPUSTAKAAN',
                'alias_skpd' => 'BAPUSIP',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '3.01.01.',
                'nama_skpd' => 'DINAS KELAUTAN DAN PERIKANAN',
                'alias_skpd' => 'DISKELKAN',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '3.02.01.',
                'nama_skpd' => 'DINAS PARIWISATA',
                'alias_skpd' => 'DISPAR',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '3.03.01.',
                'nama_skpd' => 'DINAS TANAMAN PANGAN, HORTIKULTURA DAN PERKEBUNAN',
                'alias_skpd' => 'DISTANTP',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '3.03.02.',
                'nama_skpd' => 'DINAS PETERNAKAN DAN KESEHATAN HEWAN',
                'alias_skpd' => 'DISNAK KESWAN',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '3.04.01.',
                'nama_skpd' => 'DINAS KEHUTANAN',
                'alias_skpd' => 'DISHUT',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '3.07.01.',
                'nama_skpd' => 'DINAS PERINDUSTRIAN DAN PERDAGANGAN',
                'alias_skpd' => 'DISPERINDAG',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.01.00.',
                'nama_skpd' => 'POKOK PIKIRAN KEBUDAYAAN DAERAH',
                'alias_skpd' => 'PPKD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.01.01.',
                'nama_skpd' => 'DEWAN PERWAKILAN RAKYAT DAERAH',
                'alias_skpd' => 'DPRD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.01.02.',
                'nama_skpd' => 'KEPALA DAERAH',
                'alias_skpd' => 'KEPALA DAERAH',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.02.01.',
                'nama_skpd' => 'BADAN PERENCANAAN PEMBANGUNAN DAERAH, PENELITIAN DAN PENGEMBANGAN',
                'alias_skpd' => 'BAPPEDA DAN LITBANG',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.03.01.',
                'nama_skpd' => 'BADAN PENGELOLA KEUANGAN DAN ASET DAERAH',
                'alias_skpd' => 'BPKAD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.04.01.',
                'nama_skpd' => 'BADAN PENDAPATAN DAERAH',
                'alias_skpd' => 'BAPENDA',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.05.01.',
                'nama_skpd' => 'BADAN KEPEGAWAIAN DAERAH',
                'alias_skpd' => 'BKD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.06.01.',
                'nama_skpd' => 'BADAN PENGEMBANGAN SUMBER DAYA MANUSIA',
                'alias_skpd' => 'BPSDM',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.08.01.',
                'nama_skpd' => 'SEKRETARIAT DEWAN PERWAKILAN RAKYAT DAERAH',
                'alias_skpd' => 'SEKRETARIAT DPRD',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.09.01.',
                'nama_skpd' => 'SEKRETARIAT DAERAH',
                'alias_skpd' => 'SETDA',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.10.01.',
                'nama_skpd' => 'INSPEKTORAT',
                'alias_skpd' => 'SETDA',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.11.01.',
                'nama_skpd' => 'BADAN PENGHUBUNG',
                'alias_skpd' => 'SETDA',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.12.01.',
                'nama_skpd' => 'BADAN KESATUAN BANGSA DAN POLITIK',
                'alias_skpd' => 'KESBANGPOL',
                'created_at' => Carbon::now()
            ],
            [
                'kode_skpd' => '4.13.01.',
                'nama_skpd' => 'BADAN PENANGGULANGAN BENCANA DAERAH',
                'alias_skpd' => 'BPBD',
                'created_at' => Carbon::now()
            ],
        ]);
    }
}
