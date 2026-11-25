<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackManageController;
use App\Http\Controllers\Admin\KlasterController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\PostManageController;
use App\Http\Controllers\Admin\ProfileManageController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\Admin\UserManageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - UPTD Puskesmas Cilimus
|--------------------------------------------------------------------------
*/

// Beranda / Portal Publik (Dikerjakan oleh Anggota 1)
Route::get('/', function () {
    return view('welcome');
});

// Redirect default Breeze dashboard ke Admin Dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'status:aktif'])->name('dashboard');

// Halaman Login & Autentikasi Admin Pengelola
Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'authenticate']);

/*
|--------------------------------------------------------------------------
| Backoffice CMS (Dikerjakan oleh Anggota 2 - Backend)
| Terproteksi Middleware: auth & status:aktif
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'status:aktif'])->prefix('admin')->name('admin.')->group(function () {
    // Logout route for admin
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    // 1. Dashboard CMS
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Kelola Informasi / Posts (Laporan, Berita, Agenda)
    Route::resource('posts', PostManageController::class);

    // 3. Kelola Klaster ILP & Layanan Poliklinik
    Route::resource('klaster', KlasterController::class);
    Route::get('/clusters', [KlasterController::class, 'index'])->name('clusters.index');
    Route::resource('layanan', LayananController::class);

    // 4. Kelola Profil Puskesmas
    Route::get('/profil', [ProfileManageController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfileManageController::class, 'update'])->name('profil.update');

    // 5. Kotak Masuk Saran Warga
    Route::get('/saran', [FeedbackManageController::class, 'index'])->name('saran.index');
    Route::get('/feedback', [FeedbackManageController::class, 'index'])->name('feedback.index');
    Route::get('/saran/{saran}', [FeedbackManageController::class, 'show'])->name('saran.show');
    Route::patch('/saran/{saran}/read', [FeedbackManageController::class, 'markAsRead'])->name('saran.read');
    Route::delete('/saran/{saran}', [FeedbackManageController::class, 'destroy'])->name('saran.destroy');

    // 6. Otomasi Reminder WhatsApp Pasien
    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/schedules', [ReminderController::class, 'schedules'])->name('schedules');
        Route::post('/schedules', [ReminderController::class, 'storeSchedule'])->name('storeSchedule');
        Route::get('/patients', [ReminderController::class, 'patients'])->name('patients');
        Route::post('/patients', [ReminderController::class, 'storePatient'])->name('storePatient');
        Route::get('/logs', [ReminderController::class, 'logs'])->name('logs');
        Route::post('/send-test', [ReminderController::class, 'sendTest'])->name('sendTest');
        Route::post('/retry/{id}', [ReminderController::class, 'retry'])->name('retry');
        Route::get('/export/excel', [ReminderController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [ReminderController::class, 'exportPdf'])->name('export.pdf');
    });

    // 7. Kelola Akun Admin (Khusus Superadmin)
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', UserManageController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
