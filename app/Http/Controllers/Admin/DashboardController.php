<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Post;
use App\Models\Reminder;
use App\Models\ReminderLog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Hitung 4 Metrik Statistik Utama
        $totalPost = Post::where('status', 'published')->count();
        $totalPasienReminder = Reminder::where('status', 'aktif')->count();
        $totalWaBerhasil = ReminderLog::where('status', 'berhasil')->count();
        $totalSaranBelumDibaca = Feedback::where('status', 'baru')->count();

        // 2. Ambil Data Tabel Cepat
        $kontenTerbaru = Post::with(['klaster', 'author'])->latest()->take(5)->get();
        $saranTerkini = Feedback::with('klaster')->where('status', 'baru')->latest()->take(5)->get();
        $logReminderTerakhir = ReminderLog::with('reminder.klaster')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPost',
            'totalPasienReminder',
            'totalWaBerhasil',
            'totalSaranBelumDibaca',
            'kontenTerbaru',
            'saranTerkini',
            'logReminderTerakhir'
        ));
    }
}
