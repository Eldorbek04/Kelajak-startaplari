<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\ProjectSubmission;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SmsService::class, function (): SmsService {
            return new SmsService(
                baseUrl: (string) config('sms.api_base_url'),
                apiKey: (string) config('sms.api_key'),
                defaultFrom: (string) config('sms.default_from'),
                verifySsl: (bool) config('sms.verify_ssl'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('region_admin', function (string $value): User {
            return User::query()
                ->whereKey($value)
                ->where('role', User::ROLE_REGION_ADMIN)
                ->firstOrFail();
        });

        View::composer('layouts.panel', function (\Illuminate\View\View $view): void {
            $hasSubmission = false;
            if (Auth::check()) {
                $hasSubmission = ProjectSubmission::query()
                    ->where('user_id', Auth::id())
                    ->exists();
            }
            $view->with('userHasApplicationSubmission', $hasSubmission);
        });
    }
}
