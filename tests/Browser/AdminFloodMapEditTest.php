<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\FloodMap;

class AdminFloodMapEditTest extends DuskTestCase
{
    /** @test */
    public function admin_can_access_flood_prediction_and_click_edit_wilayah()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@ceban.com')->first();
            $floodMap = FloodMap::first();

            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->click('#akses-prediksi-banjir')
                    ->assertPathIs('/admin/flood-maps')
                    ->assertSee('Manajemen Prediksi Wilayah Banjir')
                    ->click('@btn-edit-wilayah-' . $floodMap->id)
                    ->assertPathIs('/admin/flood-maps/' . $floodMap->id . '/edit')
                    ->assertSee('Edit Wilayah Rawan Banjir');
        });
    }
}
