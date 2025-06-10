<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdminFloodMapTest extends DuskTestCase
{
    /** @test */
    public function admin_can_access_flood_prediction_and_click_add_wilayah()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@ceban.com')->first();

            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertSee('Selamat datang')

                    // Klik tombol akses dengan ID khusus
                    ->click('#akses-prediksi-banjir')

                    ->assertPathIs('/admin/flood-maps')
                    ->assertSee('Manajemen Prediksi Wilayah Banjir')

                    // Klik tombol "Tambah Wilayah"
                    ->click('@btn-tambah-wilayah') // pastikan ada selector Dusk
                    ->assertSee('Tambah Wilayah Rawan Banjir');
        });
    }
}
