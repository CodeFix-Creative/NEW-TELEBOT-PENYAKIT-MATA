<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Glaukoma',
            'detail' => 'Suatu peningkatan tekanan intra okuler yang mendadak akibat tertutupnya sudut bilik depan mata oleh iris bagian perifir.',
            'penyebab' => 'Akibat dari penutupan sudut bilik mata depan yang terjadi tiba-tiba maka humor aquos akan menumpuk dibilik mata depan dan tekanan ini akan dilanjutkan kesegala arah. Penimbunan humor aquos berlangsung terus menerus sehingga tekanan dalam bola mata tambah tinggi akhirnya menimbulkan nyeri hebat.',
            'solusi' => 'Segera hubungi dokter mata terdekat',
            'score' => '80',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Conjunctivitis bakteri',
            'detail' => 'Peradangan pada konjungtiva ditandai dengan adanya pelebaran pembuluh darah konjungtiva, infiltrasi seluler dan eksudasi.',
            'penyebab' => 'Bakteri',
            'solusi' => 'Hubungi dokter mata terdekat.',
            'score' => '60',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Conjunctivitis virus',
            'detail' => 'Peradangan pada konjungtiva ditandai dengan adanya pelebaran pembuluh darah konjungtiva, infiltrasi seluler dan eksudasi.',
            'penyebab' => 'virus',
            'solusi' => 'Hubungi dokter mata terdekat.',
            'score' => '55',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Conjunctivitis allergen',
            'detail' => 'Peradangan pada konjungtiva ditandai dengan adanya pelebaran pembuluh darah konjungtiva, infiltrasi seluler dan eksudasi.',
            'penyebab' => 'alergi',
            'solusi' => 'Pengobatan dapat dilakukan dengan obat tetes mata, bila terasa parah segera hubungi dokter mata terdekat.',
            'score' => '65',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Gonoblenore',
            'detail' => 'radang selaput lendir mata yang sangat mendadak ditandai dengan getah mata yang bernanah yang kadang-kadang bercampur darah',
            'penyebab' => 'kuman Neisseria gonoroika',
            'solusi' => 'Hubungi dokter mata terdekat.',
            'score' => '40',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Katarak',
            'detail' => 'Merupakan keadaan dimana terjadi kekeruhan pada serabut atau bahan lensa didalam kapsul lensa.',
            'penyebab' => 'Proses degeneratif atau penuaan (snile cataract), cedera mata (traumatic cataract), diabetes, radang selaput pelangi, infeksi, cacat lahir, keturunan, radiasi yang berkepanjanagan.',
            'solusi' => 'Hubungi dokter mata terdekat.',
            'score' => '90',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Rabun dekat (Hipermetropia)',
            'detail' => 'Suatu kelainan refraksi dimana sinar-sinar yang datangnya dari tak terhingga, oleh mata tanpa akomodasi dibiaskan dibelakang retina.',
            'penyebab' => 'Pembiasan yang lemah, sumbu mata terlalu pendek, proses penuaan (Presbyopia) dan faktor keturunan (Hipermetropia)',
            'solusi' => 'Hubungi dokter mata terdekat.Menggunakan kacamata lensa sferis positif',
            'score' => '70',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Rabun jauh (Miopia)',
            'detail' => 'Kelainan refraksi dimana sinar-sinar yang datangya dari tak terhingga oleh mata tanpa akomodasi dibiaskan didepan retina.',
            'penyebab' => 'Sistem optic yang terlalu kuat, bola mata terlalu panjang, faktor keturunan, kesalahan dalam membaca dan mata terlalu sering lelah.',
            'solusi' => 'Hubungi dokter mata terdekat.Menggunakan kacamata lensa sferis negatif',
            'score' => '70',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Astigmatis (Silindris)',
            'detail' => 'Ketidakteraturan lengkung-lengkung permukaan bias mata yang berakibat tidak terpusatkannya sinar cahaya pada satu titik di selaput jala (retina) mata.',
            'penyebab' => 'Faktor keturunan, terlalu dekat dengan televisi.',
            'solusi' => 'Hubungi dokter mata terdekat.',
            'score' => '50',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Pterigrium',
            'detail' => 'Tampak sebagai penonjolan jaringan putih disertai pembuluh darah pada tepi dalam atau tepi luar kornea akibat penebalan konjungtiva bulbi berbentuk segitiga pada bagian nasal atau temporal.',
            'penyebab' => 'Banyak terkena sinar matahari, tinggal di daerah berdebu, berpasir atau anginnya besar. Oleh karena iritasi yang terus menerus pada konjungtiva maka akan terjadi reaksi penebalan dari konjungtiva tersebut dan terus tumbuh menuju ke sentral.',
            'solusi' => 'Bila masih kecil usahakan menghilangkan penyebabnya. Bila sudah mencapai stadium II atau lebih dilakukan operasi exterpasi oleh dokter. ',
            'score' => '35',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Trachoma',
            'detail' => 'Adalah infeksi pada mata yang disebabkan bakteri Chlamydia trachomatis. Biasanya menyerang anak-anak pada negara berkembang terutama pada daerah yang kotor.',
            'penyebab' => 'Bakteri Chlamydia trachomatis',
            'solusi' => 'Hubungi dokter mata terdekat ',
            'score' => '45',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Ablasio retina',
            'detail' => 'Suatu keadaan lepasnya retina sensoris dari epitel pigmen retina (RIDE). keadaan ini merupakan masalah mata yang serius dan dapat terjadi pada usia berapapun, walaupun biasanya terjadi pada orang usia setengah baya atau lebih tua.',
            'penyebab' => 'Robekan/lubang di retina, penuaan, trauma.',
            'solusi' => 'Segera hubungi dokter mata terdekat ',
            'score' => '30',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Herpes simplex',
            'detail' => 'Penyakit mata yang disebabkan oleh virus Simplex, yaitu virus yang biasa menyerang dan menyebabkan penyakit kulit dan kelamin.',
            'penyebab' => 'Virus Simplex',
            'solusi' => 'Hubungi dokter mata terdekat',
            'score' => '25',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Herpes zoster',
            'detail' => 'Penyakit mata yang disebabkan oleh virus Zoster, yaitu virus yang biasa menyerang dan menyebabkan penyakit kulit dan kelamin.',
            'penyebab' => 'Virus Zoster',
            'solusi' => 'Hubungi dokter mata terdekat',
            'score' => '20',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Xeroftalmia',
            'detail' => 'Penyakit mata yang ditandai oleh pengeringan selaput mata dan selaput bening, karena kekurangan vitamin A.',
            'penyebab' => 'Kekurangan vitamin A, penuaan, sering memakai lensa kontak, pemakaian komputer yang berlebihan',
            'solusi' => 'Tambah asupan vitamin A dan hubungi dokter mata terdekat',
            'score' => '15',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Endoftalmitis',
            'detail' => 'Merupakan radang purulen pada seluruh jaringan intra okuler disertai dengan terbentuknya abses didalam badan kaca.',
            'penyebab' => 'Sepsis, selulitis orbita, trauma tembus, ulkus.',
            'solusi' => 'Hubungi dokter mata',
            'score' => '16',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Panoftalmitis',
            'detail' => 'Keradangan purulen seluruh jaringan intra okuler disertai dengan jaringan adneksa.',
            'penyebab' => 'perluasan infeksi endoftalmitis',
            'solusi' => 'Hubungi dokter mata',
            'score' => '17',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Uveitis',
            'detail' => 'Keradangan pada organ uvea.',
            'penyebab' => 'TBC, sifilis, diabetes mellitus, trauma mata.',
            'solusi' => 'Hubungi dokter mata',
            'score' => '18',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Ulkus Kornea',
            'detail' => 'Peradangan pada kornea yang diikuti kerusakan lapisan kornea, kerusakan dimulai dengan lapisan epitel.',
            'penyebab' => 'Trauma dengan infeksi, konjungtivitas gonoblenore, konjungtivitas diphteri, defisiensi vitamin A, lagophthalmus.',
            'solusi' => 'Kebersihan mata harus diperhatikan. Juga hygiene dari seluruh tubuh penderita diperhatikan, disamping keadaan gizi penderita tersebut dan segera hubungi dokter mata',
            'score' => '19',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Keratitis',
            'detail' => 'Peradangan pada kornea yang dapat mengenai lapisan supersial disebut dengan keratitis superfisial dan profunda disebut dengan keratitis profunda.',
            'penyebab' => 'Bakteri, virus, jamur, toksin.',
            'solusi' => 'Hubungi dokter mata terdekat.Perawatan yang utama adalah kebersihan mata. Kemudian dilakukan kompres hangat untuk yang penyebabnya bakteri dan kompres dingin untuk yang penyebabnya herpes simplek. Mata harus diistirahatkan',
            'score' => '14',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Hordeolum',
            'detail' => 'Infeksi akut supuratif kelenjar Zeis dan Moll pada palpebra.',
            'penyebab' => 'stafilokokus',
            'solusi' => 'Bila fluktuasi negatif maka cukup dilakukan kompres hangat 10 - 15 menit sehari 3 kali. jika pembengkakan terasa parah, hubungi dokter mata terdekat',
            'score' => '21',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Retinopati diabetika',
            'detail' => 'Kelainan pada retina akibat penyakit Diabetes Melitus.',
            'penyebab' => 'Diabetes mellitus yang tidak terkontrol.',
            'solusi' => 'Segera hubungi Dokter mata terdekat.',
            'score' => '22',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Retinopati hypertensi',
            'detail' => 'Kelainan pada retina berupa perdarahan atau eksudat yang disebabkan oleh hypertensi.',
            'penyebab' => 'hypertensi',
            'solusi' => 'Hubungi Dokter mata terdekat. ',
            'score' => '23',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Retinoblastoma',
            'detail' => 'Tumor ganas mata yang berasal dari lapisan neuretina.',
            'penyebab' => 'Bersifat kongential (dominant autosum)',
            'solusi' => 'Segera hubungi Dokter mata terdekat. ',
            'score' => '24',
            'status' => 'Aktif',
        ]);
        DB::table('penyakit')->insert([
            'nama_penyakit' => 'Dakriosistitis',
            'detail' => 'Merupakan peradangan pada sakus lakrimal (yaitu kelenjar yang terapat pada kantung kelopak mata bagian bawah). Biasanya Dakriosistitis didapatkan pada orang tua dengan hygiene yang kurang.',
            'penyebab' => 'Penyumbatan duktus nasolakrimal, sekunder tehadap adanya mokusel, penyumbatan oleh bakteri yang berkembang biak (kuman staphylococ, pneumococ dan streptococ).',
            'solusi' => 'Segera hubungi Dokter mata terdekat.Jaga kebersihan mata ',
            'score' => '13',
            'status' => 'Aktif',
        ]);
    }
}
