<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Models\ReminderLog;
use App\Services\WhatsAppGatewayService;
use Illuminate\Console\Command;

class SendWhatsAppReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pesan reminder WhatsApp harian ke pasien UPTD Puskesmas Cilimus';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppGatewayService $gateway): int
    {
        $todayDay = (int) now()->format('j');
        $todayDate = now()->toDateString();

        $this->info("Menjalankan pengiriman pesan WhatsApp pengingat harian: " . now()->translatedFormat('d F Y'));

        // Ambil data reminder aktif yang jadwalnya cocok dengan hari ini
        $reminders = Reminder::where('status', 'aktif')
            ->where(function ($query) use ($todayDay, $todayDate) {
                $query->where(function ($q) use ($todayDay) {
                    $q->where('tipe_interval', 'bulanan')
                      ->where('hari_ke', $todayDay);
                })->orWhere(function ($q) use ($todayDate) {
                    $q->where('tipe_interval', 'sekali')
                      ->whereDate('tanggal_spesifik', $todayDate);
                });
            })
            ->get();

        if ($reminders->isEmpty()) {
            $this->info("Tidak ada jadwal pengingat pasien yang cocok untuk hari ini.");
            return Command::SUCCESS;
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($reminders as $reminder) {
            // Ganti placeholder variabel: {nama_pasien}, {tanggal}, {nama_puskesmas}
            $pesan = str_replace(
                ['{nama_pasien}', '{tanggal}', '{nama_puskesmas}'],
                [$reminder->nama_pasien, now()->translatedFormat('d F Y'), 'UPTD Puskesmas Cilimus'],
                $reminder->template_pesan ?? 'Yth. Pasien Puskesmas Cilimus, ini adalah pesan pengingat jadwal pemeriksaan Anda.'
            );

            $result = $gateway->sendMessage($reminder->nomor_wa, $pesan);

            $isSuccess = $result['success'] ?? false;
            $keterangan = is_array($result['response'] ?? null) 
                ? json_encode($result['response']) 
                : ($result['response'] ?? 'Respon gateway tidak diketahui');

            ReminderLog::create([
                'reminder_id'    => $reminder->id,
                'waktu_kirim'    => now(),
                'pesan_terkirim' => $pesan,
                'status'         => $isSuccess ? 'berhasil' : 'gagal',
                'keterangan'     => $keterangan,
            ]);

            if ($isSuccess) {
                $sentCount++;
                $this->line(" [BERHASIL] {$reminder->nama_pasien} ({$reminder->nomor_wa})");
            } else {
                $failedCount++;
                $this->warn(" [GAGAL] {$reminder->nama_pasien} ({$reminder->nomor_wa})");
            }
        }

        $this->info("Proses selesai: {$sentCount} berhasil dikirim, {$failedCount} gagal.");

        return Command::SUCCESS;
    }
}
