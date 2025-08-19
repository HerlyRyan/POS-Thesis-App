<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $apiKey;
    protected $url;

    public function __construct()
    {
        $this->apiKey = env('FONNTE_TOKEN');
        $this->url = 'https://api.fonnte.com/send';
    }

    public function sendMessage(string $targetPhone, string $message): array
    {
        // Hapus spasi ganda, termasuk spasi tab dan newline berlebih
        $cleanedMessage = preg_replace('/[ \t]+/', ' ', $message); // Hilangkan tab atau spasi berlebih
        $cleanedMessage = preg_replace('/\s*\n\s*/', "\n", $cleanedMessage); // Rapikan newline
        $cleanedMessage = trim($cleanedMessage);

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->post($this->url, [
            'target' => $targetPhone,
            'message' => $cleanedMessage,
            'countryCode' => '62'
        ]);

        return $response->json();
    }
}
