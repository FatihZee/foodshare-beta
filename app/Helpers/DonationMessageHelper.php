<?php

namespace App\Helpers;

class DonationMessageHelper
{
    public static function generateDonationMessage($donation)
    {
        $donorName = $donation->donor ? $donation->donor->name : $donation->donor_name;

        return "🙏 [FoodShare] Terima Kasih Telah Berdonasi! 🙏\n"
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "Halo {$donorName}, terima kasih atas kebaikan Anda! 🎁\n"
            . "🍴 *Makanan:* {$donation->food_name}\n"
            . "📍 *Lokasi:* {$donation->location}\n"
            . "⏳ *Berlaku Sampai:* {$donation->expiration}\n"
            . (!empty($donation->maps) ? "🗺️ *Peta:* {$donation->maps}\n" : "")
            . "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n"
            . "✅ Donasi Anda sekarang tersedia di platform FoodShare. Semoga bermanfaat bagi mereka yang membutuhkan! 🙌\n"
            . "#FoodShare #BerbagiItuPeduli";
    }
}