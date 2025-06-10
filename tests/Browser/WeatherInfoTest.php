<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class WeatherInfoTest extends DuskTestCase
{
    /** @test */
    public function user_can_access_weather_from_dashboard_and_search_city()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'user@ceban.com')->first();

            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->assertSee('Selamat datang')
                    ->clickLink('Lihat Cuaca')             
                    ->assertPathIs('/cuaca-user')            
                    ->assertSee('Informasi Cuaca')
                    ->type('search', 'Bandung City')
                    ->press('Cari')
                    ->waitForText('Bandung City', 5)
                    ->assertSee('Intensitas')
                    ->assertSee('Prakiraan Cuaca 5 Hari Kedepan');
        });
    }
}
