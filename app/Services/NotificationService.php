<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\User;

class NotificationService
{
    public function send(User $user, string $title, string $message, string $type = 'info', ?string $link = null): AppNotification
    {
        return AppNotification::create([
            'user_id' => $user->id,
            'title'   => $title,
            'message' => $message,
            'type'    => $type,
            'link'    => $link,
        ]);
    }

    public function sendToAll(string $title, string $message, string $type = 'info'): void
    {
        User::chunk(100, function ($users) use ($title, $message, $type) {
            foreach ($users as $user) {
                $this->send($user, $title, $message, $type);
            }
        });
    }

    public function markAllRead(User $user): void
    {
        $user->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);
    }
}
