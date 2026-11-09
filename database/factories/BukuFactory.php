<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Buku>
 */
class BukuFactory extends Factory
{
    protected $model = Buku::class;

    protected static int $urutan = 0;

    protected array $daftarBuku = [
        ['Laskar Pelangi', 'Andrea Hirata', 2005, 'Novel',
            'Mengisahkan perjuangan sepuluh anak di Belitung yang bersekolah di SD Muhammadiyah dengan segala keterbatasan. Novel ini menyoroti semangat belajar, persahabatan, dan mimpi besar di tengah kesederhanaan. Dituturkan dengan gaya bahasa yang hangat dan penuh humor. Menjadi salah satu novel Indonesia paling populer sepanjang masa.'],
        ['Bumi Manusia', 'Pramoedya Ananta Toer', 1980, 'Novel Sejarah',
            'Bagian pertama dari Tetralogi Buru yang mengangkat kisah Minke, pemuda pribumi terpelajar di masa kolonial Hindia Belanda. Menggambarkan pergolakan sosial, cinta, dan ketidakadilan rasial pada awal abad ke-20. Ditulis Pramoedya saat menjalani masa tahanan di Pulau Buru. Dianggap sebagai salah satu karya sastra terpenting Indonesia.'],
        ['Filosofi Teras', 'Henry Manampiring', 2018, 'Pengembangan Diri',
            'Membahas filsafat Stoisisme kuno dan bagaimana ajarannya relevan untuk mengatasi kecemasan hidup modern. Ditulis dengan bahasa ringan dan banyak contoh kasus sehari-hari. Membantu pembaca membedakan hal yang bisa dan tidak bisa dikendalikan. Salah satu buku pengembangan diri terlaris di Indonesia.'],
        ['Cantik Itu Luka', 'Eka Kurniawan', 2002, 'Fiksi',
            'Kisah Dewi Ayu, seorang pelacur cantik di kota fiktif Halimunda, dan empat anak perempuannya. Memadukan realisme magis dengan sejarah kelam Indonesia, dari masa kolonial hingga pasca-kemerdekaan. Gaya penceritaannya berani dan penuh simbolisme. Telah diterjemahkan ke banyak bahasa dan mendapat pengakuan internasional.'],
        ['Sapiens: Riwayat Singkat Umat Manusia', 'Yuval Noah Harari', 2011, 'Non-Fiksi',
            'Menelusuri perjalanan panjang manusia dari zaman berburu-meramu hingga era revolusi kognitif, agrikultur, dan teknologi. Menawarkan perspektif baru tentang bagaimana mitos, agama, dan uang membentuk peradaban. Ditulis dengan gaya naratif yang mudah dicerna meski membahas topik berat. Menjadi buku non-fiksi fenomenal di seluruh dunia.'],
        ['Negeri 5 Menara', 'Ahmad Fuadi', 2009, 'Novel',
            'Bercerita tentang Alif dan lima sahabatnya yang menuntut ilmu di pondok pesantren Gontor. Mengangkat semangat mantra "man jadda wajada" (siapa bersungguh-sungguh akan berhasil). Menggabungkan kisah persahabatan, perjuangan, dan pencarian jati diri. Terinspirasi dari pengalaman pribadi penulis di pesantren.'],
        ['Atomic Habits', 'James Clear', 2018, 'Pengembangan Diri',
            'Menjelaskan bagaimana perubahan kecil dan konsisten dapat membentuk kebiasaan besar dalam jangka panjang. Memperkenalkan kerangka kerja praktis: cue, craving, response, dan reward. Dilengkapi studi kasus atlet, pebisnis, dan ilmuwan. Menjadi rujukan utama dalam membangun disiplin diri secara bertahap.'],
        ['Ronggeng Dukuh Paruk', 'Ahmad Tohari', 1982, 'Novel Sejarah',
            'Mengisahkan Srintil, seorang penari ronggeng di desa terpencil, yang hidupnya terseret arus politik tahun 1965. Menggambarkan kearifan lokal Jawa sekaligus tragedi kemanusiaan akibat pergolakan sejarah. Dituturkan dengan bahasa puitis dan penuh nuansa budaya. Trilogi ini pernah dilarang terbit pada masa Orde Baru.'],
        ['Sebuah Seni untuk Bersikap Bodo Amat', 'Mark Manson', 2016, 'Pengembangan Diri',
            'Menawarkan pandangan berbeda tentang kebahagiaan: bukan dengan berpikir positif terus-menerus, melainkan dengan menerima keterbatasan. Mengajak pembaca memilih dengan sadar hal-hal yang layak diperjuangkan. Ditulis dengan gaya blak-blakan dan penuh humor gelap. Populer karena pendekatannya yang anti-mainstream.'],
        ['Pulang', 'Leila S. Chudori', 2012, 'Novel Sejarah',
            'Mengikuti kisah Dimas Suryo, eksil politik Indonesia yang terdampar di Paris pasca peristiwa 1965. Mengangkat tema kerinduan akan tanah air, identitas, dan luka sejarah bangsa. Alur cerita berpindah antara Jakarta dan Paris lintas generasi. Ditulis berdasarkan riset mendalam terhadap para eksil politik Indonesia.'],
        ['Clean Code', 'Robert C. Martin', 2008, 'Teknologi',
            'Membahas prinsip dan praktik menulis kode program yang rapi, mudah dibaca, dan mudah dirawat. Mencakup penamaan variabel, fungsi, penanganan error, hingga pengujian kode. Banyak dijadikan rujukan wajib bagi pengembang perangkat lunak. Menekankan bahwa kode yang bersih adalah tanda profesionalisme seorang programmer.'],
        ['Gadis Kretek', 'Ratih Kumala', 2012, 'Novel Sejarah',
            'Mengisahkan perebutan warisan resep rokok kretek antar generasi sebuah keluarga di Jawa Tengah. Memadukan drama keluarga dengan latar sejarah industri kretek Indonesia sejak masa kolonial. Mengungkap rahasia cinta masa lalu yang memengaruhi konflik masa kini. Telah diadaptasi menjadi serial televisi populer.'],
        ['Educated', 'Tara Westover', 2018, 'Non-Fiksi',
            'Memoar tentang seorang perempuan yang tumbuh tanpa pendidikan formal di keluarga fundamentalis pegunungan Idaho. Menceritakan perjuangannya belajar sendiri hingga akhirnya meraih gelar doktor dari Cambridge. Mengangkat tema keluarga, kebebasan berpikir, dan pengorbanan demi ilmu. Mendapat pujian luas atas kejujuran dan kedalaman ceritanya.'],
        ['Ayat-Ayat Cinta', 'Habiburrahman El Shirazy', 2004, 'Novel',
            'Mengisahkan Fahri, mahasiswa Indonesia di Universitas Al-Azhar, Kairo, yang menghadapi ujian cinta dan keimanan. Memadukan nilai-nilai religi dengan kisah romansa yang menyentuh. Menjadi pelopor genre novel islami populer di Indonesia. Telah diadaptasi menjadi film layar lebar yang sukses besar.'],
        ['Sang Pemimpi', 'Andrea Hirata', 2006, 'Novel',
            'Sekuel Laskar Pelangi yang mengikuti Ikal dan Arai menempuh pendidikan menengah di Belitung sambil bermimpi kuliah ke Prancis. Mengangkat tema kegigihan mengejar cita-cita meski berasal dari keluarga sederhana. Dipenuhi humor khas remaja dan momen haru keluarga. Melanjutkan semangat inspiratif dari buku pertamanya.'],
        ['Dilan: Dia adalah Dilanku Tahun 1990', 'Pidi Baiq', 2014, 'Novel',
            'Mengisahkan kisah cinta remaja antara Milea dan Dilan di Bandung era 1990-an dengan gaya bahasa ringan dan jenaka. Menonjolkan pendekatan Dilan yang unik dan tidak biasa dibanding remaja pada umumnya. Dibumbui nostalgia budaya pop Indonesia era 90-an. Sukses besar dan diadaptasi menjadi film yang digandrungi banyak penonton.'],
    ];

    public function definition(): array
    {
        [$judul, $penulis, $tahun, $kategori, $deskripsi] = $this->daftarBuku[static::$urutan++ % count($this->daftarBuku)];

        return [
            'kategori_id' => Kategori::where('nama', $kategori)->value('id'),
            'judul' => $judul,
            'penulis' => $penulis,
            'tahun_terbit' => $tahun,
            'deskripsi' => $deskripsi,
        ];
    }
}
