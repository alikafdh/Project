<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\KlasterILP;
use App\Models\ProfilPuskesmas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * Tampilkan halaman kontak resmi dan formulir kritik & saran masyarakat.
     */
    public function index(): View
    {
        $profil = ProfilPuskesmas::firstOrFail();
        $klasters = KlasterILP::all();

        return view('public.contact', compact('profil', 'klasters'));
    }

    /**
     * Simpan masukan, kritik, atau saran warga ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pengirim' => 'required|string|max:100',
            'kontak'        => 'required|string|max:100',
            'klaster_id'    => 'nullable|exists:klaster_ilp,id',
            'subjek'        => 'required|string|max:200',
            'isi_pesan'     => 'required|string|max:2000',
        ]);

        Feedback::create(array_merge($validated, ['status' => 'baru']));

        return back()->with('success', 'Terima kasih! Masukan Anda telah kami terima. Tim kami akan segera menindaklanjutinya.');
    }
}
