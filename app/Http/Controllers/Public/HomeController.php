<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Layanan;
use App\Models\Post;
use App\Models\ProfilPuskesmas;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda portal publik UPTD Puskesmas Cilimus.
     */
    public function index(): View
    {
        $profil = ProfilPuskesmas::firstOrFail();
        $klasters = KlasterILP::withCount(['layanan', 'posts'])->get();
        $layananUnggulan = Layanan::with('klaster')
            ->where('status', 'aktif')
            ->take(4)
            ->get();
        $laporanTerbaru = Post::with('klaster')
            ->where('tipe', 'laporan')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
        $beritaTerbaru = Post::with('klaster')
            ->where('tipe', 'berita')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
        $agendaTerdekat = Post::with('klaster')
            ->where('tipe', 'agenda')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('public.home', compact(
            'profil',
            'klasters',
            'layananUnggulan',
            'laporanTerbaru',
            'beritaTerbaru',
            'agendaTerdekat'
        ));
    }
}
