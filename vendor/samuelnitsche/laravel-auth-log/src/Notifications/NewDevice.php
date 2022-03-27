<?php

namespace SamuelNitsche\AuthLog\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use SamuelNitsche\AuthLog\AuthLog;

class NewDevice extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The authentication log.
     *
     * @var AuthLog
     */
    public $authLog;

    /**
     * Create a new notification instance.
     *
     * @param AuthLog $authLog
     */
    public function __construct(AuthLog $authLog)
    {
        $this->authLog = $authLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notifyAuthenticationLogVia();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('auth-log::messages.subject', ['app' => config('app.name')]))
            ->markdown('auth-log::emails.new', [
                'account' => $notifiable,
                'content' => trans('auth-log::messages.content', ['app' => config('app.name')]),
                'time' => $this->authLog->login_at,
                'ipAddress' => $this->authLog->ip_address,
                'platform' => $this->authLog->platform,
                'browser' => $this->authLog->browser,
            ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from(config('app.name'))
            ->warning()
            ->content(trans('auth-log::messages.content', ['app' => config('app.name')]))
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment->fields([
                    'Account' => $notifiable->email,
                    'Time' => $this->authLog->login_at->toCookieString(),
                    'IP Address' => $this->authLog->ip_address,
                    'Platform' => $this->authLog->platform,
                    'Browser' => $this->authLog->browser,
                ]);
            });
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content(trans('auth-log::messages.content', ['app' => config('app.name')]));
    }
}
