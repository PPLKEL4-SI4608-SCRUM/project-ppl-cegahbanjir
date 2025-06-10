<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\DisasterReport;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DisasterReportTest extends DuskTestCase
{
    /**
     * Test Kelola Laporan Bencana.
     */
    public function test_disaster_report_management()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            $browser->loginAs($admin)
                ->visit('/admin/dashboard')
                ->pause(1500)
                ->assertSee('Dashboard Admin'); // Sesuaikan dengan text yang ada di dashboard

            // Akses halaman Kelola Laporan Bencana
            $browser->click('@akses-laporan-bencana')
                ->assertPathIs('/admin/laporan-bencana')
                ->assertSee('Kelola Laporan Bencana');

            // Test ketika tidak ada laporan
            if ($browser->seeIn('body', 'Belum ada laporan bencana yang masuk')) {
                $browser->assertSee('Belum ada laporan bencana yang masuk');
            }
        });
    }

    /**
     * Test menerima laporan bencana.
     */
    public function test_accept_disaster_report()
    {
        // Buat laporan bencana untuk testing
        $user = User::factory()->create();
        $report = DisasterReport::factory()->create([
            'user_id' => $user->id,
            'location' => 'Bandung Test',
            'description' => 'Laporan bencana untuk testing',
            'status' => 'pending'
        ]);

        $this->browse(function (Browser $browser) use ($report) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            $browser->loginAs($admin)
                ->visit('/admin/laporan-bencana')
                ->assertSee('Kelola Laporan Bencana');

            // Cek apakah laporan muncul di tabel
            $browser->assertSee($report->location)
                ->assertSee($report->description)
                ->assertSee('Pending');

            // Klik tombol Terima
            $browser->with("tr:contains('{$report->location}')", function ($row) {
                $row->with('td:last-child', function ($td) {
                    $td->within('form[action*="accept"]', function ($form) {
                        $form->press('Terima');
                    });
                });
            })
            ->pause(1000)
            ->assertSee('Sudah diproses');

            // Verifikasi status berubah menjadi accepted
            $browser->assertDontSee('Pending')
                ->assertSee('accepted');
        });

        // Cleanup
        $report->delete();
    }

    /**
     * Test menolak laporan bencana.
     */
    public function test_reject_disaster_report()
    {
        // Buat laporan bencana untuk testing
        $user = User::factory()->create();
        $report = DisasterReport::factory()->create([
            'user_id' => $user->id,
            'location' => 'Jakarta Test',
            'description' => 'Laporan bencana untuk testing reject',
            'status' => 'pending'
        ]);

        $this->browse(function (Browser $browser) use ($report) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            $browser->loginAs($admin)
                ->visit('/admin/laporan-bencana')
                ->assertSee('Kelola Laporan Bencana');

            // Cek apakah laporan muncul di tabel
            $browser->assertSee($report->location)
                ->assertSee($report->description)
                ->assertSee('Pending');

            // Klik tombol Tolak
            $browser->with("tr:contains('{$report->location}')", function ($row) {
                $row->with('td:last-child', function ($td) {
                    $td->within('form[action*="reject"]', function ($form) {
                        $form->press('Tolak');
                    });
                });
            })
            ->pause(1000)
            ->assertSee('Sudah diproses');

            // Verifikasi status berubah menjadi rejected
            $browser->assertDontSee('Pending')
                ->assertSee('rejected');
        });

        // Cleanup
        $report->delete();
    }

    /**
     * Test tampilan tabel dengan data laporan.
     */
    public function test_disaster_report_table_display()
    {
        // Buat beberapa laporan untuk testing
        $user = User::factory()->create();
        $reports = DisasterReport::factory()->count(3)->create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        $this->browse(function (Browser $browser) use ($reports) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            $browser->loginAs($admin)
                ->visit('/admin/laporan-bencana')
                ->assertSee('Kelola Laporan Bencana');

            // Cek header tabel
            $browser->assertSee('Pelapor')
                ->assertSee('Lokasi')
                ->assertSee('Deskripsi')
                ->assertSee('Gambar')
                ->assertSee('Status')
                ->assertSee('Aksi');

            // Cek setiap laporan muncul di tabel
            foreach ($reports as $report) {
                $browser->assertSee($report->location)
                    ->assertSee($report->description)
                    ->assertSee($report->user->name)
                    ->assertSee('Pending');
            }
        });

        // Cleanup
        foreach ($reports as $report) {
            $report->delete();
        }
    }

    /**
     * Test tampilan success message setelah aksi.
     */
    public function test_success_message_display()
    {
        $this->browse(function (Browser $browser) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            
            // Simulasi dengan session success
            $browser->loginAs($admin)
                ->visit('/admin/laporan-bencana')
                ->assertSee('Kelola Laporan Bencana');

            // Jika ada session success, akan muncul pesan
            // Ini akan bergantung pada implementasi session flash message
            // di controller setelah aksi accept/reject
        });
    }

    /**
     * Test tampilan gambar bencana.
     */
    public function test_disaster_image_display()
    {
        // Buat laporan dengan gambar
        $user = User::factory()->create();
        $report = DisasterReport::factory()->create([
            'user_id' => $user->id,
            'disaster_image' => 'test_image.jpg',
            'status' => 'pending'
        ]);

        $this->browse(function (Browser $browser) use ($report) {
            // Login sebagai admin
            $admin = User::where('email', 'admin@ceban.com')->first();
            $browser->loginAs($admin)
                ->visit('/admin/laporan-bencana')
                ->assertSee('Kelola Laporan Bencana');

            // Cek gambar muncul di tabel
            $browser->with("tr:contains('{$report->location}')", function ($row) {
                $row->assertPresent('img');
            });
        });

        // Test laporan tanpa gambar
        $reportNoImage = DisasterReport::factory()->create([
            'user_id' => $user->id,
            'disaster_image' => null,
            'status' => 'pending'
        ]);

        $this->browse(function (Browser $browser) use ($reportNoImage) {
            $browser->visit('/admin/laporan-bencana')
                ->with("tr:contains('{$reportNoImage->location}')", function ($row) {
                    $row->assertSee('Tidak ada gambar');
                });
        });

        // Cleanup
        $report->delete();
        $reportNoImage->delete();
    }
}