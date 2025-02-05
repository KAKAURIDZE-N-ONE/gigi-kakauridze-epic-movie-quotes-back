<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function confirmEmail(EmailVerificationRequest $request):RedirectResponse
    {
        $request->fulfill();

        return redirect('/home');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
	    
        return back()->with('message', 'Verification link sent!');
    }
}
