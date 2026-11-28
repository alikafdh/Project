<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostController extends Controller
{
    /**
     * Tampilkan feed portal informasi, laporan kerja, berita, dan agenda.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['klaster', 'author'])->where('status', 'published');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(fn ($w) => $w->where('judul', 'like', "%{$q}%")->orWhere('isi', 'like', "%{$q}%"));
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('klaster')) {
            $query->whereHas('klaster', fn ($k) => $k->where('slug', $request->klaster));
        }

        if ($request->filled('bulan')) {
            $query->where('periode_bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('periode_tahun', $request->tahun);
        }

        $posts = $query->latest()->paginate(9)->withQueryString();
        $klasters = KlasterILP::all();

        return view('public.posts.index', compact('posts', 'klasters'));
    }

    /**
     * Tampilkan halaman detail artikel, laporan program kerja, atau agenda.
     */
    public function show(string $slug): View
    {
        $post = Post::with(['klaster', 'author'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views');

        $artikelTerbaru = Post::where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        $klasters = KlasterILP::withCount([
            'posts' => fn ($query) => $query->where('status', 'published'),
        ])->get();

        return view('public.posts.show', compact('post', 'artikelTerbaru', 'klasters'));
    }

    /**
     * Unduh lampiran dokumen PDF resmi dari laporan program kerja.
     */
    public function downloadPdf(string $slug): StreamedResponse
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('file_pdf')
            ->firstOrFail();

        if (Storage::disk('public')->exists($post->file_pdf)) {
            return Storage::disk('public')->download($post->file_pdf);
        }

        if (Storage::exists($post->file_pdf)) {
            return Storage::download($post->file_pdf);
        }

        abort(404, 'Berkas PDF laporan belum tersedia di server.');
    }
}
