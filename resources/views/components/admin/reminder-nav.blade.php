@props(['active' => 'patients'])

<div class="inline-flex items-center gap-1.5 p-1.5 bg-slate-200/80 rounded-2xl border border-slate-300/60 shadow-inner">
    <!-- Tab 1: Pasien Terdaftar -->
    <a href="{{ route('admin.reminders.patients') }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $active === 'patients' ? 'text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}"
       @if($active === 'patients') style="background-color: #2E7D32;" @endif>
        <span class="material-symbols-outlined text-[18px]">group</span>
        <span>Pasien Terdaftar</span>
    </a>

    <!-- Tab 2: Jadwal & Template -->
    <a href="{{ route('admin.reminders.schedules') }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $active === 'schedules' ? 'text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}"
       @if($active === 'schedules') style="background-color: #2E7D32;" @endif>
        <span class="material-symbols-outlined text-[18px]">schedule</span>
        <span>Jadwal &amp; Template</span>
    </a>

    <!-- Tab 3: Log Pengiriman -->
    <a href="{{ route('admin.reminders.logs') }}" 
       class="flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ $active === 'logs' ? 'text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-white/60' }}"
       @if($active === 'logs') style="background-color: #2E7D32;" @endif>
        <span class="material-symbols-outlined text-[18px]">assignment</span>
        <span>Log Pengiriman</span>
    </a>
</div>
