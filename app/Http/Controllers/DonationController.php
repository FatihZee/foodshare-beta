<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Helpers\FonnteHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DonationMessageHelper;

class DonationController extends Controller
{
    public function index()
    {
        $available = Donation::where('status', 'available')->count();
        $claimed = Donation::where('status', 'claimed')->count();
        $completed = Donation::where('status', 'completed')->count();

        $donationsPerDay = Donation::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $donations = Donation::all();

        return view('donations.index', compact('donations', 'available', 'claimed', 'completed', 'donationsPerDay'));
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

        DB::beginTransaction();
        try {
            $donor = Auth::user();
            $donation = Donation::create([
                'donor_id' => $donor ? $donor->id : null,
                'donor_name' => $request->donor_name ?: ($donor ? $donor->name : 'Hamba Allah'),
                'food_name' => $request->food_name,
                'quantity' => $request->quantity,
                'location' => $request->location,
                'expiration' => now()->addMinutes(30),
                'maps' => $request->maps,
                'status' => 'available'
            ]);

            if ($donor && $donor->phone) {
                $message = DonationMessageHelper::generateDonationMessage($donation);
                FonnteHelper::sendMessage($donor->phone, $message);
            }

            DB::commit();
            return redirect()->route('donations.index')->with('success', 'Donasi berhasil ditambahkan dan notifikasi WhatsApp dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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