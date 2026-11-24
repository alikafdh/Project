<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\KlasterILP;
use App\Models\Layanan;
use App\Models\Post;
use App\Models\Reminder;
use App\Models\ReminderLog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalKlaster = KlasterILP::count();
        $totalLayanan = Layanan::where('status', 'aktif')->count();
        $totalPosts = Post::where('status', 'published')->count();
        $totalSaranBaru = Feedback::where('status', 'baru')->count();
        $totalPasienReminder = Reminder::where('status', 'aktif')->count();
        $totalLogsBerhasil = ReminderLog::where('status', 'berhasil')->count();

        $recentFeedbacks = Feedback::with('klaster')->latest()->take(5)->get();
        $recentPosts = Post::with(['klaster', 'author'])->latest()->take(5)->get();
        $recentLogs = ReminderLog::with('reminder')->latest('waktu_kirim')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalKlaster',
            'totalLayanan',
            'totalPosts',
            'totalSaranBaru',
            'totalPasienReminder',
            'totalLogsBerhasil',
            'recentFeedbacks',
            'recentPosts',
            'recentLogs'
        ));
    }
}
