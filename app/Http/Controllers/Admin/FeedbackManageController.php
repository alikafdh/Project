<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackManageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Feedback::with('klaster')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $feedbacks = $query->paginate(10)->withQueryString();

        return view('admin.saran.index', compact('feedbacks'));
    }

    public function show(Feedback $saran): View
    {
        if ($saran->status === 'baru') {
            $saran->update(['status' => 'dibaca']);
        }

        return view('admin.saran.show', compact('saran'));
    }

    public function markAsRead(Request $request, Feedback $saran): RedirectResponse
    {
        $validated = $request->validate([
            'status'           => ['required', 'in:baru,dibaca,selesai'],
            'catatan_internal' => ['nullable', 'string'],
        ]);

        $saran->update($validated);

        return back()->with('success', 'Status saran dan catatan tindak lanjut berhasil diperbarui.');
    }

    public function destroy(Feedback $saran): RedirectResponse
    {
        $saran->delete();

        return redirect()->route('admin.saran.index')->with('success', 'Pesan saran berhasil dihapus.');
    }
}
