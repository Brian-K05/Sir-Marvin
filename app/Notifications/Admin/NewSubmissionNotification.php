<?php

namespace App\Notifications\Admin;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubmissionNotification extends Notification
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
                    ->subject('New Submission Received')
                    ->line('A new submission has been received and requires your attention.')
                    ->line('**Client:** ' . $this->submission->client_name)
                    ->line('**Email:** ' . $this->submission->client_email)
                    ->line('**Service:** ' . $this->submission->service->name)
                    ->line('**Deadline:** ' . $this->submission->deadline->format('F d, Y'))
                    ->action('View Submission', route('admin.submissions.show', $this->submission->id))
                    ->line('Please review and verify the initial payment proof.');
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
            'client_name' => $this->submission->client_name,
        ];
    }
}
