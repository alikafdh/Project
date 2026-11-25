<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManageController extends Controller
{
    /**
     * Memastikan hanya Superadmin yang dapat mengakses controller ini.
     */
    private function authorizeSuperadmin(): void
    {
        if (auth()->user()?->peran !== 'superadmin') {
            abort(403, 'Halaman ini khusus Superadmin.');
        }
    }

    /**
     * Tampilkan daftar akun staf dan pengelola CMS.
     */
    public function index(Request $request): View
    {
        $this->authorizeSuperadmin();

        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('peran')) {
            $query->where('peran', $request->peran);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10)->withQueryString();

        // Metrik Statistik Akun
        $totalUsers = User::count();
        $superadminCount = User::where('peran', 'superadmin')->count();
        $adminCount = User::where('peran', 'admin')->count();
        $activeCount = User::where('status', 'aktif')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'superadminCount',
            'adminCount',
            'activeCount'
        ));
    }

    /**
     * Tampilkan form pembuatan akun baru (jika diakses via rute terpisah).
     */
    public function create(): View
    {
        $this->authorizeSuperadmin();

        return view('admin.users.create');
    }

    /**
     * Simpan pendaftaran akun pengelola baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeSuperadmin();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email'        => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8'],
            'peran'        => ['required', 'in:superadmin,admin'],
            'status'       => ['required', 'in:aktif,nonaktif'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Akun petugas pengelola berhasil didaftarkan.');
    }

    /**
     * Tampilkan form edit akun (jika diakses via rute terpisah).
     */
    public function edit(User $user): View
    {
        $this->authorizeSuperadmin();

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Perbarui data akun staf.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeSuperadmin();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email'        => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password'     => ['nullable', 'string', 'min:8'],
            'peran'        => ['required', 'in:superadmin,admin'],
            'status'       => ['required', 'in:aktif,nonaktif'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Cegah superadmin mengubah peran/status akunnya sendiri secara tidak sengaja
        if ($user->id === auth()->id()) {
            $validated['peran'] = 'superadmin';
            $validated['status'] = 'aktif';
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Data akun pengelola berhasil diperbarui.');
    }

    /**
     * Hapus akun staf (cegah menghapus akun sendiri).
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeSuperadmin();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang aktif login.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun petugas pengelola berhasil dihapus.');
    }
}
