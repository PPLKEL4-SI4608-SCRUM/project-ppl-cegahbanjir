@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="bg-white max-w-5xl mx-auto px-6 py-10 rounded-xl shadow-md">
            {{-- Judul --}}
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-gray-900 mb-2">{{ $rekomendasi->title }}</h1>
            </div>

            {{-- Konten Utama --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start mb-10">
                {{-- Gambar --}}
                <div class="flex flex-col justify-start items-center space-y-6">
                    @php
                        $imageMap = [
                            1 => 'tasdarurat.png',
                            3 => 'lari.png',
                            5 => 'listrikbanjir.png',
                            7 => 'images1.jpg',
                            9 => 'elektronikbanjir.png',
                        ];
                        $imageFile = $imageMap[$rekomendasi->id] ?? 'default.jpg';
                    @endphp

                    <img src="{{ url('artikel_images/' . $rekomendasi->image_path) }}" alt="gambar artikel"
                        class="rounded-lg shadow-md h-full w-full object-cover rounded-md object-contain">

                    {{-- Share with friends --}}
                    <div class="text-left w-full">
                        <p class="font-semibold text-gray-700 mb-2">Share with friends</p>
                        <div class="flex space-x-4">
                            <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                                class="w-6 h-6 hover:scale-110 transition">
                            <img src="{{ asset('images/instagram.jpg') }}" alt="Instagram"
                                class="w-6 h-6 hover:scale-110 transition">
                            <img src="{{ asset('images/whatsapp.jpg') }}" alt="WhatsApp"
                                class="w-6 h-6 hover:scale-110 transition">
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-6">
                    <p class="text-gray-700 text-sm leading-relaxed text-justify">
                        {!! nl2br(e($rekomendasi->description)) !!}
                    </p>

                    <div class="flex justify-center space-x-8">
                        @foreach ($rekomendasi->solutions as $item)
                            <div class="flex flex-col items-center p-2">
                                <div class="text-white rounded-full w-12 h-12 flex items-center justify-center">
                                    <!-- Replace with your flame icon -->
                                    <img src="{{ url('solution_icons/' . $item->icon_path) }}" class="w-6 h-6">
                                </div>
                                <p class="text-center text-sm font-semibold mt-2">Cegah<br>kerusakan alat</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="max-w-xl mx-auto bg-blue-50 p-6 rounded-lg shadow-sm text-gray-800 text-sm leading-relaxed text-justify">
                        @foreach ($rekomendasi->solutions as $item)
                        <p class="mb-2">
                            {{$item->description}}
                        </p>
                        @endforeach
                      </div>
                      

                    {{-- ID 1: Siapkan Tas Darurat --}}
                    @if ($rekomendasi->id == 1)
                        <div class="pt-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Dokumen Penting --}}
                                <div class="flex items-center bg-blue-100 p-4 rounded-lg shadow-md">
                                    <img src="{{ asset('images/dokumen.png') }}" alt="Dokumen Penting"
                                        class="w-12 h-12 mr-4">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm mb-1">Dokumen Penting</p>
                                        <p class="text-xs text-gray-600">Siapkan dokumen penting seperti KTP, KK, akta, dan
                                            surat berharga lainnya.</p>
                                    </div>
                                </div>

                                {{-- Obat-Obatan --}}
                                <div class="flex items-center bg-blue-100 p-4 rounded-lg shadow-md">
                                    <img src="{{ asset('images/obat.png') }}" alt="Obat-Obatan" class="w-12 h-12 mr-4">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm mb-1">Obat-Obatan</p>
                                        <p class="text-xs text-gray-600">Bawa obat pribadi, P3K, vitamin, dan kebutuhan
                                            medis darurat lainnya.</p>
                                    </div>
                                </div>

                                {{-- Makanan Ringan --}}
                                <div class="flex items-center bg-blue-100 p-4 rounded-lg shadow-md">
                                    <img src="{{ asset('images/makanan.png') }}" alt="Makanan Ringan"
                                        class="w-12 h-12 mr-4">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm mb-1">Makanan Ringan</p>
                                        <p class="text-xs text-gray-600">Persiapkan makanan cepat saji, air mineral, dan
                                            energi bar yang tahan lama.</p>
                                    </div>
                                </div>

                                {{-- Pakaian dan Selimut --}}
                                <div class="flex items-center bg-blue-100 p-4 rounded-lg shadow-md">
                                    <img src="{{ asset('images/selimut.png') }}" alt="Pakaian dan Selimut"
                                        class="w-12 h-12 mr-4">
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm mb-1">Pakaian dan Selimut</p>
                                        <p class="text-xs text-gray-600">Bawa pakaian ganti, jaket hangat, dan selimut untuk
                                            menjaga kehangatan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- ID 9: Pindahkan Barang Elektronik --}}
                    @if ($rekomendasi->id == 9)
                        <div class="pt-4">
                            <p class="text-md font-semibold text-gray-900 mb-4">Kenapa harus memindahkan barang elektronik
                                kita?</p>
                            <div class="flex items-center justify-between">
                                <div class="w-1 h-16 bg-gray-800 rounded-full"></div>
                                <div class="flex flex-col items-center text-center mx-3">
                                    <img src="{{ asset('images/rusak.png') }}" alt="rusak" class="w-10 h-10 mb-2">
                                    <p class="text-sm font-semibold">Cegah<br>kerusakan alat</p>
                                </div>
                                <div class="flex flex-col items-center text-center mx-3">
                                    <img src="{{ asset('images/korslet.png') }}" alt="korslet" class="w-10 h-10 mb-2">
                                    <p class="text-sm font-semibold">Hindari<br>korsleting listrik</p>
                                </div>
                                <div class="flex flex-col items-center text-center mx-3">
                                    <img src="{{ asset('images/rugi.png') }}" alt="rugi" class="w-10 h-10 mb-2">
                                    <p class="text-sm font-semibold">Minimalkan<br>kerugian</p>
                                </div>
                                <div class="w-1 h-16 bg-gray-800 rounded-full"></div>
                            </div>

                            <div class="mt-6 p-4 rounded-lg" style="background-color: #e0f2fe;">
                                <p class="text-sm text-gray-800 text-justify leading-relaxed">
                                    Saat banjir mengancam, barang-barang elektronik menjadi salah satu aset rumah tangga
                                    yang paling rentan terhadap kerusakan. Oleh karena itu, penting untuk segera memindahkan
                                    perangkat elektronik seperti televisi, komputer, kulkas, dan alat-alat lain ke tempat
                                    yang lebih tinggi dan aman dari genangan air.
                                </p>
                            </div>

                            <div class="mt-10">
                                <h3 class="text-md font-semibold text-gray-800 mb-6 text-center">Tips Cepat Saat Evakuasi
                                    Elektronik</h3>
                                <div class="flex flex-wrap justify-center gap-6">
                                    <div
                                        class="w-60 bg-white border rounded-lg p-4 shadow hover:shadow-md transition flex flex-col items-center text-center">
                                        <img src="{{ asset('images/stopkontak.png') }}" alt="stopkontak"
                                            class="w-12 h-12 mb-3">
                                        <p class="font-semibold text-sm text-gray-900 mb-1">Cabut Stopkontak</p>
                                        <p class="text-xs text-gray-600 leading-relaxed">Pastikan semua perangkat sudah
                                            dimatikan dan dicabut dari arus listrik.</p>
                                    </div>
                                    <div
                                        class="w-60 bg-white border rounded-lg p-4 shadow hover:shadow-md transition flex flex-col items-center text-center">
                                        <img src="{{ asset('images/kedapair.png') }}" alt="kedap air"
                                            class="w-12 h-12 mb-3">
                                        <p class="font-semibold text-sm text-gray-900 mb-1">Gunakan Barang Kedap Air</p>
                                        <p class="text-xs text-gray-600 leading-relaxed">Letakkan barang elektronik di
                                            kontainer atau tas tahan air.</p>
                                    </div>
                                    <div
                                        class="w-60 bg-white border rounded-lg p-4 shadow hover:shadow-md transition flex flex-col items-center text-center">
                                        <img src="{{ asset('images/prioritas.png') }}" alt="prioritas"
                                            class="w-12 h-12 mb-3">
                                        <p class="font-semibold text-sm text-gray-900 mb-1">Prioritaskan Alat Utama</p>
                                        <p class="text-xs text-gray-600 leading-relaxed">Selamatkan alat penting seperti
                                            HP,
                                            laptop, dan peralatan medis.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ID 5: Matikan Listrik Saat Banjir --}}
                    @if ($rekomendasi->id == 5)
                        <div class="pt-4">
                            <p class="text-md font-semibold text-gray-900 mb-4">Mengapa Harus Mematikan Listrik Saat
                                Banjir?
                            </p>
                            <div class="flex justify-center gap-6 mb-6">
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ asset('images/switch-off.png') }}" alt="switch off"
                                        class="w-10 h-10 mb-2">
                                    <p class="text-sm font-semibold text-gray-800 leading-tight">Matikan<br>MCB Utama</p>
                                </div>
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ asset('images/air.png') }}" alt="air" class="w-10 h-10 mb-2">
                                    <p class="text-sm font-semibold text-gray-800 leading-tight">Hindari<br>Genangan Air
                                    </p>
                                </div>
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ asset('images/evakuasi.png') }}" alt="evakuasi" class="w-10 h-10 mb-2">
                                    <p class="text-sm font-semibold text-gray-800 leading-tight">Evakuasi<br>Secepatnya</p>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg" style="background-color: #e0f2fe;">
                                <p class="text-sm text-blue-900 text-justify leading-relaxed">
                                    Saat air mulai masuk ke rumah, listrik bisa menjadi ancaman mematikan. Selalu segera
                                    matikan MCB listrik utama, hindari menyentuh alat elektronik yang sudah terkena air, dan
                                    segera lakukan evakuasi ke tempat yang lebih tinggi. Keselamatan keluarga adalah
                                    prioritas utama!
                                </p>
                            </div>
                            <div class="mt-10 bg-blue-50 rounded-xl p-6 shadow-sm">
                                <h4 class="text-md font-semibold text-gray-800 mb-4 text-center">Perhatikan Sebelum Banjir
                                    Datang!</h4>
                                <ul class="text-sm text-gray-700 list-disc pl-6 space-y-2">
                                    <li>Kenali letak MCB utama dan pastikan anggota keluarga tahu cara mematikannya.</li>
                                    <li>Sediakan sepatu karet tahan air untuk evakuasi agar aman dari sengatan listrik.</li>
                                    <li>Pasang stiker pengingat "MATIKAN LISTRIK" dekat pintu atau MCB utama.</li>
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- ID 3: Langkah Cerdas Saat Banjir (updated layout) --}}
                    @if ($rekomendasi->id == 3)
                        <div class="pt-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-items-center">
                                <div
                                    class="w-full max-w-xs bg-blue-100 p-4 rounded-lg shadow-md text-center flex flex-col items-center">
                                    <img src="{{ asset('images/resmi.png') }}" class="w-10 h-10 mb-2"
                                        alt="Pantau Resmi">
                                    <p class="font-semibold text-gray-800 text-sm mb-1">Pantau Info Resmi</p>
                                    <p class="text-xs text-gray-600">Cek info dari BMKG atau instansi terpercaya.</p>
                                </div>
                                <div
                                    class="w-full max-w-xs bg-blue-100 p-4 rounded-lg shadow-md text-center flex flex-col items-center">
                                    <img src="{{ asset('images/gedung.png') }}" class="w-10 h-10 mb-2"
                                        alt="Evakuasi Aman">
                                    <p class="font-semibold text-gray-800 text-sm mb-1">Evakuasi Aman</p>
                                    <p class="text-xs text-gray-600">Menuju ke tempat lebih tinggi lebih dulu.</p>
                                </div>
                                <div
                                    class="w-full max-w-xs bg-blue-100 p-4 rounded-lg shadow-md text-center flex flex-col items-center">
                                    <img src="{{ asset('images/arus.png') }}" class="w-10 h-10 mb-2" alt="Hindari Arus">
                                    <p class="font-semibold text-gray-800 text-sm mb-1">Hindari Arus</p>
                                    <p class="text-xs text-gray-600">Arus air deras berbahaya, cari jalur aman.</p>
                                </div>
                                <div
                                    class="w-full max-w-xs bg-blue-100 p-4 rounded-lg shadow-md text-center flex flex-col items-center">
                                    <img src="{{ asset('images/listrik.png') }}" class="w-10 h-10 mb-2"
                                        alt="Matikan Listrik">
                                    <p class="font-semibold text-gray-800 text-sm mb-1">Matikan Listrik</p>
                                    <p class="text-xs text-gray-600">Pastikan semua aliran listrik rumah sudah mati.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ID 7: Ikuti Info Resmi --}}
                    @if ($rekomendasi->id == 7)
                        <div class="flex items-center gap-4 p-4 border rounded-lg shadow-sm">
                            <img src="{{ asset('images/flood.png') }}" alt="flood icon" class="w-10 h-10">
                            <p class="text-sm text-gray-700 text-justify">
                                Pastikan kamu selalu mengecek informasi cuaca dan peringatan dini dari situs resmi BMKG yang
                                akurat dan terpercaya di
                                <a href="https://bmkg.go.id" target="_blank"
                                    class="text-blue-600 font-semibold hover:underline">https://bmkg.go.id</a>
                                <img src="{{ asset('images/arrow.png') }}" alt="arrow" class="inline w-4 h-4 ml-1">
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tombol kembali --}}
            <div class="mt-8">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm font-medium">← Kembali ke
                    Dashboard</a>
            </div>
        </div>
    </div>
@endsection
