@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Pengelolaan Informasi & Artikel</h1>
            <p class="text-sm text-slate-500">Kelola laporan kinerja akuntabilitas, berita kesehatan, dan agenda posyandu</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm shadow-sm shadow-emerald-700/30 transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Postingan Baru
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <select name="tipe" class="rounded-xl border-slate-300 text-xs font-medium focus:border-emerald-500 focus:ring-emerald-500">
                <option value="">Semua Tipe</option>
                <option value="berita" {{ request('tipe') === 'berita' ? 'selected' : '' }}>Berita Edukasi</option>
                <option value="laporan" {{ request('tipe') === 'laporan' ? 'selected' : '' }}>Laporan Akuntabilitas</option>
                <option value="agenda" {{ request('tipe') === 'agenda' ? 'selected' : '' }}>Agenda Kegiatan</option>
            </select>

            <select name="status" class="rounded-xl border-slate-300 text-xs font-medium focus:border-emerald-500 focus:ring-emerald-500">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..." class="rounded-xl border-slate-300 text-xs focus:border-emerald-500 focus:ring-emerald-500 w-48">

            <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['tipe', 'status', 'search']))
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Judul & Klaster</th>
                        <th class="px-6 py-4 font-semibold">Tipe</th>
                        <th class="px-6 py-4 font-semibold">Penulis</th>
                        <th class="px-6 py-4 font-semibold text-center">Tayangan</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 max-w-md">
                                <div class="font-bold text-slate-800 line-clamp-1">{{ $post->judul }}</div>
                                <div class="flex items-center space-x-2 mt-1 text-xs text-slate-400">
                                    <span>Klaster: {{ $post->klaster->nama ?? 'Pengumuman Umum' }}</span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($post->tipe === 'laporan')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                        📄 Laporan
                                    </span>
                                @elseif($post->tipe === 'agenda')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                        📅 Agenda
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        📰 Berita
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600">
                                {{ $post->author->nama_lengkap ?? 'Humas Puskesmas' }}
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-xs text-slate-600">
                                {{ number_format($post->views) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $post->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus artikel/postingan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg border border-rose-200 text-xs font-medium text-rose-600 hover:bg-rose-50">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada artikel atau postingan yang sesuai kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
