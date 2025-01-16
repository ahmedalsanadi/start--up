<?php
namespace App\Traits;

use App\Services\NotificationService;

trait NotificationTrait
{
    protected function sendRegistrationNotification($user)
    {
        $userTypes = [
            1 => 'Admin',
            2 => 'Investor',
            3 => 'Entrepreneur'
        ];

        app(NotificationService::class)->notifyAdmins([
            'type' => 'new_registration',
            'title' => 'New User Registration',
            'message' => "{$user->name} has registered as {$userTypes[$user->user_type]}",
            'action_type' => 'user_registration',
            'action_id' => $user->id,
            'initiator_id' => $user->id,
            'initiator_type' => 'user',
            'additional_data' => [
                'user_type' => $user->user_type
            ]
        ]);
    }

    protected function sendCommercialRegistrationNotification($registration)
    {
        app(NotificationService::class)->notifyAdmins([
            'type' => 'commercial_registration',
            'title' => 'New Commercial Registration',
            'message' => "New commercial registration request submitted",
            'action_type' => 'commercial_registration',
            'action_id' => $registration->id,
            'initiator_id' => $registration->user_id,
            'initiator_type' => 'investor',
            'additional_data' => [
                'registration_number' => $registration->registration_number
            ],
        ]);
    }

    protected function sendIdeaPostNotification($idea, $targetInvestors)
    {
        app(NotificationService::class)->notifySpecificUsers($targetInvestors, [
            'type' => 'new_idea',
            'title' => 'New Business Idea Posted',
            'message' => "A new business idea has been posted that might interest you",
            'action_type' => 'idea_post',
            'action_id' => $idea->id,
            'initiator_id' => $idea->user_id,
            'initiator_type' => 'entrepreneur',
            'action_url' => route('ideas.show', $idea->id),
        ]);
    }
}
