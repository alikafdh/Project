<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostManageController extends Controller
{
    /**
     * Tampilkan daftar informasi / publikasi dengan filter dan pencarian.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['klaster', 'author'])->latest();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('klaster_id')) {
            $query->where('klaster_id', $request->klaster_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $posts = $query->paginate(10)->withQueryString();

        // Data statistik ringkas untuk kartu metrik atas
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $totalViews = Post::sum('views');

        $klasters = KlasterILP::all();

        return view('admin.posts.index', compact(
            'posts',
            'klasters',
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'totalViews'
        ));
    }

    /**
     * Tampilkan formulir pembuatan konten baru.
     */
    public function create(): View
    {
        $klasters = KlasterILP::all();

        return view('admin.posts.create', compact('klasters'));
    }

    /**
     * Simpan konten baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'judul'           => ['required', 'string', 'max:255'],
            'tipe'            => ['required', 'in:laporan,berita,agenda'],
            'status'          => ['required', 'in:draft,published'],
            'isi'             => ['required', 'string'],
            'klaster_id'      => ['nullable', 'exists:klaster_ilp,id'],
            'foto_thumbnail'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        if ($request->tipe === 'laporan') {
            $rules['file_pdf']      = ['nullable', 'mimes:pdf', 'max:10240'];
            $rules['periode_bulan'] = ['nullable', 'string', 'max:20'];
            $rules['periode_tahun'] = ['nullable', 'integer', 'min:2020', 'max:2099'];
        } elseif ($request->tipe === 'agenda') {
            $rules['waktu_kegiatan']  = ['nullable', 'date'];
            $rules['lokasi_kegiatan'] = ['nullable', 'string', 'max:255'];
            $rules['sasaran_peserta'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        // Auto-slug dari judul dengan penanganan benturan unik
        $baseSlug = Str::slug($request->judul);
        $slug = $baseSlug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        // Sanitasi dasar HTML untuk konten teks kaya
        $allowedTags = '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><blockquote><img><table><thead><tbody><tr><th><td>';
        $validated['isi'] = strip_tags($validated['isi'], $allowedTags);

        // Handle upload foto_thumbnail (disimpan di storage/app/public/thumbnails)
        if ($request->hasFile('foto_thumbnail')) {
            $validated['foto_thumbnail'] = $request->file('foto_thumbnail')->store('thumbnails', 'public');
        }

        // Handle khusus tipe laporan (PDF disimpan di storage/app/public/laporan)
        if ($request->tipe === 'laporan') {
            if ($request->hasFile('file_pdf')) {
                $validated['file_pdf'] = $request->file('file_pdf')->store('laporan', 'public');
            }
            // Bersihkan field agenda
            $validated['waktu_kegiatan'] = null;
            $validated['lokasi_kegiatan'] = null;
            $validated['sasaran_peserta'] = null;
        } elseif ($request->tipe === 'agenda') {
            // Bersihkan field laporan
            $validated['file_pdf'] = null;
            $validated['periode_bulan'] = null;
            $validated['periode_tahun'] = null;
        } else {
            // Berita: bersihkan field laporan dan agenda
            $validated['file_pdf'] = null;
            $validated['periode_bulan'] = null;
            $validated['periode_tahun'] = null;
            $validated['waktu_kegiatan'] = null;
            $validated['lokasi_kegiatan'] = null;
            $validated['sasaran_peserta'] = null;
        }

        // Simpan admin_id = auth()->id()
        $validated['admin_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Konten publikasi baru berhasil disimpan.');
    }

    /**
     * Pratinjau atau alihkan ke halaman ubah.
     */
    public function show(Post $post): RedirectResponse
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Tampilkan formulir edit konten.
     */
    public function edit(Post $post): View
    {
        $klasters = KlasterILP::all();

        return view('admin.posts.edit', compact('post', 'klasters'));
    }

    /**
     * Perbarui data konten yang ada.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $rules = [
            'judul'           => ['required', 'string', 'max:255'],
            'tipe'            => ['required', 'in:laporan,berita,agenda'],
            'status'          => ['required', 'in:draft,published'],
            'isi'             => ['required', 'string'],
            'klaster_id'      => ['nullable', 'exists:klaster_ilp,id'],
            'foto_thumbnail'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];

        if ($request->tipe === 'laporan') {
            $rules['file_pdf']      = ['nullable', 'mimes:pdf', 'max:10240'];
            $rules['periode_bulan'] = ['nullable', 'string', 'max:20'];
            $rules['periode_tahun'] = ['nullable', 'integer', 'min:2020', 'max:2099'];
        } elseif ($request->tipe === 'agenda') {
            $rules['waktu_kegiatan']  = ['nullable', 'date'];
            $rules['lokasi_kegiatan'] = ['nullable', 'string', 'max:255'];
            $rules['sasaran_peserta'] = ['nullable', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);

        // Jika judul berubah, perbarui slug secara aman
        if ($post->judul !== $request->judul) {
            $baseSlug = Str::slug($request->judul);
            $slug = $baseSlug;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $allowedTags = '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><blockquote><img><table><thead><tbody><tr><th><td>';
        $validated['isi'] = strip_tags($validated['isi'], $allowedTags);

        // Upload foto thumbnail baru jika ada
        if ($request->hasFile('foto_thumbnail')) {
            if ($post->foto_thumbnail && Storage::disk('public')->exists($post->foto_thumbnail)) {
                Storage::disk('public')->delete($post->foto_thumbnail);
            }
            $validated['foto_thumbnail'] = $request->file('foto_thumbnail')->store('thumbnails', 'public');
        }

        // Upload dokumen PDF baru jika ada
        if ($request->tipe === 'laporan') {
            if ($request->hasFile('file_pdf')) {
                if ($post->file_pdf && Storage::disk('public')->exists($post->file_pdf)) {
                    Storage::disk('public')->delete($post->file_pdf);
                }
                $validated['file_pdf'] = $request->file('file_pdf')->store('laporan', 'public');
            }
            $validated['waktu_kegiatan'] = null;
            $validated['lokasi_kegiatan'] = null;
            $validated['sasaran_peserta'] = null;
        } elseif ($request->tipe === 'agenda') {
            $validated['file_pdf'] = null;
            $validated['periode_bulan'] = null;
            $validated['periode_tahun'] = null;
        } else {
            $validated['file_pdf'] = null;
            $validated['periode_bulan'] = null;
            $validated['periode_tahun'] = null;
            $validated['waktu_kegiatan'] = null;
            $validated['lokasi_kegiatan'] = null;
            $validated['sasaran_peserta'] = null;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Konten publikasi berhasil diperbarui.');
    }

    /**
     * Hapus konten beserta berkas yang terkait.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if ($post->foto_thumbnail && Storage::disk('public')->exists($post->foto_thumbnail)) {
            Storage::disk('public')->delete($post->foto_thumbnail);
        }

        if ($post->file_pdf && Storage::disk('public')->exists($post->file_pdf)) {
            Storage::disk('public')->delete($post->file_pdf);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Konten berhasil dihapus.');
    }
}
