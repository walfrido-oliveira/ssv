<?php

namespace App\Notifications;

use App\Models\Budget\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedBudget extends Notification implements ShouldQueue
{
    use Queueable;

    /**
	 * @var Budget
	 */
    private $budget;

    /**
     * Create a new notification instance.
     *
     * @param Budget $budget
     *
     * @return void
     */
    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
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
        $url = url(route('admin.budgets.show', ['budget' => $this->budget->id]) );

        return (new MailMessage)
                    ->subject(__('Approved Budget Notification') . ' - ' . config('app.name'))
                    ->line(__('Attention the budget of number #:number has been approved.', ['number' => $this->budget->formattedId] ))
                    ->line(__('Click in the button below and check the budget.'))
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
