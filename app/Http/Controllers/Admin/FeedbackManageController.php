<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\KlasterILP;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackManageController extends Controller
{
    /**
     * Tampilkan kotak masuk kritik dan saran masyarakat.
     */
    public function index(Request $request): View
    {
        $query = Feedback::with('klaster')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('klaster_id')) {
            $query->where('klaster_id', $request->klaster_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengirim', 'like', "%{$search}%")
                  ->orWhere('kontak', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%")
                  ->orWhere('isi_pesan', 'like', "%{$search}%");
            });
        }

        $feedbacks = $query->paginate(10)->withQueryString();

        // 3 Stat Cards Metrik
        $totalFeedback = Feedback::count();
        $unreadFeedback = Feedback::where('status', 'baru')->count();
        $resolvedFeedback = Feedback::whereIn('status', ['dibaca', 'selesai'])->count();

        $klasters = KlasterILP::all();

        $viewName = view()->exists('admin.feedback.index') ? 'admin.feedback.index' : 'admin.saran.index';

        return view($viewName, compact(
            'feedbacks',
            'klasters',
            'totalFeedback',
            'unreadFeedback',
            'resolvedFeedback'
        ));
    }

    /**
     * Tampilkan rincian pesan saran dan tandai telah dibaca.
     */
    public function show(Feedback $saran): View
    {
        if ($saran->status === 'baru') {
            $saran->update(['status' => 'dibaca']);
        }

        return view('admin.saran.show', compact('saran'));
    }

    /**
     * Tandai saran sebagai telah dibaca / selesai ditindaklanjuti.
     */
    public function markAsRead(Request $request, Feedback $saran): RedirectResponse
    {
        $validated = $request->validate([
            'status'           => ['required', 'in:baru,dibaca,selesai'],
            'catatan_internal' => ['nullable', 'string', 'max:1000'],
        ]);

        $saran->update($validated);

        return back()->with('success', 'Status saran dan catatan tindak lanjut berhasil diperbarui.');
    }

    /**
     * Hapus pesan saran.
     */
    public function destroy(Feedback $saran): RedirectResponse
    {
        $saran->delete();

        return back()->with('success', 'Pesan saran berhasil dihapus.');
    }
}
