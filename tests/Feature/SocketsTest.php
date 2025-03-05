<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Movie;
use App\Models\Quote;
use App\Notifications\CommentNotification;
use App\Notifications\LikeNotification;
use Laravel\Sanctum\Sanctum;


uses(RefreshDatabase::class);

test('user receives notification when their quote is liked or commented', function () {    
    Notification::fake();

    $user1 = User::factory()->create();
    $movie = Movie::factory()->create(['user_id' => $user1->id]);
    $quote = Quote::factory()->create(['movie_id' => $movie->id]);
    
    $user2 = User::factory()->create();

    $user2->addMediaFromUrl("https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D")
		->toMediaCollection('images', 'public');

    Sanctum::actingAs($user2);

    $commentResponse = $this->postJson(route('create.comment'), [
        'quote_id' => $quote->id,
        'user_id' => $user2->id,
        'comment'  => 'Nice quote!',
    ]);

    $commentResponse->assertStatus(201); 

    $likeResponse = $this->postJson(route('like.quote'), [
        'quote_id' => $quote->id,
        'user_id' => $user2->id,
    ]);

    $likeResponse->assertStatus(201); 


    Sanctum::actingAs($user1);
    $response = $this->actingAs($user1)->getJson(route('notifications')); 

    $response->assertStatus(200);

    Notification::assertSentTo(
        [$user1], 
        CommentNotification::class, 
        function ($notification) use ($commentResponse, $user2) {
            return $notification->comment->id === $commentResponse->json('data.id') &&
                   $notification->comment->user_id === $user2->id;
        }
    );
    
    Notification::assertSentTo(
        [$user1], 
        LikeNotification::class, 
        function ($notification) use ($quote, $user2) {
            return isset($notification->like->quote) &&
                   $notification->like->quote->id === $quote->id &&
                   $notification->like->user->id === $user2->id;
        }
    );
});
