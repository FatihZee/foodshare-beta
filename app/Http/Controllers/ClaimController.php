<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WhatsAppNotificationService;

class ClaimController extends Controller
{
    // Menampilkan daftar klaim
    public function index()
    {
        $claims = Claim::with(['user', 'donation'])->get();
        return view('claims.index', compact('claims'));
    }

    // Menampilkan form klaim makanan
    public function create()
    {
        $donations = Donation::where('status', 'available')->get();
        return view('claims.create', compact('donations'));
    }
    
    protected $whatsappService;

    public function __construct(WhatsAppNotificationService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    // Menyimpan klaim baru
    public function store(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
        ]);

        $donation = Donation::findOrFail($request->donation_id);

        // Cek apakah makanan masih tersedia
        if ($donation->quantity <= 0) {
            return back()->with('error', 'Makanan sudah habis!');
        }

        // Hitung nomor antrean
        $queueNumber = Claim::where('donation_id', $donation->id)->count() + 1;

        // Buat klaim
        $claim = Claim::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'donation_id' => $donation->id,
            'queue_number' => $queueNumber,
        ]);

        // Kurangi jumlah makanan & cek status
        $donation->decrementQuantity();
        
        // Kirimkan notifikasi WhatsApp
        $userPhone = $request->user()->phone; // Misalnya nomor telepon user disimpan
        $message = "Selamat, Anda berhasil melakukan klaim donasi. Nomor antrian Anda adalah {$claim->queue_number}.";
        $this->whatsappService->sendMessage($userPhone, $message);

        return redirect()->route('claims.index')->with('success', 'Klaim berhasil dibuat!');
    }

    // Menampilkan detail klaim
    public function show(Claim $claim)
    {
        return view('claims.show', compact('claim'));
    }

    // Menampilkan form edit klaim (jika perlu)
    public function edit(Claim $claim)
    {
        return view('claims.edit', compact('claim'));
    }

    // Update klaim (jika perlu)
    public function update(Request $request, Claim $claim)
    {
        $request->validate(['status' => 'required|in:pending,collected,cancelled']);
        $claim->update($request->only('status'));

        return redirect()->route('claims.index')->with('success', 'Status klaim diperbarui!');
    }

    // Hapus klaim (opsional)
    public function destroy(Claim $claim)
    {
        $claim->delete();
        return redirect()->route('claims.index')->with('success', 'Klaim berhasil dihapus!');
    }
}