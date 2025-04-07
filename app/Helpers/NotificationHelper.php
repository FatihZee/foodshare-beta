<?php

namespace App\Helpers;

class NotificationHelper
{
    public static function formatShortNotification($user, $donation, $queueNumber)
    {
        $name = is_object($user) ? $user->name : $user;

        return "🎟️ {$name}, antrean #{$queueNumber} untuk *{$donation->food_name}* berhasil!";
    }
}