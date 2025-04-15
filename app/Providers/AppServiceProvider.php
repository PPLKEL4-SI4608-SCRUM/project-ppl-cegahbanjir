<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Route;
>>>>>>> origin/sheila_editinformasicuaca

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
<<<<<<< HEAD
        //
=======

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Tambahkan ini
        Route::middleware('web')
            ->group(base_path('routes/admin.php'));
>>>>>>> origin/sheila_editinformasicuaca
    }
}
