<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $apiKey;
    protected string $senderId;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey   = config('services.smsala.api_key');
        $this->senderId = config('services.smsala.sender_id');
        $this->baseUrl  = config('services.smsala.base_url');
    }

    public function send(string $mobile, string $message): array
    {
        // 🔒 1️⃣ Validate SMS configuration
        if (
            empty($this->apiKey) ||
            empty($this->baseUrl) ||
            $this->apiKey === 'your_api_key_here' ||
            empty($this->senderId)
        ) {
            Log::warning('SMS not sent. SMSala configuration missing or invalid.');

            return [
                'success' => false,
                'error'   => 'SMS configuration missing',
            ];
        }

        // 🔒 2️⃣ Optional: Prevent sending in local environment
        if (!app()->environment('production')) {
            Log::info("SMS skipped (non-production). Mobile: {$mobile}");

            return [
                'success' => false,
                'error'   => 'SMS disabled in non-production environment',
            ];
        }

        try {

            // 🔒 3️⃣ Send request with timeout protection
            $response = Http::timeout(15)->post($this->baseUrl, [
                'api_key'   => $this->apiKey,
                'sender_id' => $this->senderId,
                'mobile'    => $mobile,
                'message'   => $message,
            ]);

            // 🔒 4️⃣ Log full response
            Log::info('SMSala Response', [
                'mobile' => $mobile,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [
                'success'  => $response->successful(),
                'status'   => $response->status(),
                'response' => $response->json(),
            ];

        } catch (\Throwable $e) {

            Log::error('SMS Send Failed', [
                'mobile' => $mobile,
                'error'  => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
