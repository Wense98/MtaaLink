<?php

namespace App\Notifications;

use App\Models\JobBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BidAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    public $bid;

    /**
     * Create a new notification instance.
     */
    public function __construct(JobBid $bid)
    {
        $this->bid = $bid;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Congratulations! Your bid for "' . $this->bid->job->title . '" has been accepted.',
            'url' => route('jobs.show', $this->bid->public_job_id),
            'type' => 'bid_accepted'
        ];
    }
}
