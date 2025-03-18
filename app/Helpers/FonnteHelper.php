<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class FonnteHelper
{
    public static function sendMessage($target, $message)
    {
        $token = env('FONNTE_TOKEN'); // Ambil token dari .env

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
            'countryCode' => '62', // Opsional
        ]);

        return $response->json();
    }
}