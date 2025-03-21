<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('donor')->get();
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        return view('donations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'location' => 'required|string',
            'donor_name' => 'nullable|string|max:255',
            'maps' => 'nullable|url',
        ]);

        Donation::create([
            'donor_id' => Auth::check() ? Auth::id() : null,
            'donor_name' => $request->donor_name ?: 'Hamba Allah',
            'food_name' => $request->food_name,
            'quantity' => $request->quantity,
            'location' => $request->location,
            'expiration' => now()->addMinutes(30),
            'maps' => $request->maps,
            'status' => 'available'
        ]);

        return redirect()->route('donations.index')->with('success', 'Donasi berhasil ditambahkan! Waktu kedaluwarsa otomatis diatur 30 menit ke depan.');
    }

    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        if (Auth::id() !== $donation->donor_id) {
            abort(403, 'Unauthorized');
        }
        return view('donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        if (Auth::id() !== $donation->donor_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'location' => 'required|string',
            'expiration' => 'required|date|after:today',
            'maps' => 'nullable|url',
        ]);

        $donation->update($request->only('food_name', 'quantity', 'location', 'expiration', 'status', 'maps'));
        return redirect()->route('donations.index')->with('success', 'Donasi berhasil diupdate!');
    }

    public function destroy(Donation $donation)
    {
        if (Auth::id() !== $donation->donor_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donasi berhasil dihapus!');
}

}