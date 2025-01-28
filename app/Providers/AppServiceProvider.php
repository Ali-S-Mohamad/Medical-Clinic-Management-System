<?php

namespace App\Providers;

use App\Models\ClinicInfo;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Observers\AppointmentObserver;
use Illuminate\Support\Facades\Schema;
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
        Paginator::useBootstrapFive();


       // Check if the database connection is available
       try {
        DB::connection()->getPdo();

        // Check if the 'clinic_info' table exists
        if (Schema::hasTable('clinic_info')) {

            $clinic = ClinicInfo::with('image')->first();

            if ($clinic) {

                $logoPath = $clinic->image ? asset('storage/' . $clinic->image->image_path) : asset('assets/img/logo.png');
                $clinicName = $clinic->name;

                View::share('clinicName', $clinicName);
                View::share('logoPath', $logoPath);
            } else {
                // Default values if the table does not exist
                View::share('clinicName', 'MediCore Clinic');
                View::share('logoPath', asset('assets/img/logo.png'));
            }
        }
    } catch (\Exception $e) {

        // If there is no database connection, set default values
        View::share('clinicName', 'MediCore Clinic');
        View::share('logoPath', asset('assets/img/logo.png'));
    }

        Appointment::observe(AppointmentObserver::class);
    }


}
