<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BatteryLowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     protected $batteryData;
   public function __construct($batteryData)
{
    $this->batteryData = $batteryData;
}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
        ->subject('Battery AGV Lemah')
        ->line('AGV: ' . $this->batteryData->name)
        ->line('Kapasitas baterai: ' . $this->batteryData->battery . '%')
        ->action('Cek Sekarang', url('/dashboard'))
        ->line('Segera lakukan tindakan pengecekan!');
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
}
