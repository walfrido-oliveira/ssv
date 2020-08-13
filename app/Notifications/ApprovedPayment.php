<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Billing\Billing;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedPayment extends Notification implements ShouldQueue
{
    use Queueable;

    /**
	 * @var Billing
	 */
    private $billing;

    /**
     * Create a new notification instance.
     *
     * @param Billing $billing
     *
     * @return void
     */
    public function __construct(Billing $billing)
    {
        $this->billing = $billing;
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
        $url = url(route('user.billings.show', ['billing' => $this->billing->id]) );

        return (new MailMessage)
                    ->subject(__('Payment Notification') . ' - #' . $this->billing->formattedId . ' - ' . config('app.name'))
                    ->line(__('The billing of number #:number has been payment approved.', ['number' => $this->billing->formattedId] ))
                    ->line(__('Click in the button below and check the billing.'))
                    ->action(__('Check'), $url);
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
