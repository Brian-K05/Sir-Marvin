<?php

namespace App\Notifications\Admin;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentProofUploadedNotification extends Notification
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
        $phase = $this->payment->phase === 'initial' ? 'Initial' : 'Final';
        $submission = $this->payment->submission;
        
        return (new MailMessage)
                    ->subject("New {$phase} Payment Proof Uploaded")
                    ->line("A new {$phase} payment proof has been uploaded and requires verification.")
                    ->line('**Client:** ' . $submission->client_name)
                    ->line('**Service:** ' . $submission->service->name)
                    ->line('**Amount:** ₱' . number_format($this->payment->amount, 2))
                    ->line('**Reference Number:** ' . $this->payment->reference_number)
                    ->action('Review Payment', route('admin.payments.show', $this->payment->id))
                    ->line('Please verify the payment proof and approve or reject accordingly.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'phase' => $this->payment->phase,
        ];
    }
}
