<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CounselorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
      {
        $now = Carbon::now();

        $data = [

            // 1. Irene Hutajulu
            [
                'user' => [
                    'name' => 'Irene Hutajulu, S.Psi., Psikolog',
                    'email' => 'irene.julu@gmail.com',
                    'phone' => '085355522231',
                ],
                'counselor' => [
                    'education' => 'S1 Psikologi & Profesi Psikolog – Universitas Kristen Maranatha',
                    'specialization' => 'Konseling Anak, Remaja, Dewasa, Keluarga & Pernikahan',
                    'description' => 'Psikolog berpengalaman lebih dari 20 tahun dalam konseling klinis, keluarga, EAP, dan asesmen SDM.',
                    'price_per_session' => 150000,
                ],
            ],

            // 2. Rumondang JK Napitu
            [
                'user' => [
                    'name' => 'Dra. Rumondang JK Napitu, M.Si., Psikolog',
                    'email' => 'rumondangjkn@gmail.com',
                    'phone' => '08127525107',
                ],
                'counselor' => [
                    'education' => 'S2 Magister Psikologi – Universitas Kristen Maranatha',
                    'specialization' => 'Psikoterapi, Konseling Pernikahan, Asesmen SDM',
                    'description' => 'Psikolog senior, Direktur Persona Quality, konsultan sekolah, perusahaan, dan EAP.',
                    'price_per_session' => 200000,
                ],
            ],

            // 3. Yuli Widiningsih
            [
                'user' => [
                    'name' => 'Yuli Widiningsih, S.Psi., M.Psi., Psikolog',
                    'email' => 'yuliwidiningsih@yahoo.co.id',
                    'phone' => '08127680091',
                ],
                'counselor' => [
                    'education' => 'S2 Profesi Psikologi – Universitas Padjadjaran',
                    'specialization' => 'Psikologi Klinis, Pendidikan, Psikodiagnostik',
                    'description' => 'Dosen dan psikolog klinis dengan pengalaman asesmen, penelitian, dan konseling.',
                    'price_per_session' => 150000,
                ],
            ],

            // 4. Dewi Amelia
            [
                'user' => [
                    'name' => 'Dewi Amelia, S.Psi., M.Psi., Psikolog',
                    'email' => 'dewiamelia@gmail.com',
                    'phone' => '081808250573',
                ],
                'counselor' => [
                    'education' => 'S2 Psikologi Industri & Organisasi – Universitas Indonesia',
                    'specialization' => 'Assessment Center, CBT, Konseling Karyawan',
                    'description' => 'Psikolog associate berpengalaman dalam assessment center, CBT, dan konseling organisasi.',
                    'price_per_session' => 150000,
                ],
            ],

            // 5. Hijriyati Cucuani
            [
                'user' => [
                    'name' => 'Dr. Hijriyati Cucuani, M.Psi., Psikolog',
                    'email' => 'hijriyati.cucuani@uin-suska.ac.id',
                    'phone' => '082384581486',
                ],
                'counselor' => [
                    'education' => 'S3 Ilmu Psikologi – Universitas Padjadjaran',
                    'specialization' => 'Psikologi Industri & Organisasi',
                    'description' => 'Dosen, peneliti, dan psikolog industri dengan fokus perilaku kerja dan organisasi.',
                    'price_per_session' => 200000,
                ],
            ],

            // 6. Lita Nurma Turnip
            [
                'user' => [
                    'name' => 'Lita Nurma Turnip, S.Psi., M.Psi., Psikolog',
                    'email' => 'litha_tnp@yahoo.co.id',
                    'phone' => '082210390262',
                ],
                'counselor' => [
                    'education' => 'S2 Profesi Psikologi – Universitas Persada Indonesia',
                    'specialization' => 'Konseling Anak, Remaja, Karyawan',
                    'description' => 'Psikolog dengan pengalaman EAP, sekolah, dan konseling perkembangan anak.',
                    'price_per_session' => 150000,
                ],
            ],

            // 7. Nidya Rizki
            [
                'user' => [
                    'name' => 'Nidya Rizki, M.Psi., Psikolog',
                    'email' => 'nidyarizki@yahoo.com',
                    'phone' => '082219021743',
                ],
                'counselor' => [
                    'education' => 'S2 Psikologi Klinis – Universitas Padjadjaran',
                    'specialization' => 'Psikologi Klinis, EAP, Assessment',
                    'description' => 'Psikolog klinis dengan pengalaman rumah sakit dan EAP perusahaan.',
                    'price_per_session' => 150000,
                ],
            ],

            // 8. Ratna Wilis
            [
                'user' => [
                    'name' => 'Ratna Wilis, S.Psi., Psikolog',
                    'email' => 'ratnawilis0301@gmail.com',
                    'phone' => '085237832634',
                ],
                'counselor' => [
                    'education' => 'S1 Psikologi & Profesi – Universitas Diponegoro',
                    'specialization' => 'Konseling Keluarga, Pernikahan, Trauma',
                    'description' => 'Psikolog dengan pengalaman panjang dalam konseling keluarga dan pengungsi.',
                    'price_per_session' => 150000,
                ],
            ],

            // 9. Agus Tiandri
            [
                'user' => [
                    'name' => 'Agus Tiandri, M.Psi.',
                    'email' => 'agustiandri@yahoo.com',
                    'phone' => '08111800445',
                ],
                'counselor' => [
                    'education' => 'S2 Psikologi Industri & Organisasi – Universitas Padjadjaran',
                    'specialization' => 'HR Consulting, Leadership, Coaching',
                    'description' => 'Praktisi HR senior, konsultan kepemimpinan dan pengembangan SDM.',
                    'price_per_session' => 200000,
                ],
            ],

            // 10. Hotmaida Dasalak
            [
                'user' => [
                    'name' => 'Hotmaida Dasalak, M.Psi., Psikolog',
                    'email' => 'dasalak.hotma@yahoo.com',
                    'phone' => '081365906787',
                ],
                'counselor' => [
                    'education' => 'S2 Psikologi – Universitas Kristen Maranatha',
                    'specialization' => 'Psikologi Klinis, Forensik, Terapi Keluarga',
                    'description' => 'Psikolog klinis dengan pengalaman asesmen, forensik, dan terapi keluarga.',
                    'price_per_session' => 150000,
                ],
            ],
        ];

        foreach ($data as $item) {
            $userId = DB::table('users')->insertGetId([
                'name' => $item['user']['name'],
                'email' => $item['user']['email'],
                'phone' => $item['user']['phone'],
                'role' => 'counselor',
                'profile_pic' => null,
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('counselors')->insert([
                'user_id' => $userId,
                'education' => $item['counselor']['education'],
                'specialization' => $item['counselor']['specialization'],
                'description' => $item['counselor']['description'],
                'price_per_session' => $item['counselor']['price_per_session'],
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
