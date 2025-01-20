<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnnouncementPolicy
{
    
    public function view(User $user, Announcement $announcement)
    {
        return $user->id === $announcement->investor_id;
    }

    public function update(User $user, Announcement $announcement)
    {
        return $user->id === $announcement->investor_id;
    }

    public function delete(User $user, Announcement $announcement)
    {
        return $user->id === $announcement->investor_id;
    }
}
