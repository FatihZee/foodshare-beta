<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Helpers\FonnteHelper;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsAppNotificationService;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with(['user', 'donation'])->get();
        return view('claims.index', compact('claims'));
    }

    public function create()
    {
        $donations = Donation::where('status', 'available')->get();
        return view('claims.create', compact('donations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
        ]);

        $donation = Donation::findOrFail($request->donation_id);

        if ($donation->quantity <= 0) {
            return back()->with('error', 'Makanan sudah habis!');
        }

        $queueNumber = Claim::where('donation_id', $donation->id)->count() + 1;

        $claim = Claim::create([
            'user_id' => Auth::id(),
            'donation_id' => $donation->id,
            'queue_number' => $queueNumber,
        ]);

        $donation->decrement('quantity');

        if ($donation->quantity <= 0) {
            $donation->update(['status' => 'completed']);
        }

        $user = Auth::user();
        if ($user && $user->phone) {
            $message = "🎉 [FoodShare] Terima kasih telah berbagi dan peduli! 🎉  
            \nHalo {$user->name}, selamat! Klaim makanan Anda telah berhasil! 🍽️✨  
            \n🔢 No. Antrean: {$queueNumber}  
            \n📍 Lokasi: {$donation->location}  
            \n⏳ Silakan datang sebelum: {$donation->expiration}  
            \nJangan lupa datang tepat waktu ya! Semoga bermanfaat dan tetap berbagi kebaikan! ❤️ #FoodShare";
            
            FonnteHelper::sendMessage($user->phone, $message);
        }

        return redirect()->route('claims.index')->with('success', 'Klaim berhasil dibuat dan pesan WhatsApp dikirim!');
    }

    public function show(Claim $claim)
    {
        return view('claims.show', compact('claim'));
    }

    public function edit(Claim $claim)
    {
        return view('claims.edit', compact('claim'));
    }

    public function update(Request $request, Claim $claim)
    {
        $request->validate(['status' => 'required|in:pending,collected,cancelled']);
        $claim->update($request->only('status'));

        return redirect()->route('claims.index')->with('success', 'Status klaim diperbarui!');
    }

    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('claims.index')->with('success', 'Klaim berhasil dihapus!');
    }
}