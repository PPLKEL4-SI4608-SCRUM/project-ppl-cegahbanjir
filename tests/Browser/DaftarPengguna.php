<?php

use Laravel\Dusk\Browser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('akses halaman daftar pengguna', function () {
    // pastikan user admin selalu tersedia
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
            ->assertSee('Data Pengguna')
            ->click('@akses-pengguna') // klik tombol akses ke Data Pengguna
            ->assertPathIs('/admin/pengguna')
            ->assertPathIs('/admin/pengguna')
            ->assertSee('farhan@gmail.com')

            ->press('@hapus-user')
            ->pause(500)
            ->acceptDialog()
            ->assertDontSee('farhan@gmail.com');
    });
});
