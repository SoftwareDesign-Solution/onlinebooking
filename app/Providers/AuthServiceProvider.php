<?php

namespace App\Providers;

use App\Mail\ResetPasswordMail;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Mail;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
    ];

    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
            return (new VerifyMail($user, $verificationUrl))->to($user);
        });

        ResetPassword::toMailUsing(function (User $user, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));

            return (new ResetPasswordMail($url))->to($user);
        });
    }

}
