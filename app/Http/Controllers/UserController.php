<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const ROLES = ['admin', 'teacher', 'student'];

    public function index()
    {
        $users = User::where('archived', 0)->orderBy('username')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['roles' => self::ROLES]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:tbl_users,username',
            'email'    => 'required|email|max:100|unique:tbl_users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => ['required', Rule::in(self::ROLES)],
        ]);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat!');
    }

    public function edit($id)
    {
        $user = User::where('archived', 0)->findOrFail($id);
        return view('users.edit', ['user' => $user, 'roles' => self::ROLES]);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('archived', 0)->findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:tbl_users,username,' . $id . ',user_id',
            'email'    => 'required|email|max:100|unique:tbl_users,email,' . $id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
            'role'     => ['required', Rule::in(self::ROLES)],
        ]);

        // Admin tidak boleh menurunkan role dirinya sendiri
        if ($user->user_id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'Anda tidak dapat mengubah role akun Anda sendiri.']);
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Akun berhasil diubah!');
    }

    public function destroy($id)
    {
        $user = User::where('archived', 0)->findOrFail($id);

        if ($user->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->update(['archived' => 1]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus!');
    }
}
