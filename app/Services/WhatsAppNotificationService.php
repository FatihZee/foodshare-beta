<?php

namespace App\Services;

use Twilio\Rest\Client;

class WhatsAppNotificationService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
    }

    // Fungsi untuk mengirim pesan WhatsApp
    public function sendMessage($to, $message)
    {
        try {
            $this->twilio->messages->create(
                'whatsapp:' . $to, // Tujuan nomor WhatsApp
                [
                    'from' => config('services.twilio.whatsapp_number'),
                    'body' => $message
                ]
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}