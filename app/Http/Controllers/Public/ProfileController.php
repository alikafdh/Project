<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProfilPuskesmas;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman default profil puskesmas (Visi, Misi & Tata Nilai).
     */
    public function index(): View
    {
        return $this->visiMisi();
    }

    /**
     * Tampilkan halaman Visi, Misi & Tata Nilai puskesmas.
     */
    public function visiMisi(): View
    {
        $profil = ProfilPuskesmas::firstOrFail();

        return view('public.profile.visi-misi', compact('profil'));
    }

    /**
     * Tampilkan halaman Struktur Organisasi & Tata Kerja (SOTK).
     */
    public function strukturOrganisasi(): View
    {
        $profil = ProfilPuskesmas::firstOrFail();

        return view('public.profile.struktur', compact('profil'));
    }

    /**
     * Tampilkan halaman Wilayah Kerja & Demografi Puskesmas.
     */
    public function wilayahKerja(): View
    {
        $profil = ProfilPuskesmas::firstOrFail();

        return view('public.profile.wilayah', compact('profil'));
    }

    /**
     * Tampilkan halaman Fasilitas & Sarana Prasarana Puskesmas.
     */
    public function fasilitas(): View
    {
        $profil = ProfilPuskesmas::firstOrFail();

        return view('public.profile.fasilitas', compact('profil'));
    }
}
