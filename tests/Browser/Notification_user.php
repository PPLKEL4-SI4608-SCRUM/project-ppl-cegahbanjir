<?php

use Laravel\Dusk\Browser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('akses halaman Notifikasi User', function () {
    // Pastikan admin tersedia
    User::updateOrCreate(
        ['email' => 'aljer@gmail.com'],
        [
            'email' => 'aljer@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
        ]
    );

    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('email', 'aljer@gmail.com')
            ->type('password', '12345678')
            ->press('Login')
            ->pause(1000)
            ->assertPathIs('/dashboard')
            ->assertSee('Peringatan Dini Banjir')
            ->assertVisible('@share-twitter')
            ->click('@share-twitter');

    });
});
