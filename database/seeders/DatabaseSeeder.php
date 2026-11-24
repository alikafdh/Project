<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProfilPuskesmas;
use App\Models\KlasterILP;
use App\Models\Layanan;
use App\Models\Post;
use App\Models\Feedback;
use App\Models\Reminder;
use App\Models\ReminderLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SEED AKUN ADMIN & PETUGAS (Password default: 'password')
        $superadmin = User::create([
            'nama_lengkap' => 'dr. H. Hendra Wijaya',
            'username'     => 'superadmin',
            'email'        => 'superadmin@puskesmascilimus.id',
            'password'     => Hash::make('password'),
            'peran'        => 'superadmin',
            'status'       => 'aktif',
        ]);

        $petugas = User::create([
            'nama_lengkap' => 'Siti Nurhaliza, A.Md.Keb',
            'username'     => 'petugas_kia',
            'email'        => 'petugas_kia@puskesmascilimus.id',
            'password'     => Hash::make('password'),
            'peran'        => 'admin',
            'status'       => 'aktif',
        ]);

        // 2. SEED PROFIL PUSKESMAS CILIMUS
        ProfilPuskesmas::create([
            'visi' => 'Terwujudnya Pelayanan Kesehatan yang Bermutu, Adil, Merata, dan Terjangkau Menuju Masyarakat Cilimus Sehat dan Mandiri.',
            'misi' => [
                'Memberikan pelayanan kesehatan tingkat pertama yang komprehensif, bermutu, dan berorientasi pada kepuasan pasien.',
                'Meningkatkan tata kelola manajemen puskesmas yang transparan, akuntabel, dan berbasis teknologi informasi.',
                'Menggerakkan pembangunan berwawasan kesehatan dan memberdayakan masyarakat di seluruh wilayah kerja binaan.',
                'Memperkuat pencegahan, penanggulangan penyakit menular, dan pengendalian faktor risiko kesehatan lingkungan.',
                'Meningkatkan mutu sumber daya manusia kesehatan yang profesional, beretika, dan melayani dengan sepenuh hati.',
                'Memperkuat integrasi pelayanan kesehatan lintas klaster siklus hidup sesuai standar ILP Kemenkes RI.'
            ],
            'wilayah_kerja'     => 'Kecamatan Cilimus terdiri dari 12 desa binaan dengan cakupan luas wilayah 24.5 km² dan jumlah penduduk sasaran 52.400 jiwa.',
            'logo'              => 'uploads/profil/logo-puskesmas.png',
            'strukt_organisasi' => 'uploads/profil/sotk-cilimus-2024.png',
            'foto_fasilitas'    => 'uploads/profil/gedung-puskesmas.jpg',
            'no_telepon'        => '(0232) 8611118',
            'alamat'            => 'Jl. Raya Cilimus No. 219, Kec. Cilimus, Kab. Kuningan, Jawa Barat 45556',
            'email'             => 'puskesmascilimus@kuningankab.go.id',
            'koordinat_peta'    => '-6.9829285,108.4989679',
            'wa_number'         => '6281123456789',
        ]);

        // 3. SEED 5 KLASTER ILP KEMENKES
        $k1 = KlasterILP::create([
            'nama'      => 'Klaster 1: Manajemen Puskesmas',
            'slug'      => 'klaster-1-manajemen',
            'deskripsi' => 'Pengelolaan ketatausahaan, perencanaan anggaran, manajemen sumber daya, mutu pelayanan, serta sistem informasi kesehatan.',
        ]);

        $k2 = KlasterILP::create([
            'nama'      => 'Klaster 2: Pelayanan Ibu & Anak',
            'slug'      => 'klaster-2-ibu-dan-anak',
            'deskripsi' => 'Pelayanan kesehatan ibu hamil, bersalin, nifas, bayi baru lahir, balita, anak usia prasekolah, dan remaja (KIA/KB/MTBS).',
        ]);

        $k3 = KlasterILP::create([
            'nama'      => 'Klaster 3: Usia Dewasa & Lansia',
            'slug'      => 'klaster-3-dewasa-dan-lansia',
            'deskripsi' => 'Skrining kesehatan berkala, pengelolaan penyakit tidak menular (hipertensi, diabetes), pelayanan lansia resti, dan Prolanis.',
        ]);

        $k4 = KlasterILP::create([
            'nama'      => 'Klaster 4: Penanggulangan Penyakit Menular',
            'slug'      => 'klaster-4-penyakit-menular',
            'deskripsi' => 'Surveilans epidemiologi, imunisasi, penanggulangan TB-DOTS, kusta, DBD, HIV-AIDS, serta penyehatan kesehatan lingkungan.',
        ]);

        $k5 = KlasterILP::create([
            'nama'      => 'Lintas Klaster: Gawat Darurat & Penunjang',
            'slug'      => 'lintas-klaster',
            'deskripsi' => 'Pelayanan Unit Gawat Darurat (UGD 24 Jam), rawat persalinan PONED, instalasi farmasi, dan laboratorium klinis.',
        ]);

        // 4. SEED POLIKLINIK & UNIT LAYANAN
        Layanan::create([
            'nama_poli'      => 'Poli Pemeriksaan Umum',
            'slug'           => 'poli-umum',
            'deskripsi'      => 'Pelayanan pemeriksaan kesehatan umum, konsultasi medis, diagnosa penyakit, dan rujukan tingkat lanjut untuk masyarakat umum segala usia.',
            'jadwal_praktik' => 'Senin–Jumat | 07:30–12:00 WIB',
            'tenaga_medis'   => 'dr. Hendra Wijaya & Tim Medis',
            'gambar_alur'    => 'uploads/layanan/alur-poli-umum.png',
            'status'         => 'aktif',
            'klaster_id'     => $k3->id,
        ]);

        Layanan::create([
            'nama_poli'      => 'Poli Gigi & Mulut',
            'slug'           => 'poli-gigi',
            'deskripsi'      => 'Pelayanan kesehatan gigi dan mulut komprehensif meliputi penambalan gigi, pencabutan, pembersihan karang gigi (scaling), dan edukasi kebersihan mulut.',
            'jadwal_praktik' => 'Senin–Jumat | 07:30–12:00 WIB',
            'tenaga_medis'   => 'drg. Santi Widyajanti',
            'gambar_alur'    => 'uploads/layanan/alur-poli-gigi.png',
            'status'         => 'aktif',
            'klaster_id'     => $k3->id,
        ]);

        Layanan::create([
            'nama_poli'      => 'Poli KIA, KB & Imunisasi',
            'slug'           => 'poli-kia-kb',
            'deskripsi'      => 'Pemeriksaan antenatal care (ANC) ibu hamil, imunisasi dasar lengkap bayi/balita, pelayanan alat kontrasepsi KB, dan pemantauan gizi anak.',
            'jadwal_praktik' => 'Senin–Jumat | 07:30–12:00 WIB',
            'tenaga_medis'   => 'Bd. Hj. Titin Suprihatin, S.Tr.Keb',
            'gambar_alur'    => 'uploads/layanan/alur-poli-kia.png',
            'status'         => 'aktif',
            'klaster_id'     => $k2->id,
        ]);

        Layanan::create([
            'nama_poli'      => 'UGD & Persalinan 24 Jam',
            'slug'           => 'ugd-24-jam',
            'deskripsi'      => 'Penanganan kasus gawat darurat medis cepat 24 jam non-stop serta fasilitas persalinan normal darurat PONED oleh dokter jaga dan bidan siaga.',
            'jadwal_praktik' => 'Setiap Hari | 24 Jam Non-Stop',
            'tenaga_medis'   => 'Tim Dokter Jaga & Bidan Siaga PONED',
            'gambar_alur'    => 'uploads/layanan/alur-ugd.png',
            'status'         => 'aktif',
            'klaster_id'     => $k5->id,
        ]);

        // 5. SEED ARTIKEL (Laporan, Berita, & Agenda)
        Post::create([
            'judul'          => 'Laporan Akuntabilitas Kinerja Instansi Triwulan III 2026',
            'slug'           => 'laporan-akuntabilitas-kinerja-triwulan-iii-2026',
            'isi'            => '<p>Laporan pertanggungjawaban capaian target Standar Pelayanan Minimal (SPM) bidang kesehatan di wilayah kerja UPTD Puskesmas Cilimus.</p>',
            'tipe'           => 'laporan',
            'status'         => 'published',
            'foto_thumbnail' => 'uploads/thumbnails/thumb-laporan-1.jpg',
            'file_pdf'       => 'uploads/laporan/Laporan_Kinerja_TW3_2026.pdf',
            'periode_bulan'  => 'Oktober',
            'periode_tahun'  => 2026,
            'views'          => 142,
            'klaster_id'     => $k1->id,
            'admin_id'       => $superadmin->id,
        ]);

        Post::create([
            'judul'          => 'Penyuluhan Bahaya Hipertensi dan Cek Gula Darah Rutin Posbindu Cibeureum',
            'slug'           => 'penyuluhan-bahaya-hipertensi-dan-cek-gula-darah-cibeureum',
            'isi'            => '<p>Tim Promosi Kesehatan Puskesmas Cilimus menggelar skrining kesehatan terpadu deteksi dini penyakit tidak menular bagi warga usia produktif.</p>',
            'tipe'           => 'berita',
            'status'         => 'published',
            'foto_thumbnail' => 'uploads/thumbnails/thumb-berita-1.jpg',
            'views'          => 289,
            'klaster_id'     => $k3->id,
            'admin_id'       => $petugas->id,
        ]);

        Post::create([
            'judul'           => 'Pelaksanaan Pekan Imunisasi Nasional (PIN) Polio Serentak Posyandu Melati',
            'slug'            => 'pelaksanaan-pekan-imunisasi-nasional-polio-serentak',
            'isi'             => '<p>Pemberian tetes manis imunisasi polio gratis bagi seluruh balita usia 0–7 tahun guna mencegah kelumpuhan anak.</p>',
            'tipe'            => 'agenda',
            'status'          => 'published',
            'foto_thumbnail'  => 'uploads/thumbnails/thumb-agenda-1.jpg',
            'waktu_kegiatan'  => '2026-11-28 08:30:00',
            'lokasi_kegiatan' => 'Balai Desa Ciawigebang, Cilimus',
            'sasaran_peserta' => 'Balita usia 0–59 bulan bersama orang tua',
            'views'           => 315,
            'klaster_id'      => $k2->id,
            'admin_id'        => $petugas->id,
        ]);

        // 6. SEED FEEDBACK SARAN MASYARAKAT
        Feedback::create([
            'nama_pengirim' => 'Ibu Rahmawati',
            'kontak'        => '081298765432',
            'klaster_id'    => $k2->id,
            'subjek'        => 'Pelayanan Ramah di Loket KIA',
            'isi_pesan'     => 'Terima kasih kepada Bidan dan perawat poli KIA yang sangat sabar dan teliti memeriksa tumbuh kembang anak saya.',
            'status'        => 'baru',
        ]);

        // 7. SEED REMINDER PASIEN & JADWAL (Mendukung Otomasi Cron Scheduler)
        $rem1 = Reminder::create([
            'nama_pasien'      => 'Ibu Dewi Suryaningsih',
            'nomor_wa'         => '+6281234567890',
            'klaster_id'       => $k2->id,
            'tipe_interval'    => 'bulanan',
            'hari_ke'          => 24,
            'jam_kirim'        => '08:00:00',
            'next_run_at'      => '2026-11-24 08:00:00',
            'jadwal'           => 'Setiap Tgl 24',
            'template_pesan'   => 'Halo {nama_pasien}, mengingatkan jadwal Posyandu Balita bulanan pada tanggal {tanggal} di {lokasi_kegiatan}. Salam sehat Puskesmas Cilimus.',
            'status'           => 'aktif',
        ]);

        $rem2 = Reminder::create([
            'nama_pasien'      => 'Bapak Bambang Sutrisno',
            'nomor_wa'         => '+6281987654321',
            'klaster_id'       => $k3->id,
            'tipe_interval'    => 'bulanan',
            'hari_ke'          => 15,
            'jam_kirim'        => '07:30:00',
            'next_run_at'      => '2026-12-15 07:30:00',
            'jadwal'           => 'Setiap Tgl 15',
            'template_pesan'   => 'Yth. {nama_pasien}, jadwal kontrol rutin Prolanis & pengambilan obat hipertensi Anda jatuh pada {tanggal}. Jangan lupa membawa kartu BPJS.',
            'status'           => 'aktif',
        ]);

        // 8. SEED RIWAYAT LOG PENGIRIMAN (R7 Komposisi)
        ReminderLog::create([
            'reminder_id'    => $rem1->id,
            'waktu_kirim'    => '2026-10-24 08:00:14',
            'pesan_terkirim' => 'Halo Ibu Dewi Suryaningsih, mengingatkan jadwal Posyandu Balita bulanan pada tanggal 24 Oktober 2026 di Balai Desa Cibeureum. Salam sehat Puskesmas Cilimus.',
            'status'         => 'berhasil',
            'keterangan'     => 'Terkirim via WhatsApp Gateway API (Status: 200 OK)',
        ]);

        ReminderLog::create([
            'reminder_id'    => $rem2->id,
            'waktu_kirim'    => '2026-10-15 07:30:22',
            'pesan_terkirim' => 'Yth. Bapak Bambang Sutrisno, jadwal kontrol rutin Prolanis & pengambilan obat hipertensi Anda jatuh pada 15 Oktober 2026. Jangan lupa membawa kartu BPJS.',
            'status'         => 'berhasil',
            'keterangan'     => 'Terkirim via WhatsApp Gateway API (Status: 200 OK)',
        ]);
    }
}
