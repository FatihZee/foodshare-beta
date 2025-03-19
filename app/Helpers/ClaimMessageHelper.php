<?php

namespace App\Helpers;

class ClaimMessageHelper
{
    public static function generateClaimMessage($user, $donation, $queueNumber)
    {
        return "🎉 [FoodShare] Terima Kasih Telah Menggunakan Layanan Kami! 🎉\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "Halo {$user->name}, selamat! Klaim makanan Anda telah BERHASIL! 🍽️✨\n"
            . "🍴 *Makanan:* {$donation->food_name}\n"
            . "🔢 *No. Antrean:* {$queueNumber}\n"
            . "📍 *Lokasi:* {$donation->location}\n"
            . "⏳ *Ambil Sebelum:* {$donation->expiration}\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "✅ Mohon datang tepat waktu dan tunjukkan nomor antrean Anda kepada petugas.\n"
            . "🙏 Terima kasih telah menjadi bagian dari FoodShare! Tetap berbagi dan sebarkan kebaikan! ❤️\n"
            . "#FoodShare #BerbagiItuPeduli";
    }
}