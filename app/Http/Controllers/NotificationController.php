<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notif = Notification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notif->update([
            'is_read' => 1
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}