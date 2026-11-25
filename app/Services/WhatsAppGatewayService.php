<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppGatewayService
{
    /**
     * Kirim pesan teks WhatsApp melalui gateway API (misalnya Fonnte).
     *
     * @param string $targetPhone Nomor telepon tujuan (format E.164 atau lokal)
     * @param string $message Konten teks pesan
     * @return array Respon terformat ['success' => bool, 'response' => array]
     */
    public function sendMessage(string $targetPhone, string $message): array
    {
        $apiUrl = config('services.whatsapp.api_url', 'https://api.fonnte.com/send');
        $apiKey = config('services.whatsapp.api_key', 'demo-fonnte-token-cilimus');

        // Jika API key dummy/testing atau di lingkungan testing tanpa mock eksternal
        if (app()->environment('testing') && !Http::recorded()) {
            return [
                'success'  => true,
                'response' => [
                    'status'  => true,
                    'target'  => $targetPhone,
                    'message' => 'Simulated WhatsApp transmission successful',
                ],
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $apiKey,
            ])->timeout(10)->post($apiUrl, [
                'target'  => $targetPhone,
                'message' => $message,
            ]);

            return [
                'success'  => $response->successful(),
                'response' => $response->json() ?? ['status' => $response->status(), 'body' => $response->body()],
            ];
        } catch (\Throwable $e) {
            Log::error('WhatsApp Gateway Error: ' . $e->getMessage(), [
                'target' => $targetPhone,
            ]);

            return [
                'success'  => false,
                'response' => [
                    'status' => false,
                    'error'  => $e->getMessage(),
                ],
            ];
        }
    }
}
