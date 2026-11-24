<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KlasterController extends Controller
{
    public function index(): View
    {
        $klasters = KlasterILP::withCount(['layanan', 'posts', 'reminders', 'feedbacks'])->get();

        return view('admin.klaster.index', compact('klasters'));
    }

    public function create(): View
    {
        return view('admin.klaster.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        KlasterILP::create($validated);

        return redirect()->route('admin.klaster.index')->with('success', 'Klaster ILP berhasil ditambahkan.');
    }

    public function edit(KlasterILP $klaster): View
    {
        return view('admin.klaster.edit', compact('klaster'));
    }

    public function update(Request $request, KlasterILP $klaster): RedirectResponse
    {
        $validated = $request->validate([
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $klaster->update($validated);

        return redirect()->route('admin.klaster.index')->with('success', 'Data Klaster ILP berhasil diperbarui.');
    }

    public function destroy(KlasterILP $klaster): RedirectResponse
    {
        if ($klaster->layanan()->count() > 0) {
            return back()->with('error', 'Klaster tidak dapat dihapus karena masih memiliki relasi layanan/poliklinik aktif.');
        }

        $klaster->delete();

        return redirect()->route('admin.klaster.index')->with('success', 'Klaster ILP berhasil dihapus.');
    }
}
