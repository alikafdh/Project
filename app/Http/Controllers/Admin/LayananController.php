<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LayananController extends Controller
{
    public function index(): View
    {
        $layananList = Layanan::with('klaster')->latest()->paginate(10);

        return view('admin.layanan.index', compact('layananList'));
    }

    public function create(): View
    {
        $klasters = KlasterILP::all();

        return view('admin.layanan.create', compact('klasters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_poli'      => ['required', 'string', 'max:100'],
            'klaster_id'     => ['required', 'exists:klaster_ilp,id'],
            'jadwal_praktik' => ['required', 'string', 'max:255'],
            'tenaga_medis'   => ['nullable', 'string', 'max:150'],
            'deskripsi'      => ['nullable', 'string'],
            'status'         => ['required', 'in:aktif,nonaktif'],
            'gambar_alur'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['nama_poli']) . '-' . Str::random(4);

        if ($request->hasFile('gambar_alur')) {
            $validated['gambar_alur'] = $request->file('gambar_alur')->store('uploads/layanan', 'public');
        }

        Layanan::create($validated);

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan poliklinik baru berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan): View
    {
        $klasters = KlasterILP::all();

        return view('admin.layanan.edit', compact('layanan', 'klasters'));
    }

    public function update(Request $request, Layanan $layanan): RedirectResponse
    {
        $validated = $request->validate([
            'nama_poli'      => ['required', 'string', 'max:100'],
            'klaster_id'     => ['required', 'exists:klaster_ilp,id'],
            'jadwal_praktik' => ['required', 'string', 'max:255'],
            'tenaga_medis'   => ['nullable', 'string', 'max:150'],
            'deskripsi'      => ['nullable', 'string'],
            'status'         => ['required', 'in:aktif,nonaktif'],
            'gambar_alur'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('gambar_alur')) {
            if ($layanan->gambar_alur && Storage::disk('public')->exists($layanan->gambar_alur)) {
                Storage::disk('public')->delete($layanan->gambar_alur);
            }
            $validated['gambar_alur'] = $request->file('gambar_alur')->store('uploads/layanan', 'public');
        }

        $layanan->update($validated);

        return redirect()->route('admin.layanan.index')->with('success', 'Data layanan poliklinik berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan): RedirectResponse
    {
        if ($layanan->gambar_alur && Storage::disk('public')->exists($layanan->gambar_alur)) {
            Storage::disk('public')->delete($layanan->gambar_alur);
        }

        $layanan->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Layanan poliklinik berhasil dihapus.');
    }
}
