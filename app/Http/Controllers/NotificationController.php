<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function notifications(Request $request) : JsonResponse
	{
		$notifications = $request->user()
        ->notifications()
		->with('sender')
		->get();

		return response()->json(NotificationResource::collection($notifications));
	}

	public function markAllNotificationsAsRead() : JsonResponse
	{
		Auth::user()->unreadNotifications->markAsRead();
		return response()->json(['message' => 'All notifications marked as read']);
	}

	public function markNotificationAsRead($id) : JsonResponse
	{
		$notification = Auth::user()->notifications()->find($id);

		if ($notification) {
			$notification->markAsRead();
			return response()->json(['message' => 'Notification marked as read']);
		}

		return response()->json(['message' => 'Notification not found'], 404);
	}
}
