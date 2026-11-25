<x-admin-layout title="Tambah Konten Baru">
    <div x-data="{
        tipe: '{{ old('tipe', 'berita') }}',
        judul: '{{ old('judul', '') }}',
        statusPublished: {{ old('status', 'published') === 'published' ? 'true' : 'false' }},
        thumbnailPreview: null,
        slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        },
        handleImageUpload(e) {
            const file = e.target.files[0];
            if (file) {
                this.thumbnailPreview = URL.createObjectURL(file);
            }
        },
        removeThumbnail() {
            this.thumbnailPreview = null;
            document.getElementById('foto_thumbnail').value = '';
        }
    }" class="pb-28 min-w-0">

        <!-- Trix Editor Assets -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <style>
            trix-toolbar .trix-button-row {
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            trix-toolbar .trix-button-group {
                border-radius: 0.5rem;
                overflow: hidden;
                border-color: #e2e8f0;
                background-color: #f8fafc;
            }
            trix-editor {
                min-height: 380px !important;
                max-width: 100%;
                overflow-wrap: anywhere;
                border-color: #cbd5e1 !important;
                border-radius: 0.75rem !important;
                font-size: 0.95rem;
                line-height: 1.6;
                padding: 1rem !important;
            }
            trix-editor:focus {
                border-color: #2E7D32 !important;
                box-shadow: 0 0 0 1px #2E7D32 !important;
            }
        </style>

        <!-- Top Breadcrumb & Title Section -->
        <div class="mb-6 space-y-1">
            <div class="flex flex-wrap items-center gap-1.5 text-xs text-slate-500 font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-800">Admin Portal</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <a href="{{ route('admin.posts.index') }}" class="hover:text-slate-800">Kelola Informasi</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#2E7D32] font-semibold">Tambah Konten Baru</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                <div class="min-w-0">
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Konten Baru</h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        Buat publikasi baru berupa Laporan Program Kerja, Berita Kesehatan, atau Agenda Kegiatan Puskesmas Cilimus.
                    </p>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="h-10 px-4 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 text-xs font-semibold flex items-center gap-1.5 self-start sm:self-auto transition-colors shadow-sm whitespace-nowrap flex-shrink-0">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Daftar</span>
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800">
                <div class="flex items-center gap-2 font-bold text-sm">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    <span>Terdapat beberapa kesalahan pengisian formulir:</span>
                </div>
                <ul class="mt-2 list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="postForm" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="status" :value="statusPublished ? 'published' : 'draft'">

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
                
                <!-- KOLOM KIRI: Judul, Slug, Editor Trix (Cols 1-8 / 65%) -->
                <div class="xl:col-span-8 space-y-6 min-w-0">
                    
                    <!-- Card: Judul & Auto-Slug -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="judul" class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                    <span>Judul Konten / Publikasi</span>
                                    <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Wajib Diisi</span>
                            </div>
                            <input type="text" 
                                name="judul" 
                                id="judul" 
                                x-model="judul" 
                                required 
                                placeholder="Contoh: Pelaksanaan Posyandu Balita dan Skrining Stunting Terpadu Desa Ciawigebang" 
                                class="w-full h-12 px-4 rounded-xl border-slate-200 text-slate-800 placeholder:text-slate-400 focus:border-[#2E7D32] focus:ring-[#2E7D32] text-base font-semibold shadow-inner transition-all">
                        </div>

                        <!-- Baris Auto-Slug Preview -->
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex flex-wrap items-center justify-between gap-2 text-xs">
                            <div class="flex items-center gap-1.5 min-w-0 flex-1">
                                <span class="material-symbols-outlined text-[16px] text-[#2E7D32] flex-shrink-0">link</span>
                                <span class="text-slate-400 font-medium flex-shrink-0">Permalink Preview:</span>
                                <span class="font-mono text-slate-700 truncate font-semibold min-w-0">
                                    puskesmascilimus.kuningankab.go.id/informasi/<span x-text="tipe" class="text-slate-500"></span>/<span x-text="slugify(judul) || 'judul-publikasi'" class="text-[#2E7D32]"></span>
                                </span>
                            </div>
                            <span class="text-[11px] text-slate-400 flex-shrink-0">Otomatis digenerate</span>
                        </div>
                    </div>

                    <!-- Card: Editor WYSIWYG Teks Kaya -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                    <span>Isi Konten &amp; Narasi Lengkap</span>
                                    <span class="text-rose-500">*</span>
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Gunakan editor teks kaya di bawah untuk menyusun narasi, kutipan, dan informasi rinci.
                                </p>
                            </div>
                        </div>

                        <input id="isi" type="hidden" name="isi" value="{{ old('isi') }}">
                        <trix-editor input="isi" placeholder="Tuliskan berita edukasi, pengumuman, atau rincian laporan di sini..." class="trix-content"></trix-editor>
                        
                        <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                            <span>Mendukung format paragraf, tebal, miring, tautan, dan daftar berpoin.</span>
                            <span class="text-emerald-700 font-medium flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                Editor Trix Aktif
                            </span>
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN: Pengaturan Tipe, Klaster, Dynamic Sections, Thumbnail, Status (Cols 9-12 / 35%) -->
                <div class="xl:col-span-4 space-y-6 min-w-0">

                    <!-- CARD 1: Pilihan Tipe Konten & Klaster ILP -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">tune</span>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-800">Tipe &amp; Kategori</h2>
                                <p class="text-[11px] text-slate-400">Pilih format jenis konten publikasi</p>
                            </div>
                        </div>

                        <!-- Radio Buttons Tipe Konten -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 block">Tipe Publikasi <span class="text-rose-500">*</span></label>
                            
                            <!-- Radio Laporan -->
                            <label :class="tipe === 'laporan' ? 'border-[#2E7D32] bg-emerald-50/60 shadow-sm' : 'border-slate-200 hover:bg-slate-50'" 
                                   class="relative p-3 rounded-xl border flex items-center justify-between cursor-pointer transition-all">
                                <div class="flex items-center gap-2.5">
                                    <div :class="tipe === 'laporan' ? 'bg-[#2E7D32] text-white' : 'bg-slate-100 text-slate-600'" 
                                         class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">assignment_turned_in</span>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Laporan Program</div>
                                        <div class="text-[11px] text-slate-400">Akuntabilitas fisik &amp; berkas PDF</div>
                                    </div>
                                </div>
                                <input type="radio" name="tipe" value="laporan" x-model="tipe" class="w-4 h-4 text-[#2E7D32] focus:ring-[#2E7D32]">
                            </label>

                            <!-- Radio Berita -->
                            <label :class="tipe === 'berita' ? 'border-[#2E7D32] bg-emerald-50/60 shadow-sm' : 'border-slate-200 hover:bg-slate-50'" 
                                   class="relative p-3 rounded-xl border flex items-center justify-between cursor-pointer transition-all">
                                <div class="flex items-center gap-2.5">
                                    <div :class="tipe === 'berita' ? 'bg-[#2E7D32] text-white' : 'bg-slate-100 text-slate-600'" 
                                         class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">newspaper</span>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Berita Kesehatan</div>
                                        <div class="text-[11px] text-slate-400">Edukasi, promkes &amp; siaran pers</div>
                                    </div>
                                </div>
                                <input type="radio" name="tipe" value="berita" x-model="tipe" class="w-4 h-4 text-[#2E7D32] focus:ring-[#2E7D32]">
                            </label>

                            <!-- Radio Agenda -->
                            <label :class="tipe === 'agenda' ? 'border-[#2E7D32] bg-emerald-50/60 shadow-sm' : 'border-slate-200 hover:bg-slate-50'" 
                                   class="relative p-3 rounded-xl border flex items-center justify-between cursor-pointer transition-all">
                                <div class="flex items-center gap-2.5">
                                    <div :class="tipe === 'agenda' ? 'bg-[#2E7D32] text-white' : 'bg-slate-100 text-slate-600'" 
                                         class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">event</span>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-800">Agenda Kegiatan</div>
                                        <div class="text-[11px] text-slate-400">Jadwal posyandu &amp; sosialisasi</div>
                                    </div>
                                </div>
                                <input type="radio" name="tipe" value="agenda" x-model="tipe" class="w-4 h-4 text-[#2E7D32] focus:ring-[#2E7D32]">
                            </label>
                        </div>

                        <!-- Dropdown Klaster ILP -->
                        <div class="pt-2 border-t border-slate-100 space-y-1.5">
                            <label for="klaster_id" class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-[#2E7D32]">layers</span>
                                <span>Klaster Layanan Primer (ILP)</span>
                            </label>
                            <select name="klaster_id" id="klaster_id" class="w-full h-11 px-3 rounded-xl border-slate-200 text-xs font-medium text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                                <option value="">-- Lintas Klaster / Pengumuman Umum --</option>
                                @foreach($klasters as $klaster)
                                    <option value="{{ $klaster->id }}" {{ old('klaster_id') == $klaster->id ? 'selected' : '' }}>
                                        {{ $klaster->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-slate-400">Konten akan dikelompokkan sesuai klaster ILP terkait.</p>
                        </div>
                    </div>

                    <!-- CARD 2: SECTION DINAMIS LAPORAN (Muncul jika radio Laporan aktif) -->
                    <div x-show="tipe === 'laporan'" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white p-6 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-emerald-100">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-[#2E7D32] text-white flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span>
                                </div>
                                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Data Khusus Laporan</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">PDF SPJ</span>
                        </div>

                        <!-- Upload File PDF -->
                        <div>
                            <label class="text-xs font-bold text-slate-700 flex items-center justify-between mb-1">
                                <span>Dokumen PDF Laporan</span>
                                <span class="text-[11px] text-slate-400 font-normal">Maks. 10 MB</span>
                            </label>
                            <input type="file" 
                                name="file_pdf" 
                                id="file_pdf" 
                                accept=".pdf" 
                                class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-[#2E7D32] hover:file:bg-emerald-200 cursor-pointer">
                        </div>

                        <!-- Dropdown Bulan & Tahun Pelaksanaan -->
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <div>
                                <label for="periode_bulan" class="text-xs font-semibold text-slate-700 block mb-1">Bulan Pelaksanaan</label>
                                <select name="periode_bulan" id="periode_bulan" class="w-full h-10 px-2.5 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                                        <option value="{{ $bulan }}" {{ old('periode_bulan') === $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="periode_tahun" class="text-xs font-semibold text-slate-700 block mb-1">Tahun</label>
                                <input type="number" 
                                    name="periode_tahun" 
                                    id="periode_tahun" 
                                    value="{{ old('periode_tahun', date('Y')) }}" 
                                    min="2020" 
                                    max="2099" 
                                    class="w-full h-10 px-2.5 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            </div>
                        </div>
                    </div>

                    <!-- CARD 2: SECTION DINAMIS AGENDA (Muncul jika radio Agenda aktif) -->
                    <div x-show="tipe === 'agenda'" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white p-6 rounded-2xl border border-amber-200 bg-amber-50/20 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-2 border-b border-amber-100">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                                </div>
                                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Data Khusus Agenda</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Jadwal</span>
                        </div>

                        <!-- Waktu Kegiatan -->
                        <div>
                            <label for="waktu_kegiatan" class="text-xs font-bold text-slate-700 block mb-1">
                                Waktu &amp; Tanggal Pelaksanaan
                            </label>
                            <input type="datetime-local" 
                                name="waktu_kegiatan" 
                                id="waktu_kegiatan" 
                                value="{{ old('waktu_kegiatan') }}" 
                                class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>

                        <!-- Lokasi Kegiatan -->
                        <div>
                            <label for="lokasi_kegiatan" class="text-xs font-bold text-slate-700 block mb-1">
                                Lokasi / Tempat Kegiatan
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="lokasi_kegiatan" 
                                    id="lokasi_kegiatan" 
                                    value="{{ old('lokasi_kegiatan') }}" 
                                    placeholder="Contoh: Balai Desa Ciawigebang" 
                                    class="w-full h-10 pl-3 pr-8 rounded-xl border-slate-200 text-xs text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 absolute right-2.5 top-2.5">pin_drop</span>
                            </div>
                        </div>

                        <!-- Sasaran Peserta -->
                        <div>
                            <label for="sasaran_peserta" class="text-xs font-bold text-slate-700 block mb-1">
                                Sasaran Peserta
                            </label>
                            <div class="relative">
                                <input type="text" 
                                    name="sasaran_peserta" 
                                    id="sasaran_peserta" 
                                    value="{{ old('sasaran_peserta') }}" 
                                    placeholder="Contoh: Balita 0-59 bulan &amp; Ibu Hamil" 
                                    class="w-full h-10 pl-3 pr-8 rounded-xl border-slate-200 text-xs text-slate-700 focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                                <span class="material-symbols-outlined text-[16px] text-slate-400 absolute right-2.5 top-2.5">groups</span>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: Drag & Drop Upload Thumbnail Foto 16:9 -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[18px]">image</span>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800">Foto Sampul / Thumbnail</h3>
                                    <p class="text-[11px] text-slate-400">Rasio 16:9 disarankan</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Maks. 2MB</span>
                        </div>

                        <!-- Pratinjau Gambar 16:9 jika ada -->
                        <template x-if="thumbnailPreview">
                            <div class="relative rounded-xl overflow-hidden aspect-video bg-slate-100 border border-slate-200 group">
                                <img :src="thumbnailPreview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button type="button" @click="removeThumbnail()" class="px-3 py-1.5 rounded-lg bg-white text-rose-600 text-xs font-semibold shadow flex items-center gap-1 hover:bg-rose-50">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                        Hapus Foto
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Area Drag and Drop / Input File -->
                        <div x-show="!thumbnailPreview" 
                             class="p-6 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/60 hover:bg-slate-50 hover:border-[#2E7D32] transition-colors flex flex-col items-center justify-center text-center cursor-pointer"
                             @click="$refs.thumbnailInput.click()">
                            <span class="material-symbols-outlined text-[32px] text-[#2E7D32] mb-1">cloud_upload</span>
                            <p class="text-xs font-bold text-slate-700">Tarik &amp; lepas foto di sini</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">atau <span class="text-[#2E7D32] font-semibold underline">Telusuri Berkas Komputer</span></p>
                            <span class="text-[10px] text-slate-400 mt-2">Mendukung JPG, PNG, atau WebP (Maks. 2MB)</span>
                        </div>

                        <input type="file" 
                            name="foto_thumbnail" 
                            id="foto_thumbnail" 
                            x-ref="thumbnailInput"
                            @change="handleImageUpload($event)"
                            accept="image/jpeg,image/png,image/webp" 
                            class="hidden">
                    </div>

                    <!-- CARD 4: Status & Visibilitas Publikasi -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                                <span class="material-symbols-outlined text-[18px]">public</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Status Publikasi</h3>
                                <p class="text-[11px] text-slate-400">Kontrol visibilitas tayang di portal warga</p>
                            </div>
                        </div>

                        <!-- Toggle Switch Status Publikasi -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-800">Status:</span>
                                    <template x-if="statusPublished">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D32] animate-pulse"></span>
                                            Published
                                        </span>
                                    </template>
                                    <template x-if="!statusPublished">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-200 text-slate-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Draft
                                        </span>
                                    </template>
                                </div>
                                <p class="text-[11px] mt-1 text-slate-500" x-text="statusPublished ? 'Konten langsung terbit dan dapat diakses publik.' : 'Hanya disimpan sebagai draf internal pengelola.'"></p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="statusPublished" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#2E7D32]"></div>
                            </label>
                        </div>
                    </div>

                </div>

            </div>
        </form>

        <!-- FLOATING ACTION BAR DI BAGIAN BAWAH -->
        <div data-admin-floating-bar
             :class="{ 'md:left-60': desktopSidebarOpen, 'md:left-0': !desktopSidebarOpen }"
             class="fixed bottom-0 left-0 md:left-60 right-0 bg-white/95 backdrop-blur-md shadow-[0_-4px_20px_rgba(0,0,0,0.06)] z-30 px-4 sm:px-6 md:px-8 py-3.5 border-t border-slate-200 transition-[left] duration-300 ease-in-out">
            <div class="max-w-[1400px] mx-auto flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.posts.index') }}" class="h-11 px-3 sm:px-5 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-100 font-semibold text-xs flex items-center gap-1.5 transition-colors whitespace-nowrap">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        <span>Batal</span>
                    </a>
                    <span class="hidden lg:inline-block text-xs text-slate-400">
                        Pastikan semua informasi wajib (*) telah terisi sebelum menyimpan.
                    </span>
                </div>

                <div class="flex items-center gap-2 sm:gap-2.5">
                    <button type="button" 
                        @click="statusPublished = false; $nextTick(() => document.getElementById('postForm').submit())" 
                        class="h-11 px-3 sm:px-4 rounded-xl border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 font-bold text-xs flex items-center gap-1.5 transition-colors shadow-sm whitespace-nowrap">
                        <span class="material-symbols-outlined text-[16px]">save</span>
                        <span>Simpan Draf</span>
                    </button>

                    <button type="button" 
                        @click="document.getElementById('postForm').submit()" 
                        class="h-11 px-4 sm:px-6 rounded-xl text-white font-bold text-xs flex items-center gap-2 shadow-md hover:opacity-95 transition-all whitespace-nowrap"
                        style="background-color: #2E7D32;">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        <span>Simpan Post</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
