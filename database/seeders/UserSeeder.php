<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Daftar dosen unik dari data jadwal (unchanged)
        $dosenNames = [
            'SHOFFIN NAHWA UTAMA, S.Kom, M.T',
            'HANI NURHAYATI,M.T',
            'TRI MUKTI LESTARI,M.Kom',
            'Dr. CAHYO CRYSDIAN,MCS',
            'OKTA QOMARUDDIN AZIZ,S.Si., M.Kom',
            'Dr. FACHRUL KURNIAWAN, ST., M. MT., IPU',
            'A\'LA SYAUQI,M.Kom',
            'ASHRI SHABRINA AFRAH,M.T.',
            'JOHAN ERICKA WAHYU PRAKASA,M.Kom',
            'NURIZAL DWI PRIANDANI,S.Kom., M.Kom',
            'MILADINA RIZKA AZIZA,M.S.',
            'AJIB HANANI, S.Kom, M.T',
            'FAJAR ROHMAN HARIRI,M.Kom',
            'KHADIJAH FAHMI HAYATI HOLLE, S.Kom., M.Kom',
            'NOVRINDAH ALVI HASANAH,M.Kom',
            'Dr. TOTOK CHAMIDY,M.Kom',
            'RORO INDA MELANI, M.T.,M.Sc',
            'H. FATCHURROCHMAN,M.Kom',
            'AHMAD FAHMI KARAMI,M.Kom',
            'Prof. Dr. SUHARTONO, M.Kom',
            'H. SYAHIDUZ ZAMAN, M.Kom',
            'Dr. MUHAMMAD AINUL YAQIN, M.Kom',
            'Dr. ZAINAL ABIDIN,S.Kom, M.Kom',
            'Dr. AGUNG TEGUH WIBOWO ALMAIS, S.Kom, M.T.',
            'Dr. FRESY NUGROHO, M.T.',
            'Dr. IRWAN BUDI SANTOSO,S.Si., M.Kom',
            'NUR FITRIYAH AYU TUNJUNG SARI,M.Cs',
            'Dr. YUNIFA MIFTACHUL ARIF, M.T.',
            'SUPRIYONO,M.Kom',
            'Dr. MUHAMMAD FAISAL,S.Kom., M.T',
            'Dr. RIRIEN KUSUMAWATI, S.Si., M.Kom',
            'Dr. Ir. MOKHAMMAD AMIN HARIYADI, M.T',
            'ALLIN JUNIKHAH,M.T.',
            'YULIANTO,M.Pd.I',
            'ANITA SUFIA, MA',
            'NISWATUR ROKHMAH,Lc., M.Ag',
            'MOH. KAMILUS ZAMAN,M.P.d.I',
            'M. MUKHLIS FAHRUDDIN,M.S.I',
            'NOFI SRI UTAMI,S.Pd.,S.H., M.H.',
            'M. CHOLID ZAMZAMI, M.Pd',
            'SULIS EKA ARIYANING PUTRI,M.Pd',
            'PRIMA PURBASARI,M.Hum',
            'AMELIA NUR ABIDAH,S.S., M.A',
            'SHA SHA NAQIA,S.Pd., M.Pd',
            'Dr. H. MOCHAMAD IMAMUDIN,Lc., M.A',
        ];
        $mhsname = [
            'Kautsar Quraisy Al Hamidy',
            'Akhmad Faizal Ferdianto',
            'Izza Syahri Muharram',
            'Arum Puspita',
            'Faiza Arifatul Husna',
        ];

        // Membuat akun untuk setiap dosen
        foreach ($dosenNames as $index => $name) {
            $email = Str::slug(strtolower(str_replace(['.', ','], '', $name))) . '@universitas.com';
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);
        }

        // Membuat akun admin
        User::create([
            'name' => 'Admin UIN Malang',
            'email' => 'admin@universitas.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Membuat akun mahasiswa (named students)
        foreach ($mhsname as $index => $mname) {
            $firstname = strtolower(explode(' ', $mname)[0]);
            User::create([
                'name' => $mname,
                'email' => $firstname . '@student.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]);
        }

        // Membuat akun mahasiswa tambahan (generic)
        for ($i = 1; $i <= 7; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => 'mahasiswa' . $i . '@student.com',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]);
        }
    }
}
