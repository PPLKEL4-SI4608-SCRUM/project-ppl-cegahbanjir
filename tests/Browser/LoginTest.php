<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\WeatherStation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_login()
    {
        $this->browse(function (Browser $browser) {
            // Login
            $admin = User::where('email', 'admin@ceban.com')->first();

            $browser->loginAs($admin)
                ->visit('/admin/dashboard')
                ->pause(1500)
                ->assertSee('Manajemen Data Cuaca');

            // Akses halaman Manajemen Stasiun Cuaca via dusk selector
            $browser->click('@akses-stasiun-cuaca')
                ->assertPathIs('/admin/weather/stations')
                ->assertSee('Manajemen Stasiun Cuaca');

        });
    }
}
