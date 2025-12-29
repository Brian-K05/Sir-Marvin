<?php

namespace App\Notifications\Client;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InitialPaymentApprovedNotification extends Notification
{
    use Queueable;

    public $submission;

    /**
     * Create a new notification instance.
     */
    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
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
        return (new MailMessage)
                    ->subject('Initial Payment Approved - Work in Progress')
                    ->greeting('Hello ' . $this->submission->client_name . ',')
                    ->line('Great news! Your initial payment has been verified and approved.')
                    ->line('**Service:** ' . $this->submission->service->name)
                    ->line('**Deadline:** ' . $this->submission->deadline->format('F d, Y'))
                    ->line('We have now begun working on your document. You will be notified once the work is completed and ready for your review.')
                    ->action('View Submission Status', route('submissions.show', $this->submission->id))
                    ->line('Thank you for choosing our services!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
        ];
    }
}
