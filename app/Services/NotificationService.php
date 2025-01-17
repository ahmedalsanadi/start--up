<?php
namespace App\Services;

use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class NotificationService
{
    public function notify($recipients, array $data)
    {
        if ($recipients instanceof User) {
            $recipients->notify(new GeneralNotification($data));
        } elseif (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                if ($recipient instanceof User) {
                    $recipient->notify(new GeneralNotification($data));
                }
            }
        } else {
            foreach ($recipients as $recipient) {
                $recipient->notify(new GeneralNotification($data));
            }
        }
    }

    public function notifyAdmins($data)
    {
        $admins = User::where('user_type', 1)->get();
        foreach ($admins as $admin) {
            $this->notify($admin, $data);
        }
    }

    public function notifyInvestors($data)
    {
        $investors = User::where('user_type', 2)->get();
        foreach ($investors as $investor) {
            $this->notify($investor, $data);
        }
    }

    public function notifyEntrepreneurs($data)
    {
        $entrepreneurs = User::where('user_type', 3)->get();
        foreach ($entrepreneurs as $entrepreneur) {
            $this->notify($entrepreneur, $data);
        }
    }

    public function notifySpecificUsers($userIds, $data)
    {
        $users = User::whereIn('id', (array)$userIds)->get();
        foreach ($users as $user) {
            $this->notify($user, $data);
        }
    }
}
