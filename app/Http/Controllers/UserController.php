<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,donatur,user,sr',
            'phone' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name ?? 'Guest User',
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,donatur,user,sr',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name ?? 'Guest User',
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}