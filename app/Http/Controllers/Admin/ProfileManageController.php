<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPuskesmas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileManageController extends Controller
{
    public function edit(): View
    {
        $profil = ProfilPuskesmas::first() ?? new ProfilPuskesmas();

        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'visi'              => ['required', 'string'],
            'misi_text'         => ['required', 'string'], // Raw text separated by newlines
            'wilayah_kerja'     => ['nullable', 'string'],
            'no_telepon'        => ['required', 'string', 'max:30'],
            'alamat'            => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:100'],
            'koordinat_peta'    => ['nullable', 'string', 'max:150'],
            'wa_number'         => ['required', 'string', 'max:30'],
            'logo'              => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'foto_fasilitas'    => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:3072'],
            'strukt_organisasi' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
        ]);

        // Convert misi text into array of strings
        $lines = preg_split('/\r\n|\r|\n/', $validated['misi_text']);
        $misiArray = array_values(array_filter(array_map('trim', $lines), fn ($line) => ! empty($line)));
        $validated['misi'] = $misiArray;

        $profil = ProfilPuskesmas::first();

        if (! $profil) {
            $profil = new ProfilPuskesmas();
        }

        if ($request->hasFile('logo')) {
            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }
            $validated['logo'] = $request->file('logo')->store('uploads/profil', 'public');
        }

        if ($request->hasFile('foto_fasilitas')) {
            if ($profil->foto_fasilitas && Storage::disk('public')->exists($profil->foto_fasilitas)) {
                Storage::disk('public')->delete($profil->foto_fasilitas);
            }
            $validated['foto_fasilitas'] = $request->file('foto_fasilitas')->store('uploads/profil', 'public');
        }

        if ($request->hasFile('strukt_organisasi')) {
            if ($profil->strukt_organisasi && Storage::disk('public')->exists($profil->strukt_organisasi)) {
                Storage::disk('public')->delete($profil->strukt_organisasi);
            }
            $validated['strukt_organisasi'] = $request->file('strukt_organisasi')->store('uploads/profil', 'public');
        }

        $profil->fill($validated);
        $profil->save();

        return redirect()->route('admin.profil.edit')->with('success', 'Profil instansi Puskesmas Cilimus berhasil diperbarui.');
    }
}
