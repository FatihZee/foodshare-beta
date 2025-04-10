<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Donation;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helpers\FonnteHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\ClaimMessageHelper;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        $pending = Claim::where('status', 'pending')->count();
        $collected = Claim::where('status', 'collected')->count();
        $cancelled = Claim::where('status', 'cancelled')->count();

        $claimsPerDay = Claim::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('claims.index', compact('claims', 'pending', 'collected', 'cancelled', 'claimsPerDay'));
    }

    public function create()
    {
        $userId = auth()->id();

        $donations = Donation::where('status', 'available')
            ->with(['claims' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->latest();
            }])
            ->get();

        return view('claims.create', compact('donations'));
    }
  
    public function store(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'phone' => auth()->check() ? 'nullable' : 'required|string|max:15',
        ]);        

        DB::beginTransaction();
        try {
            $donation = Donation::findOrFail($request->donation_id);

            if ($donation->quantity <= 0) {
                return back()->with('error', 'Makanan sudah habis!');
            }

            $queueNumber = Claim::where('donation_id', $donation->id)->count() + 1;

            $name = '';
            $phone = '';
            $userId = null;

            if (auth()->check()) {
                $userId = auth()->id();
                $name = auth()->user()->name;
                $phone = auth()->user()->phone;
            } else {
                $phone = $request->phone;

                $existingUser = User::where('phone', $phone)->first();

                if (!$existingUser) {
                    $randomSuffix = Str::random(6);
                    $generatedName = 'Guest ' . strtoupper(substr($randomSuffix, 0, 4));

                    $existingUser = User::create([
                        'name' => $generatedName,
                        'email' => 'guest_' . time() . '_' . $randomSuffix . '@example.com',
                        'password' => bcrypt(Str::random(10)),
                        'role' => 'user',
                        'phone' => $phone,
                        'profilePicture' => null,
                    ]);
                }

                $userId = $existingUser->id;
                $name = $existingUser->name;
            }

            $claim = Claim::create([
                'user_id' => $userId,
                'name' => $name,
                'phone' => $phone,
                'donation_id' => $donation->id,
                'queue_number' => $queueNumber,
            ]);

            $donation->decrement('quantity');

            if ($donation->quantity <= 0) {
                $donation->update(['status' => 'completed']);
            }

            if ($phone) {
                $message = ClaimMessageHelper::generateClaimMessage($name, $donation, $queueNumber);
                $shortNotif = NotificationHelper::formatShortNotification($name, $donation, $queueNumber);
                $sent = FonnteHelper::sendMessage($phone, $message);

                Notification::create([
                    'user_id' => $userId,
                    'claim_id' => $claim->id,
                    'phone' => $phone,
                    'message' => $shortNotif,
                    'is_sent' => $sent,
                    'is_read' => false,
                ]);

                if (!$sent) {
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
    
    public function donationClaims(Donation $donation)
    {
        Log::info('Current User ID: ' . Auth::id());
        Log::info('Donation User ID: ' . $donation->user_id);

        if (Auth::id() !== $donation->donor_id) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke donasi ini.');
        }

        $claims = Claim::with('user')->where('donation_id', $donation->id)->get();
        return view('claims.donation_claims', compact('donation', 'claims'));
    }
    
    public function approve(Claim $claim)
    {
        if (Auth::id() !== $claim->donation->donor_id) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menyetujui klaim ini.');
        }

        $claim->update(['status' => 'collected']);
        return back()->with('success', 'Klaim telah disetujui!');
    }
    
    public function reject(Claim $claim)
    {
        if (Auth::id() !== $claim->donation->donor_id) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menolak klaim ini.');
        }

        $claim->update(['status' => 'cancelled']);
        return back()->with('success', 'Klaim telah ditolak.');
    }
}