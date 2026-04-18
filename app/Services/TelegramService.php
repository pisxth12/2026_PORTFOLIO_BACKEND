<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TelegramService
{
    protected $token;
    protected $chatId;

    public function __construct()
    {
        $this->token = config('services.telegram.token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function sendMessage($name, $email, $subject, $message)
    {
        if (!$this->token || !$this->chatId) {
            Log::warning('Telegram credentials not configured');
            return false;
        }

        $text = "📬 <b>New Contact Message</b>\n\n";
        $text .= "<b>Name:</b> {$name}\n";
        $text .= "<b>Email:</b> {$email}\n";
        $text .= "<b>Subject:</b> {$subject}\n\n";
        $text .= "<b>Message:</b>\n{$message}";

        $response = Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ]);

        return $response->successful();
    }
}
