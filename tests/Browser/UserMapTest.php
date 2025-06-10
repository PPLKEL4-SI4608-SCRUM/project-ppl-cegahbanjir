<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserFloodMapTest extends DuskTestCase
{
    /** @test */
    public function user_can_access_flood_map_and_search_bandung_city()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'user@ceban.com')->first();

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->assertSee('Selamat datang, User CeBan!')
                ->clickLink('Akses Peta')
                ->assertPathIs('/map')
                ->assertSee('Peta Rawan Banjir')
                ->type('search', 'Bandung City')
                ->press('Cari')
                ->waitForText('Bandung City')
                ->assertSee('Titik Pantau Banjir');
        });
    }
}
