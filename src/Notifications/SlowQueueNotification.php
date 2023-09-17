<?php

namespace BrandonJBegle\LaravelQueueMonitoring\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SlowQueueNotification extends Notification
{
    public $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $seconds = $this->seconds;
        return (new MailMessage)
            ->line('Slow Queue Alert')
            ->line("Queue processing is currently taking longer than the $seconds second monitoring period.");
    }
}
