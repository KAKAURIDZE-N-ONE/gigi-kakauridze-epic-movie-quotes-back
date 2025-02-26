<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function notifications(Request $request)
	{
		return response()->json($request->user()->notifications);
	}

	public function markAllNotificationsAsRead()
	{
		Auth::user()->unreadNotifications->markAsRead();
		return response()->json(['message' => 'All notifications marked as read']);
	}

	public function markNotificationAsRead($id)
	{
		$notification = Auth::user()->notifications()->find($id);

		if ($notification) {
			$notification->markAsRead();
			return response()->json(['message' => 'Notification marked as read']);
		}

		return response()->json(['message' => 'Notification not found'], 404);
	}
}
