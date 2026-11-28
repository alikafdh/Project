@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-wrap items-center justify-between gap-4 bg-white px-5 py-4 rounded-2xl border border-slate-200 shadow-xs">
        <p class="text-xs sm:text-sm text-slate-600">
            Menampilkan
            <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-bold text-slate-900">{{ $paginator->total() }}</span>
            publikasi
        </p>

        <div class="flex flex-wrap items-center gap-1.5">
            {{-- First («) --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-bold cursor-not-allowed">«</span>
            @else
                <a href="{{ $paginator->url(1) }}" rel="first" aria-label="Halaman Pertama"
                   class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] hover:border-emerald-300 text-xs font-bold transition-colors">«</a>
            @endif

            {{-- Prev (‹) --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-bold cursor-not-allowed">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya"
                   class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] hover:border-emerald-300 text-xs font-bold transition-colors">‹</a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1.5 text-xs font-semibold text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="px-3.5 py-1.5 rounded-lg bg-[#2E7D32] text-white text-xs font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] hover:border-emerald-300 text-xs font-semibold transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next (›) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya"
                   class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] hover:border-emerald-300 text-xs font-bold transition-colors">›</a>
            @else
                <span aria-disabled="true" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-bold cursor-not-allowed">›</span>
            @endif

            {{-- Last (») --}}
            @if ($paginator->currentPage() >= $paginator->lastPage())
                <span aria-disabled="true" class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-400 bg-slate-50 text-xs font-bold cursor-not-allowed">»</span>
            @else
                <a href="{{ $paginator->url($paginator->lastPage()) }}" rel="last" aria-label="Halaman Terakhir"
                   class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-emerald-50 hover:text-[#2E7D32] hover:border-emerald-300 text-xs font-bold transition-colors">»</a>
            @endif
        </div>
    </nav>
@endif
