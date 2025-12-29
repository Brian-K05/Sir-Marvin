<?php

namespace App\Notifications\Client;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkCompletedNotification extends Notification
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
        $finalAmount = $this->submission->service->price - $this->submission->service->initial_payment_amount;
        
        return (new MailMessage)
                    ->subject('Work Completed - Final Payment Required')
                    ->greeting('Hello ' . $this->submission->client_name . ',')
                    ->line('Great news! We have completed the work on your document.')
                    ->line('**Service:** ' . $this->submission->service->name)
                    ->line('Your corrected document is ready. To download it, please complete the final payment.')
                    ->line('**Final Payment Amount:** ₱' . number_format($finalAmount, 2))
                    ->action('Upload Final Payment', route('submissions.show', $this->submission->id))
                    ->line('Once your final payment is verified and approved, you will be able to download your corrected document.')
                    ->line('Thank you for your patience!');
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
