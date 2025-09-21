<?php

namespace App\Notifications;

use App\Models\MagicLink;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MagicLinkNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected MagicLink $magicLink
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // TODO: Use route('magic-link.verify', ['token' => $this->magicLink->token]) once route is created
        $url = url("/magic-link/{$this->magicLink->token}");

        return (new MailMessage)
            ->subject('Your Magic Link for '.config('app.name'))
            ->greeting('Hello!')
            ->line('Click the button below to sign in to your account.')
            ->action('Sign In', $url)
            ->line('This link will expire in 15 minutes.')
            ->line('If you did not request this link, please ignore this email.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'magic_link_id' => $this->magicLink->id,
            'expires_at' => $this->magicLink->expires_at,
        ];
    }
}
