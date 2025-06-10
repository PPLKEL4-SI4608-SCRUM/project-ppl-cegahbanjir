<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\FloodMap;

class AdminFloodMapDeleteTest extends DuskTestCase
{
    /** @test */
    public function admin_can_access_flood_prediction_and_click_delete_wilayah()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@ceban.com')->first();
            $floodMap = FloodMap::first();

            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertSee('Selamat datang')
                    ->click('#akses-prediksi-banjir')
                    ->assertPathIs('/admin/flood-maps')
                    ->assertSee('Manajemen Prediksi Wilayah Banjir')
                    ->click('@btn-delete-wilayah-' . $floodMap->id)
                    ->pause(1000); // biar nggak terlalu cepat exit
        });
    }
}
