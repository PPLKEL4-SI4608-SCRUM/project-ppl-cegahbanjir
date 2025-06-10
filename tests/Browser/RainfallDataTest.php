<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\WeatherStation;
use App\Models\RainfallData;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RainfallDataTest extends DuskTestCase
{
    /**
     * Test Manajemen Data Curah Hujan.
     */
    public function test_rainfall_data_management()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            $browser->loginAs($admin)
                ->visit('/admin/dashboard')
                ->pause(1500)
                ->assertSee('Manajemen Data Cuaca');

            // Akses halaman Manajemen Data Curah Hujan
            $browser->click('@akses-data-rainfall') // Sesuaikan dengan dusk selector yang ada
                ->assertPathIs('/admin/weather/rainfall')
                ->assertSee('Manajemen Data Curah Hujan');

            // Pastikan ada stasiun cuaca untuk testing
            $station = WeatherStation::first();
            if (!$station) {
                $station = WeatherStation::create([
                    'name' => 'Stasiun Test',
                    'location' => 'Bandung Test',
                    'latitude' => -6.9175,
                    'longitude' => 107.6191,
                    'status' => 'active'
                ]);
            }

            // Test Filter Stasiun - Pilih stasiun cuaca
            $browser->select('station_id', $station->id)
                ->pause(2000) // Tunggu form submit otomatis
                ->assertSee($station->name)
                ->assertSee('Data Curah Hujan');

            // Test Tambah Data Manual
            $browser->clickLink('Tambah Data Manual')
                ->assertPathIs('/admin/weather/rainfall/create')
                ->assertSee('Tambah Data Curah Hujan')
                ->select('weather_station_id', $station->id)
                ->type('recorded_at', now()->format('Y-m-d'))
                ->select('data_source', 'manual')
                ->type('rainfall_amount', '15.5')
                ->type('intensity', '0.65')
                ->press('Simpan')
                ->assertPathIs('/admin/weather/rainfall')
                ->assertSee('Data curah hujan berhasil ditambahkan'); // Sesuaikan dengan pesan success

            // Kembali ke halaman index dengan filter stasiun
            $browser->visit('/admin/weather/rainfall')
                ->select('station_id', $station->id)
                ->pause(2000);

            // Test Edit Data Curah Hujan
            $rainfallData = RainfallData::where('weather_station_id', $station->id)
                ->where('rainfall_amount', 15.5)
                ->first();

            if ($rainfallData) {
                $browser->click("a[href*='/admin/weather/rainfall/{$rainfallData->id}/edit']")
                    ->assertSee('Edit Data Curah Hujan')
                    ->assertValue('rainfall_amount', '15.5')
                    ->clear('rainfall_amount')
                    ->type('rainfall_amount', '25.8')
                    ->clear('intensity')
                    ->type('intensity', '1.08')
                    ->select('category', 'tinggi')
                    ->press('Simpan Perubahan')
                    ->assertPathIs('/admin/weather/rainfall')
                    ->assertSee('Data curah hujan berhasil diperbarui'); // Sesuaikan dengan pesan success
            }

            // Test Update Kategori dari halaman index
            $browser->visit('/admin/weather/rainfall')
                ->select('station_id', $station->id)
                ->pause(2000);

            // Cari dropdown kategori pertama dan ubah nilainya
            $browser->script([
                'document.querySelector(".category-select").value = "sangat_tinggi";',
                'document.querySelector(".category-select").dispatchEvent(new Event("change"));'
            ]);

            $browser->pause(1000)
                ->press('Simpan Perubahan')
                ->assertSee('Kategori data berhasil diperbarui'); // Sesuaikan dengan pesan success

            // Test Reset Kategori
            $browser->press('Reset')
                ->pause(500);

            // Verifikasi tombol Simpan Perubahan menjadi disabled setelah reset
            $browser->script([
                'return document.getElementById("saveButton").disabled;'
            ], function ($result) {
                $this->assertTrue($result[0]);
            });

            // Test Hapus Data Curah Hujan
            $rainfallToDelete = RainfallData::where('weather_station_id', $station->id)->first();
            
            if ($rainfallToDelete) {
                $browser->visit('/admin/weather/rainfall')
                    ->select('station_id', $station->id)
                    ->pause(2000)
                    ->click(".delete-btn[data-id='{$rainfallToDelete->id}']")
                    ->pause(500);

                // Handle konfirmasi JavaScript alert
                $browser->acceptDialog()
                    ->pause(2000)
                    ->assertSee('Data curah hujan berhasil dihapus'); // Sesuaikan dengan pesan success
            }

            // Test Filter - Pilih stasiun yang tidak memiliki data
            $emptyStation = WeatherStation::whereDoesntHave('rainfallData')->first();
            if ($emptyStation) {
                $browser->visit('/admin/weather/rainfall')
                    ->select('station_id', $emptyStation->id)
                    ->pause(2000)
                    ->assertSee('Tidak ada data curah hujan untuk stasiun ini');
            }

            // Test halaman tanpa filter stasiun
            $browser->visit('/admin/weather/rainfall')
                ->assertSee('Silakan pilih stasiun cuaca untuk melihat data curah hujan');
        });
    }

    /**
     * Test khusus untuk form Create Data Curah Hujan.
     */
    public function test_create_rainfall_data_form()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@ceban.com')->first();
            $station = WeatherStation::first();

            $browser->loginAs($admin)
                ->visit('/admin/weather/rainfall/create')
                ->assertSee('Tambah Data Curah Hujan');

            // Test validasi form kosong
            $browser->press('Simpan')
                ->assertSee('Pilih Stasiun Cuaca'); // Error validation message

            // Test pengisian form lengkap
            $browser->select('weather_station_id', $station->id)
                ->type('recorded_at', now()->format('Y-m-d'))
                ->select('data_source', 'sensor')
                ->type('rainfall_amount', '8.2')
                ->press('Simpan')
                ->assertPathIs('/admin/weather/rainfall');

            // Test tombol Reset
            $browser->visit('/admin/weather/rainfall/create')
                ->select('weather_station_id', $station->id)
                ->type('rainfall_amount', '10.5')
                ->press('Reset')
                ->assertValue('rainfall_amount', ''); // Form harus kosong setelah reset
        });
    }

    /**
     * Test responsivitas dan interaksi UI.
     */
    public function test_rainfall_data_ui_interactions()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@ceban.com')->first();
            $station = WeatherStation::first();

            // Buat data test
            $rainfall = RainfallData::create([
                'weather_station_id' => $station->id,
                'date' => now()->format('Y-m-d'),
                'rainfall_amount' => 12.5,
                'intensity' => 0.52,
                'category' => 'sedang',
                'data_source' => 'manual'
            ]);

            $browser->loginAs($admin)
                ->visit('/admin/weather/rainfall')
                ->select('station_id', $station->id)
                ->pause(2000);

            // Test keterangan klasifikasi ditampilkan
            $browser->assertSee('Keterangan Klasifikasi:')
                ->assertSee('Rendah: 0-5mm')
                ->assertSee('Sedang: 5-20mm')
                ->assertSee('Tinggi: 20-50mm')
                ->assertSee('Sangat Tinggi: >50mm');

            // Test keterangan sumber data
            $browser->assertSee('Sumber Data:')
                ->assertSee('Manual')
                ->assertSee('Sensor')
                ->assertSee('API');

            // Test link kembali dari halaman create
            $browser->clickLink('Tambah Data Manual')
                ->clickLink('Kembali')
                ->assertPathIs('/admin/weather/rainfall');

            // Test link kembali dari halaman edit
            $browser->visit("/admin/weather/rainfall/{$rainfall->id}/edit")
                ->assertSee('Edit Data Curah Hujan')
                ->clickLink('Kembali')
                ->assertPathIs('/admin/weather/rainfall');

            // Cleanup
            $rainfall->delete();
        });
    }
}