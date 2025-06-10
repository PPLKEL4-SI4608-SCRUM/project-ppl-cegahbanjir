<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmergencyNumbersTest extends DuskTestCase
{
    /**
     * Test fitur Emergency Numbers di dashboard.
     */
    public function test_emergency_numbers_display_and_functionality()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai user
            $user = User::where('email', 'user@ceban.com')->first();
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(1500)
                ->assertSee('Dashboard');

            // Verifikasi keberadaan section Nomor Darurat Banjir
            $browser->assertSee('Nomor Darurat Banjir')
                ->assertPresent('div.bg-white.rounded-xl.shadow-lg.p-5.border-l-8.border-[#FFA404]');

            // Test keberadaan semua nomor darurat
            $emergencyNumbers = [
                'BNPB (Badan Nasional Penanggulangan Bencana)' => '117',
                'Basarnas (Search and Rescue)' => '115',
                'Call Center PMI' => '021-119',
                'Polisi' => '110',
                'Ambulans' => '118',
                'Pemadam Kebakaran' => '113'
            ];

            foreach ($emergencyNumbers as $serviceName => $phoneNumber) {
                $browser->assertSee($serviceName)
                    ->assertSee($phoneNumber);
            }

            // Test link telepon untuk BNPB
            $browser->assertPresent('a[href="tel:117"]')
                ->with('a[href="tel:117"]', function ($link) {
                    $link->assertSee('117');
                });

            // Test link telepon untuk Basarnas
            $browser->assertPresent('a[href="tel:115"]')
                ->with('a[href="tel:115"]', function ($link) {
                    $link->assertSee('115');
                });

            // Test link telepon untuk PMI
            $browser->assertPresent('a[href="tel:021119"]')
                ->with('a[href="tel:021119"]', function ($link) {
                    $link->assertSee('021-119');
                });

            // Test link telepon untuk Polisi
            $browser->assertPresent('a[href="tel:110"]')
                ->with('a[href="tel:110"]', function ($link) {
                    $link->assertSee('110');
                });

            // Test link telepon untuk Ambulans
            $browser->assertPresent('a[href="tel:118"]')
                ->with('a[href="tel:118"]', function ($link) {
                    $link->assertSee('118');
                });

            // Test link telepon untuk Pemadam Kebakaran
            $browser->assertPresent('a[href="tel:113"]')
                ->with('a[href="tel:113"]', function ($link) {
                    $link->assertSee('113');
                });

            // Verifikasi pesan bantuan di bagian bawah
            $browser->assertSee('Tekan nomor untuk langsung menghubungi');

            // Test hover effect pada tombol (menggunakan mouse hover)
            $browser->mouseover('a[href="tel:117"]')
                ->pause(500); // Pause untuk melihat efek hover

            // Test responsive design - pastikan elemen terlihat pada ukuran layar berbeda
            $browser->resize(768, 1024) // Tablet size
                ->pause(500)
                ->assertSee('Nomor Darurat Banjir')
                ->assertSee('BNPB (Badan Nasional Penanggulangan Bencana)')
                ->resize(1920, 1080); // Desktop size

            // Test semua nomor emergency dalam satu loop untuk memastikan semuanya bisa diklik
            $phoneLinks = [
                'tel:117',
                'tel:115', 
                'tel:021119',
                'tel:110',
                'tel:118',
                'tel:113'
            ];

            foreach ($phoneLinks as $phoneLink) {
                $browser->assertPresent("a[href=\"{$phoneLink}\"]")
                    ->with("a[href=\"{$phoneLink}\"]", function ($link) {
                        // Verifikasi bahwa link memiliki class yang benar untuk styling
                        $link->assertAttribute('class', 'flex items-center bg-[#FFA404] text-white px-3 py-1 rounded-full text-sm hover:bg-[#FF8C00] transition');
                    });
            }

            // Test keberadaan icon telepon pada setiap tombol
            $browser->assertPresent('svg.h-4.w-4.mr-1')
                ->pause(1000);
        });
    }

    /**
     * Test accessibility dan struktur HTML dari emergency numbers.
     */
    public function test_emergency_numbers_accessibility()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'user@ceban.com')->first();
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(1500);

            // Test struktur semantik HTML
            $browser->assertPresent('div.space-y-3.mb-3')
                ->assertPresent('div.bg-[#FFF7E6].rounded-lg.p-3');

            // Test bahwa setiap nomor emergency memiliki struktur yang konsisten
            $browser->with('.space-y-3', function ($container) {
                // Pastikan ada 6 item emergency numbers
                $container->assertPresent('div.flex.justify-between.items-center:nth-child(1)')
                    ->assertPresent('div.flex.justify-between.items-center:nth-child(2)')
                    ->assertPresent('div.flex.justify-between.items-center:nth-child(3)')
                    ->assertPresent('div.flex.justify-between.items-center:nth-child(4)')
                    ->assertPresent('div.flex.justify-between.items-center:nth-child(5)')
                    ->assertPresent('div.flex.justify-between.items-center:nth-child(6)');
            });

            // Test bahwa semua link telepon dapat diakses
            $browser->keys('body', ['{tab}']); // Simulasi navigasi keyboard
            $browser->pause(500);
        });
    }

    /**
     * Test komponen emergency numbers pada berbagai kondisi.
     */
    public function test_emergency_numbers_edge_cases()
    {
        $this->browse(function (Browser $browser) {
            $user = User::where('email', 'user@ceban.com')->first();
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(1500);

            // Test scroll ke section emergency numbers jika ada banyak konten
            $browser->scrollIntoView('h2:contains("Nomor Darurat Banjir")')
                ->pause(1000)
                ->assertSee('Nomor Darurat Banjir');

            // Test bahwa section tetap terlihat setelah refresh
            $browser->refresh()
                ->pause(2000)
                ->assertSee('Nomor Darurat Banjir')
                ->assertSee('BNPB (Badan Nasional Penanggulangan Bencana)');

            // Test interaksi dengan multiple emergency numbers
            $browser->click('a[href="tel:117"]')
                ->pause(500)
                ->back()
                ->pause(1000)
                ->assertPathIs('/dashboard');
        });
    }
}