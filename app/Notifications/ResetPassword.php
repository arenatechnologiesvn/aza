<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as Notification;

class ResetPassword extends Notification
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Bạn nhận được email này vì bạn yêu cầu được đổi mật khẩu mới')
            ->action('Reset Password', url(config('app.url').'/#/reset?token='.$this->token).'&email='.urlencode($notifiable->email))
            ->line('If you did not request a password reset, no further action is required.');
    }
}
