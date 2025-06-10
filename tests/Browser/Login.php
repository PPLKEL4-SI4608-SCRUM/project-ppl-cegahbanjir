<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\WeatherStation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Login extends DuskTestCase
{
    public function login_test()
    {
        $this->browse(function (Browser $browser) {
            // Login
            $browser->visit('/login')
                ->type('email', 'admin@ceban.com')
                ->type('password', 'admin123')
                ->press('Login')
                ->assertPathIs('/admin/dashboard');

            // Akses halaman Manajemen Stasiun Cuaca via dusk selector
            $browser->click('@akses-stasiun-cuaca')
                ->assertPathIs('/admin/weather/stations')
                ->assertSee('Manajemen Stasiun Cuaca');

        });
    }
}
