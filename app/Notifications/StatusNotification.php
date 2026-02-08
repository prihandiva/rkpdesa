<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusNotification extends Notification
{
    use Queueable;

    public $status;
    public $color; // e.g., 'primary', 'warning', etc.
    public $url;
    public $modelName;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $color, $url, $modelName)
    {
        $this->status = $status;
        $this->color = $color;
        $this->url = $url;
        $this->modelName = $modelName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Status {$this->modelName} berubah menjadi {$this->status}",
            'status' => $this->status,
            'color' => $this->color,
            'url' => $this->url,
            'icon' => 'feather-activity', // Default icon
        ];
    }
}
