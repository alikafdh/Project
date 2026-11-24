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
    public function index(Request $request): View
    {
        $query = Post::with(['klaster', 'author'])->latest();

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $klasters = KlasterILP::all();

        return view('admin.posts.create', compact('klasters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'tipe'            => ['required', 'in:laporan,berita,agenda'],
            'status'          => ['required', 'in:draft,published'],
            'isi'             => ['required', 'string'],
            'klaster_id'      => ['nullable', 'exists:klaster_ilp,id'],
            'foto_thumbnail'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'file_pdf'        => ['nullable', 'mimes:pdf', 'max:10240'],
            'periode_bulan'   => ['nullable', 'string', 'max:20'],
            'periode_tahun'   => ['nullable', 'integer', 'min:2020', 'max:2099'],
            'waktu_kegiatan'  => ['nullable', 'date'],
            'lokasi_kegiatan' => ['nullable', 'string', 'max:255'],
            'sasaran_peserta' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['admin_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['judul']) . '-' . Str::random(5);

        // Basic HTML sanitization for WYSIWYG content to prevent stored XSS
        $allowedTags = '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><blockquote><img><table><thead><tbody><tr><th><td>';
        $validated['isi'] = strip_tags($validated['isi'], $allowedTags);

        if ($request->hasFile('foto_thumbnail')) {
            $validated['foto_thumbnail'] = $request->file('foto_thumbnail')->store('uploads/thumbnails', 'public');
        }

        if ($request->hasFile('file_pdf')) {
            $validated['file_pdf'] = $request->file('file_pdf')->store('uploads/laporan', 'public');
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan baru berhasil diterbitkan.');
    }

    public function edit(Post $post): View
    {
        $klasters = KlasterILP::all();

        return view('admin.posts.edit', compact('post', 'klasters'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'tipe'            => ['required', 'in:laporan,berita,agenda'],
            'status'          => ['required', 'in:draft,published'],
            'isi'             => ['required', 'string'],
            'klaster_id'      => ['nullable', 'exists:klaster_ilp,id'],
            'foto_thumbnail'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'file_pdf'        => ['nullable', 'mimes:pdf', 'max:10240'],
            'periode_bulan'   => ['nullable', 'string', 'max:20'],
            'periode_tahun'   => ['nullable', 'integer', 'min:2020', 'max:2099'],
            'waktu_kegiatan'  => ['nullable', 'date'],
            'lokasi_kegiatan' => ['nullable', 'string', 'max:255'],
            'sasaran_peserta' => ['nullable', 'string', 'max:255'],
        ]);

        $allowedTags = '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><blockquote><img><table><thead><tbody><tr><th><td>';
        $validated['isi'] = strip_tags($validated['isi'], $allowedTags);

        if ($request->hasFile('foto_thumbnail')) {
            if ($post->foto_thumbnail && Storage::disk('public')->exists($post->foto_thumbnail)) {
                Storage::disk('public')->delete($post->foto_thumbnail);
            }
            $validated['foto_thumbnail'] = $request->file('foto_thumbnail')->store('uploads/thumbnails', 'public');
        }

        if ($request->hasFile('file_pdf')) {
            if ($post->file_pdf && Storage::disk('public')->exists($post->file_pdf)) {
                Storage::disk('public')->delete($post->file_pdf);
            }
            $validated['file_pdf'] = $request->file('file_pdf')->store('uploads/laporan', 'public');
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->foto_thumbnail && Storage::disk('public')->exists($post->foto_thumbnail)) {
            Storage::disk('public')->delete($post->foto_thumbnail);
        }

        if ($post->file_pdf && Storage::disk('public')->exists($post->file_pdf)) {
            Storage::disk('public')->delete($post->file_pdf);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus.');
    }
}
