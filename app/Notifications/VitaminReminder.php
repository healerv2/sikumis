<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Illuminate\Contracts\Queue\ShouldQueue;

class VitaminReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $body,
        public string $url = '/'
    ) {}

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    // public function toWebPush($notifiable, $notification)
    // {
    //     return (new WebPushMessage)
    //         ->title($this->title)
    //         ->body($this->body)
    //         ->icon('/icons/icon-192x192.png')
    //         ->badge('/icons/icon-192x192.png')
    //         ->action('Lihat Jadwal', $this->url)
    //         ->data(['url' => $this->url]);
    // }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('/icons/icon-192x192.png')
            ->body($this->body)
            ->data(['url' => $this->url])
            ->action('Lihat', $this->url);
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url
        ];
    }
}
