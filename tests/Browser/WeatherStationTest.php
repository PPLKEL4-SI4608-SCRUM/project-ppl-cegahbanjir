<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\WeatherStation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WeatherStationTest extends DuskTestCase
{
    /**
     * Test Manajemen Stasiun Cuaca.
     */
    public function test_weather_station_management()
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

            // Tambah Stasiun Cuaca
            $browser->clickLink('Tambah Stasiun')
                ->assertPathIs('/admin/weather/stations/create')
                ->type('name', 'Stasiun Uji Dusk')
                ->type('location', 'Bandung')
                ->pause(7000) // untuk pastikan muncul
                ->click('#location-suggestions > div:first-child') // klik suggestion pertama
                ->select('status', 'active')
                ->press('Simpan')
                ->assertPathIs('/admin/weather/stations')
                ->assertSee('Stasiun Uji Dusk');

            // Edit Stasiun Cuaca
            $station = WeatherStation::where('name', 'Stasiun Uji Dusk')->first();
            $browser->visit('/admin/weather/stations')
                ->click("a[href='http://127.0.0.1:8000/admin/weather/stations/1/edit']")
                ->assertSee('Edit Stasiun Cuaca')
                ->type('name', 'Stasiun Uji Edit')
                ->type('location', 'Jakarta')
                ->pause(7000)
                ->click('#location-suggestions > div:first-child')
                ->select('status', 'maintenance')
                ->press('Simpan')
                ->assertPathIs('/admin/weather/stations')
                ->assertSee('Stasiun Uji Edit');

            // Hapus Stasiun Cuaca
            $browser->visit('/admin/weather/stations')
                ->with("tr:contains('Stasiun Uji Edit')", function ($row) {
                    $row->with('td:last-child', function ($td) {
                        $td->within('form', function ($form) {
                            $form->press('button[type="submit"]');
                        });
                    });
                })
                ->whenAvailable('.swal2-container', function ($modal) {
                    $modal->press('OK');
                })
                ->pause(1000)
                ->assertDontSee('Stasiun Uji Edit');
        });
    }
}
