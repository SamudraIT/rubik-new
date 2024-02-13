<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Role
        $supervisorRole = \App\Models\Role::create([
            'name' => 'supervisor',
            'guard_name' => 'web'
        ]);
        $penghuniRole = \App\Models\Role::create([
            'name' => 'penghuni',
            'guard_name' => 'web'
        ]);
        $dinasRole = \App\Models\Role::create([
            'name' => 'dinas',
            'guard_name' => 'web'
        ]);
        $nakesRole = \App\Models\Role::create([
            'name' => 'nakes',
            'guard_name' => 'web'
        ]);

        $supervisorPermission = [
            37,
            38,
            39,
            40,
            41,
            42,
            43,
            44,
            45,
            46,
            47,
            48,
            49,
            50,
            51,
            52,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60,
            81,
            82,
            83,
            84,
            85,
            86,
        ];

        $penghuniPermission = [
            37,
            38,
            40,
            41,
            42,
            43,
            44,
            45,
            46,
            47,
            48,
            49,
            50,
            52,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60,
            79,
            80,
            81
        ];

        $dinasPermission = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
            15,
            16,
            17,
            18,
            19,
            20,
            21,
            22,
            23,
            24,
            25,
            26,
            27,
            28,
            29,
            30,
            31,
            32,
            33,
            34,
            35,
            36,
            37,
            38,
            39,
            40,
            41,
            42,
            43,
            44,
            45,
            46,
            47,
            48,
            49,
            50,
            51,
            52,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60,
            61,
            62,
            63,
            64,
            65,
            66,
            67,
            68,
            69,
            70,
            71,
            72,
            73,
            74,
            75,
            76,
            77,
            78,
            82,
            83,
            84,
            85,
            86
        ];

        $nakesPermission = [
            49,
            50,
            52,
            53,
            54,
            55,
            56,
            57,
            58,
            59,
            60
        ];

        foreach ($supervisorPermission as $data) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $supervisorRole->id,
                'permission_id' => $data
            ]);
        }

        foreach ($penghuniPermission as $data) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $penghuniRole->id,
                'permission_id' => $data
            ]);
        }

        foreach ($dinasPermission as $data) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $dinasRole->id,
                'permission_id' => $data
            ]);
        }

        foreach ($nakesPermission as $data) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $nakesRole->id,
                'permission_id' => $data
            ]);
        }

        // Seed Master
        $panmas = \App\Models\MasterKecamatan::create([
            'nama' => 'Pancoran Mas',
        ]);

        $sawangan = \App\Models\MasterKecamatan::create([
            'nama' => 'Sawangan',
        ]);

        $bojong_sari = \App\Models\MasterKecamatan::create([
            'nama' => 'Bojong Sari',
        ]);

        $cipayung = \App\Models\MasterKecamatan::create([
            'nama' => 'Cipayung',
        ]);

        $sukmajaya = \App\Models\MasterKecamatan::create([
            'nama' => 'Sukmajaya',
        ]);

        $cilodong = \App\Models\MasterKecamatan::create([
            'nama' => 'Cilodong',
        ]);

        $cimanggis = \App\Models\MasterKecamatan::create([
            'nama' => 'Cimanggis',
        ]);

        $tapos = \App\Models\MasterKecamatan::create([
            'nama' => 'Tapos',
        ]);

        $beji = \App\Models\MasterKecamatan::create([
            'nama' => 'Beji',
        ]);

        $limo = \App\Models\MasterKecamatan::create([
            'nama' => 'Limo',
        ]);

        $cinere = \App\Models\MasterKecamatan::create([
            'nama' => 'Cinere',
        ]);

        // panmas
        \App\Models\MasterKelurahan::create([
            'nama' => 'Pancoran Mas',
            'master_kecamatan_id' => $panmas->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Depok',
            'master_kecamatan_id' => $panmas->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Depok Jaya',
            'master_kecamatan_id' => $panmas->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Mampang',
            'master_kecamatan_id' => $panmas->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Rangkapan Jaya Baru',
            'master_kecamatan_id' => $panmas->id,
        ]);

        // sawangan
        \App\Models\MasterKelurahan::create([
            'nama' => 'Sawangan Baru',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Sawangan Lama',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pasir Putih',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Kedaung',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cinangka',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pengasinan',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Bedahan',
            'master_kecamatan_id' => $sawangan->id,
        ]);

        // bojongsari
        \App\Models\MasterKelurahan::create([
            'nama' => 'Bojongsari Baru',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Curug',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pondok Petir',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Serua',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Duren Seribu',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Duren Mekar',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Bojongsari Lama',
            'master_kecamatan_id' => $bojong_sari->id,
        ]);

        // cipayung
        \App\Models\MasterKelurahan::create([
            'nama' => 'Cipayung',
            'master_kecamatan_id' => $cipayung->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cipayung Jaya',
            'master_kecamatan_id' => $cipayung->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Bojong Pondok Terong',
            'master_kecamatan_id' => $cipayung->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pondok Jaya',
            'master_kecamatan_id' => $cipayung->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Ratujaya',
            'master_kecamatan_id' => $cipayung->id,
        ]);

        //sukmajaya
        \App\Models\MasterKelurahan::create([
            'nama' => 'Tirtajaya',
            'master_kecamatan_id' => $sukmajaya->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Mekar Jaya',
            'master_kecamatan_id' => $sukmajaya->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Abadijaya',
            'master_kecamatan_id' => $sukmajaya->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cisalak',
            'master_kecamatan_id' => $sukmajaya->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Bakti Jaya',
            'master_kecamatan_id' => $sukmajaya->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Sukmajaya',
            'master_kecamatan_id' => $sukmajaya->id,
        ]);

        // cilodong
        \App\Models\MasterKelurahan::create([
            'nama' => 'Kalibaru',
            'master_kecamatan_id' => $cilodong->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cilodong',
            'master_kecamatan_id' => $cilodong->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Sukamaju',
            'master_kecamatan_id' => $cilodong->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Kalimulya',
            'master_kecamatan_id' => $cilodong->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Jatimulya',
            'master_kecamatan_id' => $cilodong->id,
        ]);

        // cimanggis
        \App\Models\MasterKelurahan::create([
            'nama' => 'Curug',
            'master_kecamatan_id' => $cimanggis->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Tugu',
            'master_kecamatan_id' => $cimanggis->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Harjamukti',
            'master_kecamatan_id' => $cimanggis->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pasir Gunung Selatan',
            'master_kecamatan_id' => $cimanggis->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Mekarsari',
            'master_kecamatan_id' => $cimanggis->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cisalak Pasar',
            'master_kecamatan_id' => $cimanggis->id,
        ]);

        // tapos
        \App\Models\MasterKelurahan::create([
            'nama' => 'Tapos',
            'master_kecamatan_id' => $tapos->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Leuwinaggung',
            'master_kecamatan_id' => $tapos->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Sukatani',
            'master_kecamatan_id' => $tapos->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Jatijajar',
            'master_kecamatan_id' => $tapos->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cilangkap',
            'master_kecamatan_id' => $tapos->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Cimpaeun',
            'master_kecamatan_id' => $tapos->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Sukamaju Baru',
            'master_kecamatan_id' => $tapos->id,
        ]);

        // beji
        \App\Models\MasterKelurahan::create([
            'nama' => 'Beji',
            'master_kecamatan_id' => $beji->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Beji Timur',
            'master_kecamatan_id' => $beji->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Kukusan',
            'master_kecamatan_id' => $beji->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Tanah Baru',
            'master_kecamatan_id' => $beji->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Kemirimuka',
            'master_kecamatan_id' => $beji->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pondok Cina',
            'master_kecamatan_id' => $beji->id,
        ]);

        // limo
        \App\Models\MasterKelurahan::create([
            'nama' => 'Meruyung',
            'master_kecamatan_id' => $limo->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Limo',
            'master_kecamatan_id' => $limo->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Grogol',
            'master_kecamatan_id' => $limo->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Krukut',
            'master_kecamatan_id' => $limo->id,
        ]);

        // cinere
        \App\Models\MasterKelurahan::create([
            'nama' => 'Cinere',
            'master_kecamatan_id' => $cinere->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Gandul',
            'master_kecamatan_id' => $cinere->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pangkalanjati Baru',
            'master_kecamatan_id' => $cinere->id,
        ]);

        \App\Models\MasterKelurahan::create([
            'nama' => 'Pangkalanjati',
            'master_kecamatan_id' => $cinere->id,
        ]);
    }
}
