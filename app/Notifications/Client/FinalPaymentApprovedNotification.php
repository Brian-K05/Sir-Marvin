<?php

namespace App\Notifications\Client;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinalPaymentApprovedNotification extends Notification
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
                    ->subject('Final Payment Approved - Document Ready for Download')
                    ->greeting('Hello ' . $this->submission->client_name . ',')
                    ->line('Your final payment has been verified and approved!')
                    ->line('**Service:** ' . $this->submission->service->name)
                    ->line('Your corrected document is now ready for download.')
                    ->action('Download Corrected Document', route('submissions.download', $this->submission->id))
                    ->line('Thank you for your business! We hope you are satisfied with our service.')
                    ->line('If you have any questions or need further assistance, please don\'t hesitate to contact us.');
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
