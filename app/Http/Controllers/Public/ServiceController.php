<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Tampilkan katalog layanan kesehatan beserta filter klaster ILP.
     */
    public function index(Request $request): View
    {
        $klasters = KlasterILP::withCount([
            'layanan' => fn ($query) => $query->where('status', 'aktif'),
        ])->get();

        $layanan = Layanan::with('klaster')->where('status', 'aktif');

        if ($request->filled('klaster')) {
            $layanan->whereHas('klaster', fn ($q) => $q->where('slug', $request->klaster));
        }

        $layananList = $layanan->get();

        return view('public.services.index', compact('klasters', 'layananList'));
    }

    /**
     * Tampilkan detail informasi poliklinik / layanan kesehatan.
     */
    public function show(string $slug): View
    {
        $layanan = Layanan::with('klaster')
            ->where('slug', $slug)
            ->firstOrFail();

        $layananLainnya = Layanan::with('klaster')
            ->where('status', 'aktif')
            ->where('id', '!=', $layanan->id)
            ->take(3)
            ->get();

        return view('public.services.show', compact('layanan', 'layananLainnya'));
    }

    /**
     * Tampilkan halaman Standar Operasional Prosedur (SOP) Alur Pelayanan Pasien.
     */
    public function alurPelayanan(): View
    {
        return view('public.services.alur');
    }
}
