<?php

namespace App\Providers;

use App\Models\Feedback;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        View::composer(['components.admin.*', 'layouts.admin', 'admin.*'], function ($view) {
            try {
                if (Schema::hasTable('feedbacks')) {
                    $view->with('unreadFeedbackCount', Feedback::where('status', 'baru')->count());
                }
            } catch (\Throwable $e) {
                $view->with('unreadFeedbackCount', 0);
            }
        });
    }
}
