<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Helpers\FonnteHelper;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ClaimMessageHelper;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            $claims = Claim::with(['user', 'donation'])->get();
        } elseif ($user) {
            $claims = Claim::with(['user', 'donation'])->where('user_id', $user->id)->get();
        } else {
            $claims = collect();
        }

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

        DB::beginTransaction();
        try {
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

            // Kirim pesan WA jika user punya nomor telepon
            $user = Auth::user();
            if ($user && $user->phone) {
                $message = ClaimMessageHelper::generateClaimMessage($user, $donation, $queueNumber);
                $sent = FonnteHelper::sendMessage($user->phone, $message);

                if (!$sent) {
                    // Jika gagal kirim, rollback transaksi agar makanan tidak berkurang
                    DB::rollBack();
                    return back()->with('error', 'Gagal mengirim notifikasi WhatsApp. Silakan coba lagi.');
                }
            }

            DB::commit();
            return redirect()->route('claims.index')->with('success', 'Klaim berhasil dibuat dan pesan WhatsApp dikirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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