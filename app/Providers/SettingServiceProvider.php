<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $settings = null;
        try {
            if (Schema::hasTable('settings')) {
                $settings = Setting::find(1);
            }
        } catch (\Exception $e) {
            $settings = null;
        }

        view()->share('settings', $settings);
    }
}
