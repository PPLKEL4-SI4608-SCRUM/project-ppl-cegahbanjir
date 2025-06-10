<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ArtikelRekomendasiTest extends DuskTestCase
{
    public function test_admin_can_add_recommended_article()
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@ceban.com')->first();

            $browser->loginAs($admin)
                ->visit('/admin/dashboard')
                ->pause(1500)
                ->assertSee('Artikel Rekomendasi')

                // klik tombol akses pakai selector attribute `dusk="akses-artikel-rekomendasi"`
                ->click('@akses-artikel-rekomendasi')
                ->pause(1000)

                // verifikasi sampai ke halaman index
                ->assertPathBeginsWith('/admin/artikels')
                ->assertSee('Tambah Artikel')

                // klik tombol tambah artikel
                ->clickLink('Tambah Artikel')
                ->assertPathIs('/admin/artikels/create')

                // isi form
                ->type('title', 'Cara Mencegah Banjir dari Rumah')
                ->type('description', 'Artikel ini membahas langkah sederhana untuk mencegah banjir dari lingkungan rumah.')
                ->attach('image', storage_path('app/tests/sample.png'))
                ->attach('icon', storage_path('app/tests/icon.png'))
                ->type('solution_titles[]', 'Bersihkan Selokan')
                ->type('solution_descriptions[]', 'Rutin membersihkan saluran air sekitar rumah.')
                ->attach('solution_icons[]', storage_path('app/tests/icon_solusi.png'))

                // kirim
                ->press('Simpan Artikel')
                ->pause(3000)

                // verifikasi berhasil redirect & artikel tampil
                ->assertPathBeginsWith('/admin/artikels')
                ->assertSee('Cara Mencegah Banjir dari Rumah')
                ->screenshot('artikel-berhasil-disimpan');
        });
    }
}
