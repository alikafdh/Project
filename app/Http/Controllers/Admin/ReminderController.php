<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Reminder;
use App\Models\ReminderLog;
use App\Services\WhatsAppGatewayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReminderController extends Controller
{
    /**
     * Helper untuk memformat nomor telepon ke format E.164 (+628...).
     */
    private function formatPhoneNumber(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($clean, '0')) {
            return '+62' . substr($clean, 1);
        }

        if (str_starts_with($clean, '62')) {
            return '+' . $clean;
        }

        if (!str_starts_with($phone, '+')) {
            return '+62' . $clean;
        }

        return $phone;
    }

    /**
     * TAB 1: Daftar Pasien Terdaftar.
     */
    public function patients(Request $request): View
    {
        $query = Reminder::with('klaster')->latest();

        if ($request->filled('klaster_id')) {
            $query->where('klaster_id', $request->klaster_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('nomor_wa', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(10)->withQueryString();
        $klasters = KlasterILP::all();

        // Metrik Ringkasan Pasien
        $totalPatients = Reminder::count();
        $activePatients = Reminder::where('status', 'aktif')->count();
        $inactivePatients = Reminder::where('status', 'nonaktif')->count();
        $scheduledThisWeek = Reminder::where('status', 'aktif')->count();

        return view('admin.reminders.patients', compact(
            'patients',
            'klasters',
            'totalPatients',
            'activePatients',
            'inactivePatients',
            'scheduledThisWeek'
        ));
    }

    /**
     * Simpan pendaftaran pasien baru.
     */
    public function storePatient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pasien'      => ['required', 'string', 'max:100'],
            'nomor_wa'         => ['required', 'string', 'max:30'],
            'klaster_id'       => ['required', 'exists:klaster_ilp,id'],
            'jadwal'           => ['nullable', 'string', 'max:100'],
            'template_pesan'   => ['required', 'string'],
            'status'           => ['required', 'in:aktif,nonaktif'],
            'tipe_interval'    => ['nullable', 'in:sekali,bulanan'],
            'hari_ke'          => ['nullable', 'integer', 'min:1', 'max:31'],
            'tanggal_spesifik' => ['nullable', 'date'],
            'jam_kirim'        => ['nullable', 'string'],
        ]);

        $validated['nomor_wa'] = $this->formatPhoneNumber($validated['nomor_wa']);
        $validated['tipe_interval'] = $validated['tipe_interval'] ?? 'bulanan';
        $validated['jam_kirim'] = $validated['jam_kirim'] ?? '08:00:00';

        if ($validated['tipe_interval'] === 'bulanan' && empty($validated['jadwal'])) {
            $validated['jadwal'] = 'Setiap Tgl ' . ($validated['hari_ke'] ?? 1);
        }

        Reminder::create($validated);

        return redirect()->route('admin.reminders.patients')->with('success', 'Pasien baru berhasil didaftarkan ke sistem reminder WhatsApp.');
    }

    /**
     * TAB 2: Jadwal & Template Pesan Pengingat.
     */
    public function schedules(Request $request): View
    {
        $query = Reminder::with('klaster')->latest();

        if ($request->filled('klaster_id')) {
            $query->where('klaster_id', $request->klaster_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('jadwal', 'like', "%{$search}%")
                  ->orWhere('template_pesan', 'like', "%{$search}%");
            });
        }

        $reminders = $query->paginate(10)->withQueryString();
        $klasters = KlasterILP::all();

        // Metrik Ringkasan Jadwal
        $totalSchedules = Reminder::where('status', 'aktif')->count();
        $totalPatients = Reminder::count();
        $totalSentThisMonth = ReminderLog::where('status', 'berhasil')->whereMonth('waktu_kirim', now()->month)->count();
        $allLogsCount = ReminderLog::count();
        $successRate = $allLogsCount > 0 ? round((ReminderLog::where('status', 'berhasil')->count() / $allLogsCount) * 100, 1) : 100;

        return view('admin.reminders.schedules', compact(
            'reminders',
            'klasters',
            'totalSchedules',
            'totalPatients',
            'totalSentThisMonth',
            'successRate'
        ));
    }

    /**
     * Buat jadwal baru dan simpan template pesan.
     */
    public function storeSchedule(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pasien'      => ['required', 'string', 'max:100'],
            'nomor_wa'         => ['required', 'string', 'max:30'],
            'klaster_id'       => ['required', 'exists:klaster_ilp,id'],
            'tipe_interval'    => ['required', 'in:sekali,bulanan'],
            'hari_ke'          => ['nullable', 'integer', 'min:1', 'max:31'],
            'tanggal_spesifik' => ['nullable', 'date'],
            'jam_kirim'        => ['required', 'string'],
            'jadwal'           => ['nullable', 'string', 'max:100'],
            'template_pesan'   => ['required', 'string'],
            'status'           => ['required', 'in:aktif,nonaktif'],
        ]);

        $validated['nomor_wa'] = $this->formatPhoneNumber($validated['nomor_wa']);

        if ($validated['tipe_interval'] === 'bulanan' && empty($validated['jadwal'])) {
            $validated['jadwal'] = 'Setiap Tgl ' . ($validated['hari_ke'] ?? 1);
        } elseif ($validated['tipe_interval'] === 'sekali' && empty($validated['jadwal']) && !empty($validated['tanggal_spesifik'])) {
            $validated['jadwal'] = 'Sekali Jalan (' . $validated['tanggal_spesifik'] . ')';
        }

        Reminder::create($validated);

        return redirect()->route('admin.reminders.schedules')->with('success', 'Jadwal dan konfigurasi template reminder berhasil disimpan.');
    }

    /**
     * Uji coba pengiriman pesan WhatsApp Gateway.
     */
    public function sendTest(Request $request, WhatsAppGatewayService $gateway): RedirectResponse
    {
        $validated = $request->validate([
            'reminder_id'  => ['nullable', 'exists:reminders,id'],
            'target_phone' => ['nullable', 'string', 'max:30'],
            'message'      => ['nullable', 'string'],
        ]);

        if (!empty($validated['reminder_id'])) {
            $reminder = Reminder::findOrFail($validated['reminder_id']);
            $targetPhone = !empty($validated['target_phone']) 
                ? $this->formatPhoneNumber($validated['target_phone']) 
                : $reminder->nomor_wa;

            $pesan = str_replace(
                ['{nama_pasien}', '{tanggal}', '{nama_puskesmas}'],
                [$reminder->nama_pasien, now()->translatedFormat('d F Y'), 'UPTD Puskesmas Cilimus'],
                $reminder->template_pesan ?? 'Uji coba pesan reminder UPTD Puskesmas Cilimus'
            );
        } else {
            $targetPhone = $this->formatPhoneNumber($validated['target_phone'] ?? '+6281234567890');
            $pesan = $validated['message'] ?? 'Uji coba transmisi pesan WhatsApp Gateway UPTD Puskesmas Cilimus pada ' . now()->format('d/m/Y H:i:s');
            $reminder = Reminder::first();
        }

        $result = $gateway->sendMessage($targetPhone, $pesan);
        $isSuccess = $result['success'] ?? false;
        $keterangan = is_array($result['response'] ?? null) 
            ? json_encode($result['response']) 
            : ($result['response'] ?? 'Uji coba transmisi selesai');

        if ($reminder) {
            ReminderLog::create([
                'reminder_id'    => $reminder->id,
                'waktu_kirim'    => now(),
                'pesan_terkirim' => $pesan,
                'status'         => $isSuccess ? 'berhasil' : 'gagal',
                'keterangan'     => 'Uji Transmisi Manual: ' . $keterangan,
            ]);
        }

        if ($isSuccess) {
            return back()->with('success', "Pesan uji coba WhatsApp berhasil dikirim ke {$targetPhone}.");
        }

        return back()->with('error', "Uji coba pengiriman gagal. Respon gateway: {$keterangan}");
    }

    /**
     * TAB 3: Log Riwayat Transmisi Pengiriman Pesan.
     */
    public function logs(Request $request): View
    {
        $query = ReminderLog::with('reminder.klaster')->latest('waktu_kirim');

        if ($request->filled('nama_reminder')) {
            $search = $request->nama_reminder;
            $query->whereHas('reminder', function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('jadwal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('waktu_kirim', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->paginate(15)->withQueryString();

        // Metrik Ringkasan Log
        $totalSent = ReminderLog::where('status', 'berhasil')->count();
        $totalFailed = ReminderLog::where('status', 'gagal')->count();
        $totalPending = ReminderLog::where('status', 'pending')->count();

        // Data daftar reminder untuk dropdown filter nama reminder
        $allReminders = Reminder::select('id', 'nama_pasien', 'jadwal')->orderBy('nama_pasien')->get();

        return view('admin.reminders.logs', compact(
            'logs',
            'totalSent',
            'totalFailed',
            'totalPending',
            'allReminders'
        ));
    }

    /**
     * Kirim ulang pesan yang berstatus gagal.
     */
    public function retry(int $id, WhatsAppGatewayService $gateway): RedirectResponse
    {
        $log = ReminderLog::with('reminder')->findOrFail($id);

        $targetPhone = $log->reminder->nomor_wa ?? null;
        $pesan = $log->pesan_terkirim;

        if (!$targetPhone) {
            return back()->with('error', 'Nomor telepon tujuan tidak ditemukan pada data pasien.');
        }

        $result = $gateway->sendMessage($targetPhone, $pesan);
        $isSuccess = $result['success'] ?? false;
        $keterangan = is_array($result['response'] ?? null) 
            ? json_encode($result['response']) 
            : ($result['response'] ?? 'Pengiriman ulang berhasil');

        $log->update([
            'waktu_kirim' => now(),
            'status'      => $isSuccess ? 'berhasil' : 'gagal',
            'keterangan'  => 'Retry: ' . $keterangan,
        ]);

        if ($isSuccess) {
            return back()->with('success', 'Pesan WhatsApp berhasil dikirim ulang ke ' . $targetPhone . '.');
        }

        return back()->with('error', 'Pengiriman ulang masih gagal: ' . $keterangan);
    }

    /**
     * Ekspor log riwayat transmisi ke CSV (Format Excel).
     */
    public function exportExcel(): Response
    {
        $logs = ReminderLog::with(['reminder.klaster'])->latest('waktu_kirim')->get();

        $csv = "ID,Nama Pasien,Nomor WhatsApp,Klaster ILP,Waktu Kirim,Status,Keterangan,Pesan Terkirim\n";

        foreach ($logs as $log) {
            $pesanClean = str_replace(["\r", "\n", '"'], ['', ' ', '""'], $log->pesan_terkirim ?? '');
            $keteranganClean = str_replace(["\r", "\n", '"'], ['', ' ', '""'], $log->keterangan ?? '');

            $csv .= sprintf(
                "%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                $log->id,
                $log->reminder->nama_pasien ?? '-',
                $log->reminder->nomor_wa ?? '-',
                $log->reminder->klaster->nama ?? 'Umum',
                $log->waktu_kirim ? $log->waktu_kirim->format('Y-m-d H:i:s') : '-',
                strtoupper($log->status),
                $keteranganClean,
                $pesanClean
            );
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="log_reminder_wa_' . date('Ymd_His') . '.csv"',
        ]);
    }

    /**
     * Ekspor / Tampilan Cetak PDF Log Transmisi.
     */
    public function exportPdf(): View
    {
        $logs = ReminderLog::with(['reminder.klaster'])->latest('waktu_kirim')->get();

        return view('admin.reminders.pdf', compact('logs'));
    }
}
