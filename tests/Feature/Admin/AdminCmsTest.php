<?php

namespace Tests\Feature\Admin;

use App\Models\Feedback;
use App\Models\KlasterILP;
use App\Models\Layanan;
use App\Models\Post;
use App\Models\Reminder;
use App\Models\ReminderLog;
use App\Models\User;
use App\Services\WhatsAppGatewayService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $superadmin;
    protected User $petugas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::factory()->create([
            'nama_lengkap' => 'dr. Super Admin',
            'username'     => 'superadmin',
            'peran'        => 'superadmin',
            'status'       => 'aktif',
        ]);

        $this->petugas = User::factory()->create([
            'nama_lengkap' => 'Petugas Bidan',
            'username'     => 'petugas',
            'peran'        => 'admin',
            'status'       => 'aktif',
        ]);
    }

    public function test_guests_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Panel Admin CMS');
        $response->assertSee('Total Post Terbit');
        $response->assertSee('Pasien Reminder');
        $response->assertSee('WA Berhasil Terkirim');
        $response->assertSee('Saran Belum Dibaca');
        $response->assertSee('Konten Terbaru');
        $response->assertSee('Saran Terkini');
        $response->assertSee('Log Reminder Terakhir');
        $response->assertViewHasAll([
            'totalPost',
            'totalPasienReminder',
            'totalWaBerhasil',
            'totalSaranBelumDibaca',
            'kontenTerbaru',
            'saranTerkini',
            'logReminderTerakhir',
        ]);
    }

    public function test_admin_can_create_klaster_ilp(): void
    {
        $response = $this->actingAs($this->petugas)->post('/admin/klaster', [
            'nama'      => 'Klaster 2: Pelayanan Ibu dan Anak',
            'deskripsi' => 'Fokus pelayanan kesehatan ibu hamil dan balita',
        ]);

        $response->assertRedirect(route('admin.klaster.index'));
        $this->assertDatabaseHas('klaster_ilp', [
            'nama' => 'Klaster 2: Pelayanan Ibu dan Anak',
        ]);
    }

    public function test_admin_can_create_layanan_poli(): void
    {
        $klaster = KlasterILP::create([
            'nama' => 'Klaster 3: Dewasa',
            'slug' => 'klaster-3-dewasa',
        ]);

        $response = $this->actingAs($this->petugas)->post('/admin/layanan', [
            'nama_poli'      => 'Poli Gigi & Mulut',
            'klaster_id'     => $klaster->id,
            'jadwal_praktik' => 'Senin–Jumat | 08:00–12:00 WIB',
            'tenaga_medis'   => 'drg. Santi Widyajanti',
            'deskripsi'      => 'Pemeriksaan dan penambalan gigi',
            'status'         => 'aktif',
        ]);

        $response->assertRedirect(route('admin.layanan.index'));
        $this->assertDatabaseHas('layanan', [
            'nama_poli' => 'Poli Gigi & Mulut',
        ]);
    }

    public function test_admin_can_view_posts_index_with_filters(): void
    {
        $klaster = KlasterILP::create(['nama' => 'Klaster 1: Manajemen', 'slug' => 'klaster-1']);
        Post::create([
            'judul' => 'Berita Kegiatan 1',
            'tipe' => 'berita',
            'status' => 'published',
            'isi' => 'Konten berita 1',
            'klaster_id' => $klaster->id,
            'admin_id' => $this->petugas->id,
        ]);
        Post::create([
            'judul' => 'Laporan Akuntabilitas Tahunan',
            'tipe' => 'laporan',
            'status' => 'draft',
            'isi' => 'Konten laporan tahunan',
            'admin_id' => $this->petugas->id,
        ]);

        $response = $this->actingAs($this->petugas)->get('/admin/posts');
        $response->assertStatus(200);
        $response->assertSee('Kelola Informasi');
        $response->assertSee('Berita Kegiatan 1');
        $response->assertSee('Laporan Akuntabilitas Tahunan');

        // Test filter search
        $searchResponse = $this->actingAs($this->petugas)->get('/admin/posts?search=Akuntabilitas');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Laporan Akuntabilitas Tahunan');
        $searchResponse->assertDontSee('Berita Kegiatan 1');

        // Test filter tipe
        $tipeResponse = $this->actingAs($this->petugas)->get('/admin/posts?tipe=berita');
        $tipeResponse->assertStatus(200);
        $tipeResponse->assertSee('Berita Kegiatan 1');
        $tipeResponse->assertDontSee('Laporan Akuntabilitas Tahunan');
    }

    public function test_admin_can_view_post_create_and_edit_page(): void
    {
        $createResponse = $this->actingAs($this->petugas)->get('/admin/posts/create');
        $createResponse->assertStatus(200);
        $createResponse->assertSee('Tambah Konten Baru');
        $createResponse->assertSee('Laporan Program');

        $post = Post::create([
            'judul' => 'Post Untuk Diedit',
            'tipe' => 'berita',
            'status' => 'published',
            'isi' => 'Isi awal postingan',
            'admin_id' => $this->petugas->id,
        ]);

        $editResponse = $this->actingAs($this->petugas)->get('/admin/posts/' . $post->id . '/edit');
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Ubah Data Konten Publikasi');
        $editResponse->assertSee('Post Untuk Diedit');
    }

    public function test_admin_can_create_post(): void
    {
        $response = $this->actingAs($this->petugas)->post('/admin/posts', [
            'judul'  => 'Penyuluhan Kesehatan Balita Posyandu Melati',
            'tipe'   => 'berita',
            'status' => 'published',
            'isi'    => '<p>Uraian kegiatan posyandu dan penyuluhan gizi seimbang.</p>',
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'judul' => 'Penyuluhan Kesehatan Balita Posyandu Melati',
        ]);
    }

    public function test_admin_can_create_laporan_with_pdf_and_thumbnail_upload(): void
    {
        Storage::fake('public');

        $thumbnail = UploadedFile::fake()->image('cover.jpg', 600, 400);
        $pdf = UploadedFile::fake()->create('laporan.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->petugas)->post('/admin/posts', [
            'judul'          => 'Laporan Tahunan SPJ BOK 2026',
            'tipe'           => 'laporan',
            'status'         => 'published',
            'isi'            => '<p>Rincian realisasi anggaran dan serapan program.</p>',
            'periode_bulan'  => 'Oktober',
            'periode_tahun'  => 2026,
            'foto_thumbnail' => $thumbnail,
            'file_pdf'       => $pdf,
        ]);

        $response->assertRedirect(route('admin.posts.index'));

        $post = Post::where('judul', 'Laporan Tahunan SPJ BOK 2026')->first();
        $this->assertNotNull($post);
        $this->assertEquals('laporan', $post->tipe);
        $this->assertEquals('Oktober', $post->periode_bulan);
        $this->assertEquals(2026, $post->periode_tahun);
        $this->assertNotNull($post->foto_thumbnail);
        $this->assertNotNull($post->file_pdf);

        Storage::disk('public')->assertExists($post->foto_thumbnail);
        Storage::disk('public')->assertExists($post->file_pdf);
    }

    public function test_admin_can_create_agenda_post(): void
    {
        $response = $this->actingAs($this->petugas)->post('/admin/posts', [
            'judul'           => 'Senam Lansia dan Skrining PTM Ciawigebang',
            'tipe'            => 'agenda',
            'status'          => 'published',
            'isi'             => '<p>Jadwal rutin senam kebugaran lansia.</p>',
            'waktu_kegiatan'  => '2026-10-30 08:00:00',
            'lokasi_kegiatan' => 'Balai Pertemuan Desa Ciawigebang',
            'sasaran_peserta' => 'Warga pra-lansia dan lansia 55+ tahun',
        ]);

        $response->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', [
            'judul'           => 'Senam Lansia dan Skrining PTM Ciawigebang',
            'tipe'            => 'agenda',
            'lokasi_kegiatan' => 'Balai Pertemuan Desa Ciawigebang',
            'sasaran_peserta' => 'Warga pra-lansia dan lansia 55+ tahun',
        ]);
    }

    public function test_admin_can_update_and_delete_post(): void
    {
        $post = Post::create([
            'judul'    => 'Judul Awal',
            'tipe'     => 'berita',
            'status'   => 'draft',
            'isi'      => 'Konten awal',
            'admin_id' => $this->petugas->id,
        ]);

        // Update post
        $updateResponse = $this->actingAs($this->petugas)->put('/admin/posts/' . $post->id, [
            'judul'  => 'Judul Yang Diperbarui',
            'tipe'   => 'berita',
            'status' => 'published',
            'isi'    => 'Konten yang sudah direvisi',
        ]);

        $updateResponse->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseHas('posts', [
            'id'     => $post->id,
            'judul'  => 'Judul Yang Diperbarui',
            'status' => 'published',
        ]);

        // Delete post
        $deleteResponse = $this->actingAs($this->petugas)->delete('/admin/posts/' . $post->id);
        $deleteResponse->assertRedirect(route('admin.posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_post_auto_slug_prevents_duplicate_collision(): void
    {
        $this->actingAs($this->petugas)->post('/admin/posts', [
            'judul'  => 'Penyuluhan DBD',
            'tipe'   => 'berita',
            'status' => 'published',
            'isi'    => 'Konten satu',
        ]);

        $this->actingAs($this->petugas)->post('/admin/posts', [
            'judul'  => 'Penyuluhan DBD',
            'tipe'   => 'berita',
            'status' => 'published',
            'isi'    => 'Konten dua',
        ]);

        $posts = Post::where('judul', 'Penyuluhan DBD')->get();
        $this->assertCount(2, $posts);
        $this->assertNotEquals($posts[0]->slug, $posts[1]->slug);
    }

    public function test_admin_can_view_and_update_feedback(): void
    {
        $feedback = Feedback::create([
            'nama_pengirim' => 'Warga Cilimus',
            'kontak'        => '081234567890',
            'subjek'        => 'Pelayanan Ramah',
            'isi_pesan'     => 'Petugas melayani dengan sangat cepat dan ramah.',
            'status'        => 'baru',
        ]);

        $indexResponse = $this->actingAs($this->petugas)->get(route('admin.saran.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Total Masukan');
        $indexResponse->assertSee('Belum Dibaca');
        $indexResponse->assertSee('Sudah Ditindaklanjuti');
        $indexResponse->assertSee('Warga Cilimus');
        $indexResponse->assertSee('Pelayanan Ramah');

        $feedbackResponse = $this->actingAs($this->petugas)->get(route('admin.feedback.index'));
        $feedbackResponse->assertStatus(200);

        $response = $this->actingAs($this->petugas)->get('/admin/saran/' . $feedback->id);
        $response->assertStatus(200);

        // Status automatically marks as dibaca when opened
        $this->assertDatabaseHas('feedbacks', [
            'id'     => $feedback->id,
            'status' => 'dibaca',
        ]);

        // Staf updates to selesai
        $patchResponse = $this->actingAs($this->petugas)->patch('/admin/saran/' . $feedback->id . '/read', [
            'status'           => 'selesai',
            'catatan_internal' => 'Sudah diteruskan ke kepala puskesmas.',
        ]);

        $patchResponse->assertRedirect();
        $this->assertDatabaseHas('feedbacks', [
            'id'               => $feedback->id,
            'status'           => 'selesai',
            'catatan_internal' => 'Sudah diteruskan ke kepala puskesmas.',
        ]);

        // Delete feedback
        $deleteResponse = $this->actingAs($this->petugas)->delete('/admin/saran/' . $feedback->id);
        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('feedbacks', [
            'id' => $feedback->id,
        ]);
    }

    public function test_superadmin_can_manage_users(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Akun Pengelola CMS');
        $response->assertSee('Superadmin');
        $response->assertSee('+ Tambah Akun Baru');

        // Create new user
        $createResponse = $this->actingAs($this->superadmin)->post('/admin/users', [
            'nama_lengkap' => 'Petugas Baru',
            'username'     => 'petugas_baru',
            'email'        => 'petugas_baru@puskesmascilimus.id',
            'password'     => 'password123',
            'peran'        => 'admin',
            'status'       => 'aktif',
        ]);

        $createResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'username' => 'petugas_baru',
        ]);

        $newUser = User::where('username', 'petugas_baru')->first();

        // Update user
        $updateResponse = $this->actingAs($this->superadmin)->put('/admin/users/' . $newUser->id, [
            'nama_lengkap' => 'Petugas Baru Diedit',
            'username'     => 'petugas_baru',
            'email'        => 'petugas_baru@puskesmascilimus.id',
            'peran'        => 'admin',
            'status'       => 'nonaktif',
        ]);

        $updateResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id'           => $newUser->id,
            'nama_lengkap' => 'Petugas Baru Diedit',
            'status'       => 'nonaktif',
        ]);

        // Prevent superadmin from deleting own account
        $deleteSelfResponse = $this->actingAs($this->superadmin)->delete('/admin/users/' . $this->superadmin->id);
        $deleteSelfResponse->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $this->superadmin->id,
        ]);

        // Delete other user
        $deleteOtherResponse = $this->actingAs($this->superadmin)->delete('/admin/users/' . $newUser->id);
        $deleteOtherResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $newUser->id,
        ]);
    }

    public function test_regular_admin_is_forbidden_from_managing_users(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_admin_layout_renders_sidebar_and_topbar_components(): void
    {
        Feedback::create([
            'nama_pengirim' => 'Warga Cilimus',
            'kontak'        => '08123456789',
            'subjek'        => 'Pelayanan Ramah',
            'isi_pesan'     => 'Pelayanan di poli umum sangat cepat dan memuaskan.',
            'status'        => 'baru',
        ]);

        $response = $this->actingAs($this->petugas)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Panel Admin');
        $response->assertSee('UPTD Puskesmas Cilimus');
        $response->assertSee(route('admin.dashboard'));
        $response->assertSee(route('admin.posts.index'));
        $response->assertSee(route('admin.clusters.index'));
        $response->assertSee(route('admin.layanan.index'));
        $response->assertSee(route('admin.profil.edit'));
        $response->assertSee(route('admin.reminders.patients'));
        $response->assertSee(route('admin.reminders.schedules'));
        $response->assertSee(route('admin.reminders.logs'));
        $response->assertSee(route('admin.saran.index'));
        $response->assertSee('Sistem Normal');
        $response->assertSee(route('admin.logout'));
        $response->assertSee('toggleSidebar()', false);
        $response->assertSee('data-admin-sidebar', false);
        $response->assertSee('data-admin-main', false);

        // Regular admin should not see user management link
        $response->assertDontSee(route('admin.users.index'));
    }

    public function test_superadmin_sees_kelola_akun_in_sidebar(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee(route('admin.users.index'));
        $response->assertSee('Superadmin only');
    }

    public function test_admin_can_logout_via_admin_logout_route(): void
    {
        $this->actingAs($this->petugas);
        $this->assertAuthenticated();

        $response = $this->post(route('admin.logout'));

        $this->assertGuest();
        $response->assertRedirect(route('admin.login'));
    }

    public function test_guest_can_render_admin_login_screen(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertSee('Portal Pengelola');
        $response->assertSee('UPTD Puskesmas Cilimus — Backoffice');
        $response->assertSee('Melayani dengan Sepenuh Hati');
        $response->assertSee('Masuk ke Dashboard');
    }

    public function test_authenticated_admin_is_redirected_to_dashboard_from_login_screen(): void
    {
        $response = $this->actingAs($this->petugas)->get(route('admin.login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_authenticate_via_admin_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login'), [
            'username' => 'petugas',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_cannot_authenticate_with_invalid_credentials(): void
    {
        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'username' => 'petugas',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('login_error');
    }

    public function test_admin_login_is_rate_limited_after_five_failed_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->from(route('admin.login'))->post(route('admin.login'), [
                'username' => 'petugas_limit',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->from(route('admin.login'))->post(route('admin.login'), [
            'username' => 'petugas_limit',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('login_error');
        $this->assertTrue(str_contains(session('errors')->first('login_error'), 'Terlalu banyak percobaan login'));
    }

    public function test_whatsapp_gateway_service_sends_message(): void
    {
        $gateway = app(WhatsAppGatewayService::class);
        $result = $gateway->sendMessage('+6281234567890', 'Pesan Uji Coba');

        $this->assertTrue($result['success']);
        $this->assertIsArray($result['response']);
    }

    public function test_reminder_send_daily_command_processes_active_schedules(): void
    {
        $klaster = KlasterILP::create(['nama' => 'Klaster 2: Ibu & Anak', 'slug' => 'klaster-2-kia']);
        $todayDay = (int) now()->format('j');

        $reminder = Reminder::create([
            'nama_pasien'      => 'Ibu Ani',
            'nomor_wa'         => '+6281234567891',
            'klaster_id'       => $klaster->id,
            'tipe_interval'    => 'bulanan',
            'hari_ke'          => $todayDay,
            'jam_kirim'        => '08:00:00',
            'template_pesan'   => 'Halo {nama_pasien}, jadwal kontrol pada {tanggal} di {nama_puskesmas}.',
            'status'           => 'aktif',
        ]);

        $this->artisan('reminder:send-daily')
            ->expectsOutputToContain('Menjalankan pengiriman pesan WhatsApp')
            ->assertSuccessful();

        $this->assertDatabaseHas('reminder_logs', [
            'reminder_id' => $reminder->id,
            'status'      => 'berhasil',
        ]);

        $log = ReminderLog::where('reminder_id', $reminder->id)->first();
        $this->assertStringContainsString('Ibu Ani', $log->pesan_terkirim);
        $this->assertStringContainsString('UPTD Puskesmas Cilimus', $log->pesan_terkirim);
    }

    public function test_admin_can_view_patients_tab_and_register_new_patient(): void
    {
        $klaster = KlasterILP::create(['nama' => 'Klaster 3: Dewasa', 'slug' => 'klaster-3']);

        $response = $this->actingAs($this->petugas)->get(route('admin.reminders.patients'));
        $response->assertStatus(200);
        $response->assertSee('Daftar Pasien Reminder WhatsApp');
        $response->assertSee('+ Daftarkan Pasien Baru');

        $storeResponse = $this->actingAs($this->petugas)->post(route('admin.reminders.storePatient'), [
            'nama_pasien'    => 'Bapak Budi Santoso',
            'nomor_wa'       => '081298765432',
            'klaster_id'     => $klaster->id,
            'tipe_interval'  => 'bulanan',
            'hari_ke'        => 15,
            'jam_kirim'      => '08:00',
            'template_pesan' => 'Mengingatkan kontrol rutin Prolanis Bpk {nama_pasien}.',
            'status'         => 'aktif',
        ]);

        $storeResponse->assertRedirect(route('admin.reminders.patients'));
        $this->assertDatabaseHas('reminders', [
            'nama_pasien' => 'Bapak Budi Santoso',
            'nomor_wa'    => '+6281298765432',
            'status'      => 'aktif',
        ]);
    }

    public function test_admin_can_view_schedules_tab_and_store_schedule(): void
    {
        $klaster = KlasterILP::create(['nama' => 'Klaster 4: P2P', 'slug' => 'klaster-4']);

        $response = $this->actingAs($this->petugas)->get(route('admin.reminders.schedules'));
        $response->assertStatus(200);
        $response->assertSee('Jadwal & Template Reminder WhatsApp');
        $response->assertSee('+ Buat Jadwal Baru');

        $storeResponse = $this->actingAs($this->petugas)->post(route('admin.reminders.storeSchedule'), [
            'nama_pasien'      => 'Pasien TB 01',
            'nomor_wa'         => '+628555123456',
            'klaster_id'       => $klaster->id,
            'tipe_interval'    => 'bulanan',
            'hari_ke'          => 10,
            'jam_kirim'        => '09:00',
            'template_pesan'   => 'Pengingat minum obat OAT {nama_pasien}.',
            'status'           => 'aktif',
        ]);

        $storeResponse->assertRedirect(route('admin.reminders.schedules'));
        $this->assertDatabaseHas('reminders', [
            'nama_pasien' => 'Pasien TB 01',
            'nomor_wa'    => '+628555123456',
        ]);
    }

    public function test_admin_can_send_test_whatsapp_message(): void
    {
        $klaster = KlasterILP::create(['nama' => 'Klaster Umum', 'slug' => 'klaster-umum']);
        $reminder = Reminder::create([
            'nama_pasien'    => 'Uji Coba Pasien',
            'nomor_wa'       => '+628999888777',
            'klaster_id'     => $klaster->id,
            'template_pesan' => 'Pesan uji {nama_pasien}',
            'status'         => 'aktif',
        ]);

        $response = $this->actingAs($this->petugas)->post(route('admin.reminders.sendTest'), [
            'reminder_id'  => $reminder->id,
            'target_phone' => '+628999888777',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reminder_logs', [
            'reminder_id' => $reminder->id,
            'status'      => 'berhasil',
        ]);
    }

    public function test_admin_can_view_logs_tab_and_retry_failed_transmission(): void
    {
        $klaster = KlasterILP::create(['nama' => 'Klaster 2', 'slug' => 'klaster-2-log']);
        $reminder = Reminder::create([
            'nama_pasien'    => 'Pasien Gagal Test',
            'nomor_wa'       => '+628111222333',
            'klaster_id'     => $klaster->id,
            'template_pesan' => 'Pesan pengingat kontrol',
            'status'         => 'aktif',
        ]);

        $log = ReminderLog::create([
            'reminder_id'    => $reminder->id,
            'waktu_kirim'    => now()->subDay(),
            'pesan_terkirim' => 'Pesan pengingat kontrol',
            'status'         => 'gagal',
            'keterangan'     => 'Koneksi timeout',
        ]);

        $response = $this->actingAs($this->petugas)->get(route('admin.reminders.logs'));
        $response->assertStatus(200);
        $response->assertSee('Riwayat Pengiriman Reminder WhatsApp');
        $response->assertSee('Pasien Gagal Test');
        $response->assertSee('Kirim Ulang');

        // Test retry
        $retryResponse = $this->actingAs($this->petugas)->post(route('admin.reminders.retry', $log->id));
        $retryResponse->assertRedirect();

        $log->refresh();
        $this->assertEquals('berhasil', $log->status);
    }

    public function test_admin_can_export_logs_to_excel_and_pdf(): void
    {
        $excelResponse = $this->actingAs($this->petugas)->get(route('admin.reminders.export.excel'));
        $excelResponse->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $excelResponse->headers->get('content-type'));

        $pdfResponse = $this->actingAs($this->petugas)->get(route('admin.reminders.export.pdf'));
        $pdfResponse->assertStatus(200);
        $pdfResponse->assertSee('Laporan Rekapitulasi Riwayat Pengiriman Reminder WhatsApp');
    }
}
