<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $news;
    /**
     * Create a new job instance.
     */
    public function __construct($news)
    {
        $this->news = $news;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle(): void
    {
        $title = $this->news->title;
        $description = $this->news->description;
        $link = $this->news->link;
        $formattedMessage = "<b>$title </b> $description <a href='$link'>Read more...</a>";
        $chat_ids = $this->getChatIDs();
        foreach ($chat_ids as $chat_id) {
            NotificationJob::dispatch($chat_id, $formattedMessage);
        }
    }

    /**
     * Fetch ChatIDs of all users interacted with the bot
     */
    public function getChatIDs (): Object 
    {
        $ids = Cache::remember('telegram_bot_chat_ids', 600, function () {
            $updates = Telegram::getUpdates();
            $data = collect($updates);
            return $data->pluck('message.chat.id');
        });
        return $ids->unique();
    }
}
