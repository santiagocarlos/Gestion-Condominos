<?php

namespace App\Notifications;

use App\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class NoticePublish extends Notification
{
    use Queueable;
    protected $notice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
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
                    ->subject('Nueva noticia publicada')
                    ->line('Se ha publicado una noticia')
                    ->action('Click aquí para verla', route('owners.billboard.show', [Crypt::encrypt($this->notice->id)]))
                    ->line('Gracias por utilizar nuestra aplicación!')
                ->salutation('Saludos!');
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
            'link' => route('owners.billboard.show', [Crypt::encrypt($this->notice->id)]),
            'text' => 'Nueva noticia publicada'
        ];
    }
}
