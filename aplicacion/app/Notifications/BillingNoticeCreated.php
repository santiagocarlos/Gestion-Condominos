<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class BillingNoticeCreated extends Notification
{
    protected $owner;
    protected $billing_notices;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($owner, $billing_notices)
    {
        $this->owner = $owner;
        $this->billing_notices = $billing_notices;
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
                    ->subject('Nuevo Recibo de Condominio')
                    ->line('Se ha generado un nuevo recibo de cobro.')
                    ->action('Click aqui para ver el recibo', route('owners.billing-notices.showFromOwner', [Crypt::encrypt($this->billing_notices->id), Crypt::encrypt($this->owner->id)]))
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
            'link' => route('owners.billing-notices.showFromOwner', [Crypt::encrypt($this->billing_notices->id), Crypt::encrypt($this->owner->id)]),
            'text' => 'Nuevo Recibo de Condominio'
        ];
    }
}
