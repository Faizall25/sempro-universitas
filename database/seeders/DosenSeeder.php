<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\BidangKeilmuan;
use Illuminate\Support\Str;

class DosenSeeder extends Seeder
{
    public function run()
    {
        // Mapping dosen ke bidang keilmuan berdasarkan Knowledge Groups
        $dosenBidangMapping = [
            // Web & Mobile Programming
            'A\'LA SYAUQI,M.Kom' => 'Web & Mobile Programming',
            'RORO INDA MELANI, M.T.,M.Sc' => 'Web & Mobile Programming',
            'NURIZAL DWI PRIANDANI,S.Kom., M.Kom' => 'Web & Mobile Programming',

            // Multimedia & Teknologi Informasi
            'HANI NURHAYATI,M.T' => 'Multimedia & Teknologi Informasi',
            'Dr. FRESY NUGROHO, M.T.' => 'Multimedia & Teknologi Informasi',
            'Dr. YUNIFA MIFTACHUL ARIF, M.T.' => 'Multimedia & Teknologi Informasi',
            'Dr. FACHRUL KURNIAWAN, ST., M. MT., IPU' => 'Multimedia & Teknologi Informasi',
            'Dr. MUHAMMAD FAISAL,S.Kom., M.T' => 'Multimedia & Teknologi Informasi',
            'AHMAD FAHMI KARAMI,M.Kom' => 'Multimedia & Teknologi Informasi',
            'Dr. H. MOCHAMAD IMAMUDIN,Lc., M.A' => 'Multimedia & Teknologi Informasi',

            // Information System
            'Dr. MUHAMMAD AINUL YAQIN, M.Kom' => 'Information System',
            'Dr. AGUNG TEGUH WIBOWO ALMAIS, S.Kom, M.T.' => 'Information System',
            'H. SYAHIDUZ ZAMAN, M.Kom' => 'Information System',
            'ASHRI SHABRINA AFRAH,M.T.' => 'Information System',
            'FAJAR ROHMAN HARIRI,M.Kom' => 'Information System',
            'Dr. TOTOK CHAMIDY,M.Kom' => 'Information System',

            // Software Engineering
            'SUPRIYONO,M.Kom' => 'Software Engineering',
            'Dr. ZAINAL ABIDIN,S.Kom, M.Kom' => 'Software Engineering',
            'NUR FITRIYAH AYU TUNJUNG SARI,M.Cs' => 'Software Engineering',
            'H. FATCHURROCHMAN,M.Kom' => 'Software Engineering',
            'Dr. RIRIEN KUSUMAWATI, S.Si., M.Kom' => 'Software Engineering',

            // Intelligent System
            'Dr. IRWAN BUDI SANTOSO,S.Si., M.Kom' => 'Intelligent System',
            'Prof. Dr. SUHARTONO, M.Kom' => 'Intelligent System',
            'Dr. CAHYO CRYSDIAN,MCS' => 'Intelligent System',
            'KHADIJAH FAHMI HAYATI HOLLE, S.Kom., M.Kom' => 'Intelligent System',
            'OKTA QOMARUDDIN AZIZ,S.Si., M.Kom' => 'Intelligent System',
            'TRI MUKTI LESTARI,M.Kom' => 'Intelligent System',

            // System & Network
            'JOHAN ERICKA WAHYU PRAKASA,M.Kom' => 'System & Network',
            'AJIB HANANI, S.Kom, M.T' => 'System & Network',
            'SHOFFIN NAHWA UTAMA, S.Kom, M.T' => 'System & Network',
        ];

        // Daftar dosen yang tidak ada di Knowledge Groups (diassign ke bidang keilmuan default)
        $defaultBidang = 'Software Engineering';
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

        foreach ($dosenNames as $name) {
            $user = User::where('name', $name)->first();
            $bidangName = $dosenBidangMapping[$name] ?? $defaultBidang;
            $bidang = BidangKeilmuan::where('name', $bidangName)->first();

            Dosen::create([
                'user_id' => $user->id,
                'nip' => 'NIP' . rand(1000000000, 9999999999),
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '1980-01-01',
                'asal_kota' => 'Malang',
                'bidang_keilmuan_id' => $bidang->id,
            ]);
        }
    }
}
