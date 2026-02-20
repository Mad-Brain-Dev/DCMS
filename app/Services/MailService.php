<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ClientNotificationMail;

class MailService
{
    public function send($client, string $type, array $data = []): array
    {
        // 🔒 1️⃣ Check SMTP Configuration
        if (!$this->isMailConfigured()) {
            Log::warning('Mail not sent. SMTP configuration missing.');

            return [
                'success' => false,
                'error'   => 'Mail configuration missing'
            ];
        }

        try {

            Mail::to($client->email)
                ->send(new ClientNotificationMail($client, $type, $data));

            return [
                'success' => true
            ];

        } catch (\Throwable $e) {

            Log::error('Mail send failed', [
                'email' => $client->email,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error'   => $e->getMessage()
            ];
        }
    }

    private function isMailConfigured(): bool
    {
        return !empty(config('mail.mailers.smtp.username')) &&
            !empty(config('mail.mailers.smtp.password')) &&
            !empty(config('mail.mailers.smtp.host'));
    }
}
