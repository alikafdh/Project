@php
    $homeUrl = \Illuminate\Support\Facades\Route::has('public.home') ? route('public.home') : url('/');
    $servicesIndexUrl = \Illuminate\Support\Facades\Route::has('public.services.index') ? route('public.services.index') : url('/layanan');
@endphp

<x-app-layout>
    <x-slot name="title">Alur Pelayanan Pasien</x-slot>

    {{-- Banner Header --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#003822] via-[#054d2f] to-[#2E7D32] text-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-emerald-200/90 font-medium">
                <a href="{{ $homeUrl }}" class="hover:text-white transition-colors inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">home</span>
                    <span>Beranda</span>
                </a>
                <span>/</span>
                <a href="{{ $servicesIndexUrl }}" class="hover:text-white transition-colors">Layanan</a>
                <span>/</span>
                <span class="text-white font-semibold">Alur Pelayanan Pasien</span>
            </nav>

            <div class="flex flex-wrap items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-white/10 border border-white/15 text-emerald-200 text-xs font-semibold uppercase tracking-wider">
                    Standar Pelayanan Publik
                </span>
                <span class="px-3 py-1 rounded-full bg-emerald-400/20 border border-emerald-300/30 text-emerald-100 text-xs font-semibold">
                    Ramah, Cepat &amp; Transparan
                </span>
            </div>

            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                Alur Pelayanan Pasien Puskesmas Cilimus
            </h2>
            <p class="text-sm sm:text-base text-emerald-50/90 max-w-2xl leading-relaxed">
                Panduan alur tata cara pelayanan medis rawat jalan dan rujukan terstandarisasi untuk kenyamanan serta kepastian waktu tunggu masyarakat Kecamatan Cilimus.
            </p>
        </div>
    </section>

    {{-- Konten Utama --}}
    <section class="py-12 lg:py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        {{-- Diagram Alur Gambar Tunggal Utuh --}}
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Tahapan Layanan Terintegrasi</span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Diagram Alur Pelayanan Pasien</h3>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-[#2E7D32] text-xs font-semibold self-start">
                    <span class="material-symbols-outlined text-[16px]">timer</span>
                    <span>Target Waktu Tunggu Loket: ≤ 15 Menit</span>
                </span>
            </div>

            <figure class="w-full bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
                <img src="{{ asset('assets/img/diagram-alur-pelayanan-cilimus.png') }}"
                     alt="Standar Operasional Prosedur (SOP) Alur Pelayanan Pasien UPTD Puskesmas Cilimus"
                     class="w-full h-auto rounded-xl" />
                <figcaption class="text-center text-sm text-slate-500 mt-3 font-medium">Gambar: Standar Operasional Prosedur (SOP) Alur Pelayanan Pasien UPTD Puskesmas Cilimus</figcaption>
            </figure>
        </div>

        {{-- Strip Jam Buka Loket Pendaftaran --}}
        <div class="bg-[#003822] text-white rounded-2xl p-6 sm:p-8 shadow-md">
            <div class="flex items-center gap-2 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-4">
                <span class="material-symbols-outlined text-[18px]">schedule</span>
                <span>Jam Buka Loket Pendaftaran &amp; Kegawatdaruratan</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white/10 border border-white/15 rounded-xl p-4">
                    <p class="text-xs text-emerald-200 uppercase font-semibold">Senin – Kamis &amp; Sabtu</p>
                    <p class="text-xl font-bold text-white mt-1">07:30 – 11:30 WIB</p>
                    <p class="text-xs text-emerald-100/80 mt-1">Pendaftaran Loket Rawat Jalan</p>
                </div>
                <div class="bg-white/10 border border-white/15 rounded-xl p-4">
                    <p class="text-xs text-emerald-200 uppercase font-semibold">Khusus Hari Jumat</p>
                    <p class="text-xl font-bold text-white mt-1">07:30 – 10:30 WIB</p>
                    <p class="text-xs text-emerald-100/80 mt-1">Pendaftaran Loket Rawat Jalan</p>
                </div>
                <div class="bg-emerald-500/20 border border-emerald-400/40 rounded-xl p-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <p class="text-xs text-emerald-200 uppercase font-semibold">UGD &amp; Persalinan (PONED)</p>
                    </div>
                    <p class="text-xl font-bold text-white mt-1">24 Jam Non-Stop</p>
                    <p class="text-xs text-emerald-100/80 mt-1">Setiap Hari Termasuk Hari Libur</p>
                </div>
            </div>
        </div>

        {{-- Kartu Persyaratan Pasien BPJS/KIS vs Pasien Umum --}}
        <div class="space-y-6">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-wider text-[#2E7D32]">Akuntabilitas &amp; Kejelasan</span>
                <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Syarat Berkas &amp; Ketentuan Pasien</h3>
                <p class="text-sm text-slate-600 mt-1">Pastikan Anda membawa kelengkapan dokumen sesuai kategori kepesertaan untuk mempercepat proses registrasi di loket.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Kartu 1: Pasien BPJS / KIS --}}
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-emerald-200 shadow-sm flex flex-col justify-between">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#2E7D32] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[26px]">health_and_safety</span>
                                </div>
                                <div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#ECFDF5] text-[#15803D] text-[11px] font-bold uppercase">
                                        Gratis 100% Ditanggung BPJS
                                    </span>
                                    <h4 class="text-xl font-bold text-slate-900 mt-1">Pasien BPJS / KIS</h4>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-slate-600">
                            Khusus peserta Jaminan Kesehatan Nasional (JKN-KIS PBI maupun Non-PBI) yang terdaftar aktif pada FKTP Puskesmas Cilimus.
                        </p>

                        <ul class="space-y-3 text-sm text-slate-700">
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                                <span><strong>KTP Elektronik Asli</strong> / Kartu Identitas Anak (KIA) atau Kartu Keluarga (KK).</span>
                            </li>
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                                <span><strong>Kartu Indonesia Sehat (KIS)</strong> fisik atau Kartu Digital aktif di aplikasi Mobile JKN.</span>
                            </li>
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                                <span><strong>Buku KIA</strong> khusus pemeriksaan kehamilan, persalinan, imunisasi, dan balita.</span>
                            </li>
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                                <span><strong>Kartu Berobat Pasien</strong> (untuk pasien kunjungan ulang agar pencarian rekam medis cepat).</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-[#ECFDF5] border border-emerald-200 text-xs sm:text-sm font-medium text-[#15803D] flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span>Bebas biaya retribusi pendaftaran, konsultasi dokter, dan obat formularium nasional.</span>
                    </div>
                </div>

                {{-- Kartu 2: Pasien Umum (Non-BPJS) --}}
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[26px]">receipt_long</span>
                                </div>
                                <div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-bold uppercase">
                                        Tarif Sesuai Perda Kab. Kuningan
                                    </span>
                                    <h4 class="text-xl font-bold text-slate-900 mt-1">Pasien Umum (Non-BPJS)</h4>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-slate-600">
                            Masyarakat umum atau peserta asuransi mandiri yang belum terintegrasi BPJS Kesehatan, dilayani dengan transparansi tarif resmi daerah.
                        </p>

                        <ul class="space-y-3 text-sm text-slate-700">
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-slate-700 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                                <span><strong>KTP Asli / Kartu Keluarga (KK)</strong> yang masih berlaku untuk registrasi rekam medis.</span>
                            </li>
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-slate-700 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                                <span><strong>Kartu Berobat Puskesmas Cilimus</strong> (apabila sudah pernah mendaftar sebelumnya).</span>
                            </li>
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/70">
                                <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                                <span><strong>Retribusi Pendaftaran &amp; Pemeriksaan: Rp10.000</strong> (sesuai Perda Kabupaten Kuningan tentang Pajak dan Retribusi Daerah).</span>
                            </li>
                            <li class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                                <span class="w-6 h-6 rounded-full bg-slate-700 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                                <span><strong>Tindakan Khusus &amp; Lab Lanjutan:</strong> Dikenakan tarif retribusi sesuai rincian Perda melalui kuitansi resmi BLUD.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-slate-100 border border-slate-200 text-xs sm:text-sm font-medium text-slate-700 flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-[#2E7D32]">qr_code_2</span>
                            <span>Tersedia Pembayaran Non-Tunai QRIS Resmi</span>
                        </span>
                        <span class="font-bold text-[#003822]">TUNAI / QRIS</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Banner Unduh Panduan PDF Resmi --}}
        <div class="bg-[#2E7D32] rounded-2xl p-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-md">
            <div class="space-y-2 max-w-2xl">
                <span class="inline-block px-3 py-1 rounded-full bg-white/15 text-emerald-100 text-xs font-semibold uppercase tracking-wider">
                    Dokumen Resmi Pelayanan
                </span>
                <h3 class="text-2xl sm:text-3xl font-bold">
                    Unduh Panduan Alur Pelayanan Pasien
                </h3>
                <p class="text-sm sm:text-base text-emerald-50/90">
                    Simpan atau cetak panduan resmi alur berobat dan syarat dokumen Puskesmas Cilimus sebagai acuan saat berkunjung.
                </p>
            </div>

            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 bg-white text-[#003822] hover:bg-emerald-50 font-bold px-6 py-3.5 rounded-xl text-sm shadow-sm flex-shrink-0 transition-colors">
                <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                <span>Unduh Panduan PDF Resmi</span>
            </button>
        </div>
    </section>
</x-app-layout>
