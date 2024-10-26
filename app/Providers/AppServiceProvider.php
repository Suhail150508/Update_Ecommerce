<?php

namespace App\Providers;

use App\Models\ActivityLog;
use Illuminate\Support\ServiceProvider;
use Brian2694\Toastr\ToastrServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ToastrServiceProvider::class;
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Define the logActivity function
         if (!function_exists('logActivity')) {

            function logActivity($action, $subject = null, $properties = [])
            {
                ActivityLog::create([
                    // 'user_id' => auth()->check() ? auth()->user()->id : null, 
                    'user_id' => 1, 
                    'action' => $action, // Log the action performed
                    'subject_type' => $subject ? get_class($subject) : null, // Model type (e.g., Task)
                    'subject_id' => $subject ? $subject->id : null, // Model ID (e.g., Task ID)
                    'properties' => $properties, // Any extra data to log
                ]);
            }
        }
    }
}
