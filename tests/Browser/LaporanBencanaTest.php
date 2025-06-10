<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LaporanBencanaTest extends DuskTestCase
{
    public function test_user_can_submit_disaster_report()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'user@ceban.com')->first(); // pastikan user ini ada

            $browser->loginAs($user)
                ->visit('/laporan')
                ->pause(1000)
                ->type('location', 'Cipinang, Jakarta Timur')
                ->type('description', 'Hujan deras menyebabkan genangan di jalan utama')
                ->attach('disaster_image', storage_path('app/tests/sample.png'))
                ->press('Simpan Laporan')
                ->waitForText('Riwayat Laporan')
                ->assertSee('Hujan deras menyebabkan genangan di jalan utama');
        });
    }
}
