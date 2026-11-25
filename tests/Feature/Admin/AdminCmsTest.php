<?php

namespace Tests\Feature\Admin;

use App\Models\Feedback;
use App\Models\KlasterILP;
use App\Models\Layanan;
use App\Models\Post;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_admin_can_view_and_update_feedback(): void
    {
        $feedback = Feedback::create([
            'nama_pengirim' => 'Warga Cilimus',
            'kontak'        => '081234567890',
            'subjek'        => 'Pelayanan Ramah',
            'isi_pesan'     => 'Petugas melayani dengan sangat cepat dan ramah.',
            'status'        => 'baru',
        ]);

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
    }

    public function test_superadmin_can_manage_users(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/admin/users');
        $response->assertStatus(200);

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
        $response->assertRedirect('/');
    }
}
