<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Update user status to 'aktif' when email is verified
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Verified::class,
            function ($event) {
                $user = $event->user;
                if ($user instanceof \App\Models\User) {
                    $user->status = 'aktif';
                    $user->save();
                }
            }
        );
    }
}
