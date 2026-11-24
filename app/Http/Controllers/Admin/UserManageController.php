<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserManageController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email'        => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password'     => ['required', Password::defaults()],
            'peran'        => ['required', 'in:superadmin,admin'],
            'status'       => ['required', 'in:aktif,nonaktif'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Akun petugas pengelola berhasil didaftarkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email'        => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
            'password'     => ['nullable', Password::defaults()],
            'peran'        => ['required', 'in:superadmin,admin'],
            'status'       => ['required', 'in:aktif,nonaktif'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Data akun pengelola berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang aktif login.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun petugas pengelola berhasil dihapus.');
    }
}
