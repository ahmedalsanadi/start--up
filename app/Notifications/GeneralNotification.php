<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class GeneralNotification extends Notification
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->data['type'] ?? 'general',
            'title' => $this->data['title'] ?? '',
            'message' => $this->data['message'] ?? '',
            'action_type' => $this->data['action_type'] ?? null,
            'action_id' => $this->data['action_id'] ?? null,
            'action_url' => $this->data['action_url'] ?? null,
            'initiator_id' => $this->data['initiator_id'] ?? null,
            'initiator_type' => $this->data['initiator_type'] ?? null,
            'additional_data' => $this->data['additional_data'] ?? [],
        ];
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}
