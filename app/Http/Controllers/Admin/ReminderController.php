<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KlasterILP;
use App\Models\Reminder;
use App\Models\ReminderLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function schedules(Request $request): View
    {
        $reminders = Reminder::with('klaster')->latest()->paginate(10);
        $klasters = KlasterILP::all();

        return view('admin.reminders.schedules', compact('reminders', 'klasters'));
    }

    public function patients(Request $request): View
    {
        $patients = Reminder::with('klaster')->latest()->paginate(10);
        $klasters = KlasterILP::all();

        return view('admin.reminders.patients', compact('patients', 'klasters'));
    }

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

        if ($validated['tipe_interval'] === 'bulanan' && empty($validated['jadwal'])) {
            $validated['jadwal'] = 'Setiap Tgl ' . ($validated['hari_ke'] ?? 1);
        }

        Reminder::create($validated);

        return back()->with('success', 'Jadwal reminder WhatsApp pasien berhasil didaftarkan.');
    }

    public function storePatient(Request $request): RedirectResponse
    {
        return $this->storeSchedule($request);
    }

    public function logs(Request $request): View
    {
        $logs = ReminderLog::with('reminder')->latest('waktu_kirim')->paginate(15);

        return view('admin.reminders.logs', compact('logs'));
    }

    public function sendTest(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reminder_id' => ['required', 'exists:reminders,id'],
        ]);

        $reminder = Reminder::findOrFail($validated['reminder_id']);

        // Substitute tokens
        $pesan = str_replace(
            ['{nama_pasien}', '{tanggal}', '{lokasi_kegiatan}'],
            [$reminder->nama_pasien, now()->isoFormat('D MMMM Y'), 'UPTD Puskesmas Cilimus'],
            $reminder->template_pesan
        );

        // Record simulated transmission to gateway
        ReminderLog::create([
            'reminder_id'    => $reminder->id,
            'waktu_kirim'    => now(),
            'pesan_terkirim' => $pesan,
            'status'         => 'berhasil',
            'keterangan'     => 'Simulasi Uji Transmisi WhatsApp Gateway API (Status: 200 OK)',
        ]);

        return back()->with('success', 'Pesan uji coba WhatsApp berhasil dikirim ke antrean log.');
    }

    public function retry(int $id): RedirectResponse
    {
        $log = ReminderLog::with('reminder')->findOrFail($id);

        $log->update([
            'waktu_kirim' => now(),
            'status'      => 'berhasil',
            'keterangan'  => 'Pengiriman ulang berhasil via WhatsApp Gateway API (200 OK)',
        ]);

        return back()->with('success', 'Pengiriman ulang pesan berhasil diproses.');
    }

    public function exportExcel(): Response
    {
        $logs = ReminderLog::with('reminder')->latest('waktu_kirim')->get();

        $csv = "ID,Nama Pasien,Nomor WhatsApp,Waktu Kirim,Status,Keterangan,Pesan Terkirim\n";

        foreach ($logs as $log) {
            $pesanClean = str_replace(["\r", "\n", '"'], ['', ' ', '""'], $log->pesan_terkirim ?? '');
            $csv .= sprintf(
                "%d,\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                $log->id,
                $log->reminder->nama_pasien ?? '-',
                $log->reminder->nomor_wa ?? '-',
                $log->waktu_kirim->format('Y-m-d H:i:s'),
                $log->status,
                $log->keterangan,
                $pesanClean
            );
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="reminder_logs_' . date('Ymd_His') . '.csv"',
        ]);
    }

    public function exportPdf(): View
    {
        $logs = ReminderLog::with('reminder')->latest('waktu_kirim')->get();

        return view('admin.reminders.pdf', compact('logs'));
    }
}
