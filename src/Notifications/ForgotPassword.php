<?php

namespace Kluverp\Pcmn\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPassword extends Notification
{
    use Queueable;

    /**
     * Reset token.
     *
     * @var string
     */
    private $token = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('pcmn::notifications.pw_forgotten.subject'))
            ->greeting(__('pcmn::notifications.pw_forgotten.greeting'))
            ->line(__('pcmn::notifications.pw_forgotten.line_1'))
            ->action(__('pcmn::notifications.pw_forgotten.button'), route('pcmn.auth.reset', $this->token))
            ->line(__('pcmn::notifications.pw_forgotten.line_2'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
