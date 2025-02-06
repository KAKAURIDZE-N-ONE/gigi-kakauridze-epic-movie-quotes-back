<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
			$frontendUrl = config('app.frontend_url');
			$appUrl = config('app.url');
			$replacedUrl = str_replace($appUrl . '/api', $frontendUrl, $url);

			return (new MailMessage)
			->subject('Please Verify Your Email Address')
			->view('emails.verify-email', ['verificationUrl' => $replacedUrl]);
		});
	}
}
