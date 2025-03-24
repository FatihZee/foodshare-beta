<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                return redirect()->route('users.index')->with('error', 'Anda tidak memiliki izin admin.');
            }
            return $next($request);
        })->only(['create', 'store', 'destroy']);
    }

    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $users = User::all();
        } else {
            $users = User::where('id', auth()->id())->get();
        }

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
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profilePicture = null;
        if ($request->hasFile('profilePicture')) {
            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('profilePicture')->getRealPath(),
                ['folder' => 'user_profile_images']
            );
            $profilePicture = $uploadedFile['secure_url'];
        }

        User::create([
            'name' => $request->name ?? 'Guest User',
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,
            'role' => $request->role,
            'phone' => $request->phone,
            'profilePicture' => $profilePicture,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki izin.');
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin' || auth()->id() === $user->id) {
            return view('users.edit', compact('user'));
        }

        return redirect()->route('users.index')->with('error', 'Anda tidak memiliki izin.');
    }

    public function update(Request $request, User $user)
    {
        if (!(auth()->user()->role === 'admin' || auth()->id() === $user->id)) {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki izin.');
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|in:admin,donatur,user,sr',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [
            'name' => $request->name ?? 'Guest User',
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone' => $request->phone,
        ];

        if (auth()->user()->role === 'admin') {
            $updateData['role'] = $request->role;
        }

        if ($request->hasFile('profilePicture')) {
            if ($user->profilePicture) {
                $publicId = pathinfo(parse_url($user->profilePicture, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::uploadApi()->destroy($publicId);
            }

            $uploadedFile = Cloudinary::uploadApi()->upload(
                $request->file('profilePicture')->getRealPath(),
                ['folder' => 'user_profile_images']
            );
            $updateData['profilePicture'] = $uploadedFile['secure_url'];
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki izin.');
        }

        if ($user->profilePicture) {
            $publicId = pathinfo(parse_url($user->profilePicture, PHP_URL_PATH), PATHINFO_FILENAME);
            Cloudinary::uploadApi()->destroy($publicId, ['invalidate' => true]);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

}