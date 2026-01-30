<?php

namespace App\Notifications;

use App\Models\Request as ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusUpdatedNotification extends Notification
{
    use Queueable;

    public $serviceRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
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
        $status = ucfirst($this->serviceRequest->status);
        $workerName = $this->serviceRequest->worker->name;

        return [
            'request_id' => $this->serviceRequest->id,
            'message' => "Your request to {$workerName} has been {$status}",
            'action_url' => route('dashboard'),
            'type' => 'status_update'
        ];
    }
}
