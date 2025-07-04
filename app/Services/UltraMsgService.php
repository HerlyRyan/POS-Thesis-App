<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UltraMsgService
{
    protected $instanceId;
    protected $token;

    public function __construct()
    {
        $this->instanceId = env('ULTRAMSG_INSTANCE_ID');
        $this->token = env('ULTRAMSG_TOKEN');
    }

    public function sendMessage($phone, $message)
    {
        $url = "https://api.ultramsg.com/{$this->instanceId}/messages/chat";

        $response = Http::get($url, [
            'token' => $this->token,
            'to' => $phone,
            'body' => $message,
        ]);

        return $response->successful();
    }
}
