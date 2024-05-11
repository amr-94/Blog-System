<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class message extends Notification
{
    use Queueable;
    protected $tomessage;
    protected $user;
    // protected $messagetitle;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $tomessage, User $user  )
    {
        //
        $this->tomessage = $tomessage;
        $this->user = $user;
        // $this->messagetitle = $messagetitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
    public function toDatabase($notifiable)
    {
        return [
            'title' => "new message",
            'body' =>  __(':user has send message to you', [
                'user' => $this->user->name,
            ]),
            'user' => $this->user->name,
            'url' => route('user.message')

        ];
    }
}
