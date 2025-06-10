<?php

use Laravel\Dusk\Browser;

test('example', function () {
    $this->browse(function (Browser $browser) {
        sleep(2); // tambahin delay biar server siap
        $browser->visit('/login')
            ->type('email', 'admin@ceban.com')
            ->type('password', 'admin123') // pastikan pakai password bener
            ->press('Login')
            ->assertPathIs('/admin/dashboard') // sesuaikan dengan redirect setelah login
            ->assertSee('Statistik Laporan Banjir')
            ->clickLink('Akses');
    });
});
