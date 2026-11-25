<x-admin-layout title="Manajemen Akun Admin">
    <div class="space-y-6" x-data="{
        createModalOpen: false,
        editModalOpen: false,
        currentUser: {
            id: '',
            nama_lengkap: '',
            username: '',
            email: '',
            peran: 'admin',
            status: 'aktif'
        },
        editUrl: '',
        openCreateModal() {
            this.createModalOpen = true;
        },
        openEditModal(user, url) {
            this.currentUser = { ...user };
            this.editUrl = url;
            this.editModalOpen = true;
        }
    }">
        <!-- Top Breadcrumb & Page Header -->
        <div class="space-y-1">
            <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                <span>Admin Portal</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Pengaturan Sistem</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#2E7D32] font-semibold">Kelola Akun Petugas</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Akun Pengelola CMS</h1>
                    <p class="text-sm text-slate-500 max-w-3xl leading-relaxed mt-0.5">
                        Kelola data staf medis, administrator, dan humas yang memiliki otorisasi akses ke backoffice UPTD Puskesmas Cilimus.
                    </p>
                </div>
                <button type="button" 
                        @click="openCreateModal()" 
                        class="h-11 px-5 rounded-xl text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all hover:opacity-95 self-start sm:self-auto" 
                        style="background-color: #2E7D32;">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    <span>+ Tambah Akun Baru</span>
                </button>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Akun Terdaftar</span>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalUsers }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Petugas dengan hak akses</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
                    <span class="material-symbols-outlined text-[26px]">badge</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Superadmin</span>
                    <h3 class="text-2xl font-bold text-amber-700 mt-1">{{ $superadminCount }}</h3>
                    <p class="text-xs text-amber-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">shield_person</span> Akses kontrol penuh
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-[26px]">admin_panel_settings</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Administrator / Staf</span>
                    <h3 class="text-2xl font-bold text-[#2E7D32] mt-1">{{ $adminCount }}</h3>
                    <p class="text-xs text-[#2E7D32] font-medium flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">manage_accounts</span> Pengelola modul
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-[#2E7D32]">
                    <span class="material-symbols-outlined text-[26px]">group</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status Aktif</span>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-1">{{ $activeCount }}</h3>
                    <p class="text-xs text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Dapat login ke sistem
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-[26px]">check_circle</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama lengkap, username, atau email petugas..." 
                        class="w-full h-11 pl-10 pr-4 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] transition-all">
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Filter Peran -->
                    <div class="w-40">
                        <select name="peran" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Peran</option>
                            <option value="superadmin" {{ request('peran') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            <option value="admin" {{ request('peran') === 'admin' ? 'selected' : '' }}>Admin / Staf</option>
                        </select>
                    </div>

                    <!-- Filter Status -->
                    <div class="w-36">
                        <select name="status" class="w-full h-11 px-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700 focus:bg-white focus:border-[#2E7D32] focus:ring-[#2E7D32] cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <button type="submit" class="h-11 px-4 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition-colors flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">filter_list</span>
                        <span>Filter</span>
                    </button>

                    @if(request()->anyFilled(['search', 'peran', 'status']))
                        <a href="{{ route('admin.users.index') }}" class="h-11 px-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-500 hover:text-slate-800 hover:bg-slate-50 flex items-center transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- TABEL DATA AKUN STAF -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-4 w-12 text-center">No</th>
                            <th class="py-4 px-4">Nama Lengkap</th>
                            <th class="py-4 px-3">Username</th>
                            <th class="py-4 px-4">Email Resmi</th>
                            <th class="py-4 px-3 text-center">Peran</th>
                            <th class="py-4 px-3 text-center">Status</th>
                            <th class="py-4 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($users as $index => $u)
                            <tr class="hover:bg-slate-50/70 transition-colors group">
                                <td class="py-4 px-4 text-center text-xs font-mono text-slate-400">
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <td class="py-4 px-4 font-bold text-slate-800 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-9 h-9 rounded-full {{ $u->peran === 'superadmin' ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-emerald-100 text-emerald-900 border border-emerald-300' }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($u->nama_lengkap, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5">
                                                <span>{{ $u->nama_lengkap }}</span>
                                                @if($u->id === auth()->id())
                                                    <span class="px-1.5 py-0.2 rounded bg-emerald-100 text-[#2E7D32] text-[10px] font-bold">(Akun Anda)</span>
                                                @endif
                                            </div>
                                            <div class="text-[11px] text-slate-400 font-normal">Dibuat: {{ $u->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-3 whitespace-nowrap font-mono text-xs text-slate-600">
                                    &#64;{{ $u->username }}
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap text-xs text-slate-600">
                                    <a href="mailto:{{ $u->email }}" class="hover:text-[#2E7D32] hover:underline flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-slate-400">mail</span>
                                        {{ $u->email }}
                                    </a>
                                </td>

                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($u->peran === 'superadmin')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            <span class="material-symbols-outlined text-[13px]">shield</span>
                                            Superadmin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <span class="material-symbols-outlined text-[13px]">person</span>
                                            Admin
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-3 text-center whitespace-nowrap">
                                    @if($u->status === 'aktif')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <!-- Tombol Edit Modal -->
                                        <button type="button" 
                                                @click="openEditModal({
                                                    id: {{ $u->id }},
                                                    nama_lengkap: '{{ addslashes($u->nama_lengkap) }}',
                                                    username: '{{ addslashes($u->username) }}',
                                                    email: '{{ addslashes($u->email) }}',
                                                    peran: '{{ $u->peran }}',
                                                    status: '{{ $u->status }}'
                                                }, '{{ route('admin.users.update', $u) }}')"
                                                class="p-2 rounded-lg text-slate-500 hover:text-[#2E7D32] hover:bg-emerald-50 transition-colors"
                                                title="Edit Akun Petugas">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>

                                        <!-- Tombol Hapus (Cegah Hapus Akun Sendiri) -->
                                        @if($u->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengelola ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus Akun">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="p-2 text-slate-300 cursor-not-allowed" title="Anda tidak dapat menghapus akun Anda sendiri">
                                                <span class="material-symbols-outlined text-[18px]">lock</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 px-6 text-center text-slate-400">
                                    Belum ada akun pengelola yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL TAMBAH AKUN BARU (Alpine.js) -->
        <div x-show="createModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="createModalOpen = false" class="bg-white w-full max-w-lg rounded-2xl p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#2E7D32] flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">person_add</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Tambah Akun Pengelola Baru</h3>
                    </div>
                    <button type="button" @click="createModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label for="create_nama_lengkap" class="text-xs font-bold text-slate-700 block mb-1">
                            Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="create_nama_lengkap" required placeholder="Contoh: dr. H. Hendra, M.Kes" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="create_username" class="text-xs font-bold text-slate-700 block mb-1">
                                Username Login <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="username" id="create_username" required placeholder="hendra_puskesmas" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs font-mono focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>

                        <div>
                            <label for="create_email" class="text-xs font-bold text-slate-700 block mb-1">
                                Alamat Email Resmi <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="create_email" required placeholder="hendra@puskesmascilimus.id" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>
                    </div>

                    <div>
                        <label for="create_password" class="text-xs font-bold text-slate-700 block mb-1">
                            Kata Sandi (Minimal 8 Karakter) <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" name="password" id="create_password" required minlength="8" placeholder="••••••••" class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <!-- Radio Button Peran -->
                    <div>
                        <span class="text-xs font-bold text-slate-700 block mb-2">Tingkat Hak Akses / Peran:</span>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="p-3 rounded-xl border border-slate-200 hover:border-[#2E7D32] flex items-center justify-between cursor-pointer transition-all">
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Admin Staf</div>
                                    <div class="text-[11px] text-slate-400">Kelola konten, layanan &amp; reminder</div>
                                </div>
                                <input type="radio" name="peran" value="admin" checked class="w-4 h-4 text-[#2E7D32] focus:ring-[#2E7D32]">
                            </label>

                            <label class="p-3 rounded-xl border border-slate-200 hover:border-amber-500 flex items-center justify-between cursor-pointer transition-all">
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Superadmin</div>
                                    <div class="text-[11px] text-slate-400">Akses penuh termasuk akun staf</div>
                                </div>
                                <input type="radio" name="peran" value="superadmin" class="w-4 h-4 text-amber-600 focus:ring-amber-500">
                            </label>
                        </div>
                    </div>

                    <!-- Switch Status -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Status Keaktifan Akun</span>
                            <p class="text-[11px] text-slate-400">Akun aktif dapat langsung masuk ke panel admin.</p>
                        </div>
                        <select name="status" class="h-9 px-3 rounded-lg border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95" style="background-color: #2E7D32;">
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL EDIT AKUN ADMIN (Alpine.js) -->
        <div x-show="editModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="editModalOpen = false" class="bg-white w-full max-w-lg rounded-2xl p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#2E7D32] flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Ubah Data Akun Pengelola</h3>
                    </div>
                    <button type="button" @click="editModalOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-slate-700">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form :action="editUrl" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="edit_nama_lengkap" class="text-xs font-bold text-slate-700 block mb-1">
                            Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" id="edit_nama_lengkap" x-model="currentUser.nama_lengkap" required class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="edit_username" class="text-xs font-bold text-slate-700 block mb-1">
                                Username Login <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="username" id="edit_username" x-model="currentUser.username" required class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs font-mono focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>

                        <div>
                            <label for="edit_email" class="text-xs font-bold text-slate-700 block mb-1">
                                Alamat Email Resmi <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="edit_email" x-model="currentUser.email" required class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                        </div>
                    </div>

                    <div>
                        <label for="edit_password" class="text-xs font-bold text-slate-700 block mb-1">
                            Kata Sandi Baru (Opsional)
                        </label>
                        <input type="password" name="password" id="edit_password" minlength="8" placeholder="Kosongkan jika tidak ingin mengubah kata sandi..." class="w-full h-10 px-3 rounded-xl border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                    </div>

                    <!-- Radio Button Peran -->
                    <div>
                        <span class="text-xs font-bold text-slate-700 block mb-2">Tingkat Hak Akses / Peran:</span>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="p-3 rounded-xl border border-slate-200 hover:border-[#2E7D32] flex items-center justify-between cursor-pointer transition-all"
                                   :class="currentUser.peran === 'admin' ? 'border-[#2E7D32] bg-emerald-50/50' : ''">
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Admin Staf</div>
                                    <div class="text-[11px] text-slate-400">Kelola modul operasional</div>
                                </div>
                                <input type="radio" name="peran" value="admin" x-model="currentUser.peran" class="w-4 h-4 text-[#2E7D32] focus:ring-[#2E7D32]">
                            </label>

                            <label class="p-3 rounded-xl border border-slate-200 hover:border-amber-500 flex items-center justify-between cursor-pointer transition-all"
                                   :class="currentUser.peran === 'superadmin' ? 'border-amber-500 bg-amber-50/50' : ''">
                                <div>
                                    <div class="text-xs font-bold text-slate-800">Superadmin</div>
                                    <div class="text-[11px] text-slate-400">Hak akses penuh sistem</div>
                                </div>
                                <input type="radio" name="peran" value="superadmin" x-model="currentUser.peran" class="w-4 h-4 text-amber-600 focus:ring-amber-500">
                            </label>
                        </div>
                    </div>

                    <!-- Switch Status -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Status Keaktifan Akun</span>
                            <p class="text-[11px] text-slate-400">Kontrol izin masuk ke backoffice CMS.</p>
                        </div>
                        <select name="status" x-model="currentUser.status" class="h-9 px-3 rounded-lg border-slate-200 text-xs focus:border-[#2E7D32] focus:ring-[#2E7D32]">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95" style="background-color: #2E7D32;">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
