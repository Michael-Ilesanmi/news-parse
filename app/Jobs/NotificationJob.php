<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chat_id;
    private $text;
    /**
     * Create a new job instance.
     */
    public function __construct($chat_id, $text)
    {
        $this->chat_id = $chat_id;
        $this->text = $text;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Telegram::sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $this->text,
            'parse_mode'=>'html'
        ]);
        return;
    }
}
