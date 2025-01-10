<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ClinicInfo;

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
        Paginator::useBootstrapFive();

        // $clinic = ClinicInfo::with('image')->first();
        // $logoPath = $clinic->image ? asset('storage/' . $clinic->image->image_path) : asset('assets/img/logo.png');

        // $clinicName = $clinic->name;

        // View::share('clinicName', $clinicName);
        // View::share('logoPath', $logoPath);
    }
}