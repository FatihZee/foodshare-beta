<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteHelper
{
    public static function sendMessage($target, $message)
    {
        $token = env('FONNTE_TOKEN');

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ]);

            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['status']) && $result['status'] === true) {
                    return true;
                } else {
                    Log::error('Fonnte: Gagal mengirim pesan. Respons: ' . json_encode($result));
                    return false;
                }
            } else {
                Log::error('Fonnte: HTTP Error ' . $response->status());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Fonnte: Exception saat mengirim pesan - ' . $e->getMessage());
            return false;
        }
    }
}