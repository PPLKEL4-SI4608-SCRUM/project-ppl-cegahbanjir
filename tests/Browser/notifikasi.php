<?php

use Laravel\Dusk\Browser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('akses halaman Notifikasi', function () {
    // Pastikan admin tersedia
    User::updateOrCreate(
        ['email' => 'admin@ceban.com'],
        [
            'email' => 'admin@ceban.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]
    );

    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('email', 'admin@ceban.com')
            ->type('password', 'admin123')
            ->press('Login')
            ->pause(1000)
            ->assertPathIs('/admin/dashboard')
            ->assertSee('Notifikasi')
            ->click('@akses-notifikasi')
            ->select('weather_station_id', 'Bandung City, West Java, Java, Indonesia')
            ->press('@kirim-notifikasi')
            ->pause(500);

    });
});
