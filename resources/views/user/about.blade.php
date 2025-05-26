@extends('layouts.app')

@section('title', 'Tentang CeBan - Cegah Banjir')

@section('head')
    {{-- Existing head content --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Swiper CSS (added here for this specific page, or in layouts/app for global use) --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        /* Existing styles */
        #map, .modal-map {
            height: 300px;
            margin-top: 1rem;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .leaflet-control-geocoder {
            margin-top: 10px;
            margin-left: 10px;
        }

        .custom-file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            cursor: pointer;
        }

        .custom-file-input {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .custom-file-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #374151;
            color: #d1d5db;
            border: 1px solid #4b5563;
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        .custom-file-label:hover {
            background-color: #4b5563;
            border-color: #6b7280;
        }

        .custom-file-label svg {
            flex-shrink: 0;
            margin-left: 0.5rem;
        }

        .modal-content-container {
            background-color: #fff;
            color: #1a202c;
            position: relative;
            z-index: 60;
        }
        .dark .modal-content-container {
            background-color: rgba(55, 65, 81, 5);
            color: #d1d5db;
        }

        .leaflet-control-geocoder .leaflet-control-geocoder-form input {
            font-family: 'Poppins', sans-serif !important;
            border-radius: 0.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #ccc;
            outline: none;
            box-shadow: none;
        }

        .leaflet-control-geocoder-form.geocoding-icon-throbber input {
            background-image: url('{{ asset('images/loading-cute.gif') }}');
            background-repeat: no-repeat;
            background-position: calc(100% - 8px) center;
            background-size: 20px 20px;
            padding-right: 30px;
        }

        [data-modal-show][data-modal-target],
        [data-modal-toggle][data-modal-target] {
            cursor: pointer;
        }

        body.overflow-hidden {
            overflow: hidden !important;
        }

        /* Swiper custom styles */
        .swiper {
            width: 100%;
            padding-bottom: 50px; /* Space for pagination */
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .swiper-button-prev,
        .swiper-button-next {
            color: #FFA404 !important; /* Your brand color */
        }
        .swiper-pagination-bullet {
            background: #FFA404 !important; /* Your brand color */
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-2xl shadow-lg p-6 text-gray-800">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Tentang CeBan (Cegah Banjir)</h1>

            <p class="mb-6 text-lg text-gray-700">
                CeBan adalah sebuah platform web inovatif yang didedikasikan untuk membantu masyarakat menghadapi tantangan banjir di Indonesia.
                Dibangun dengan visi untuk menciptakan lingkungan yang lebih aman dan tangguh terhadap bencana, CeBan berfungsi sebagai jembatan informasi antara kondisi cuaca, potensi banjir, dan kesiapan komunitas.
            </p>

            <div class="mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-blue-500 p-2 rounded-lg">
                        <i class="fas fa-eye text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Bagaimana CeBan Berfungsi?</h3>
                </div>
                <div class="swiper mySwiper1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-blue-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-cloud-sun text-blue-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">1. Pemantauan Cuaca Real-time</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Kami terintegrasi dengan stasiun pemantauan cuaca dan data curah hujan untuk memberikan informasi yang akurat dan terkini.
                                    Data ini menjadi dasar bagi sistem prediksi kami untuk mengidentifikasi potensi ancaman banjir.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-blue-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">2. Prediksi & Peta Interaktif</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Menggunakan algoritma canggih, CeBan memproses data cuaca untuk memprediksi area yang berisiko banjir.
                                    Informasi ini divisualisasikan dalam peta interaktif yang mudah dipahami, menunjukkan tingkat kerentanan dan lokasi potensi banjir.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-blue-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-pencil-alt text-blue-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">3. Laporan Insiden dari Masyarakat</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Masyarakat dapat secara aktif melaporkan kejadian banjir atau genangan air melalui fitur pelaporan kami.
                                    Setiap laporan diverifikasi oleh tim admin untuk memastikan keakuratan, memperkaya data lapangan, dan memungkinkan respons yang lebih cepat dari pihak terkait.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-blue-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-blue-100 p-3 rounded-full">
                                        <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">4. Edukasi & Rekomendasi</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Selain informasi real-time, CeBan juga menyediakan berbagai artikel, tips, dan rekomendasi praktis tentang persiapan menghadapi banjir,
                                    langkah-langkah mitigasi, serta apa yang harus dilakukan selama dan setelah bencana.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <div class="mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-cyan-500 p-2 rounded-lg">
                        <i class="fas fa-hands-helping text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Manfaat CeBan bagi Masyarakat</h3>
                </div>
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-cyan-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-cyan-100 p-3 rounded-full">
                                        <i class="fas fa-shield-alt text-cyan-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">Kesiapan Lebih Awal</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Dengan informasi prediksi yang cepat, masyarakat dapat mempersiapkan diri lebih awal, mengamankan barang berharga,
                                    dan merencanakan evakuasi jika diperlukan, mengurangi risiko kerugian material dan jiwa.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-cyan-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-cyan-100 p-3 rounded-full">
                                        <i class="fas fa-check-circle text-cyan-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">Informasi Akurat & Terpercaya</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Kami memastikan data yang disajikan akurat dan diverifikasi, memberikan ketenangan pikiran bagi pengguna.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-cyan-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-cyan-100 p-3 rounded-full">
                                        <i class="fas fa-users-cog text-cyan-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">Partisipasi Aktif Masyarakat</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Fitur pelaporan memungkinkan masyarakat menjadi bagian dari solusi, membantu pihak berwenang mendapatkan gambaran situasi yang lebih komprehensif di lapangan.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-[#F8F9FA] rounded-xl shadow p-4 border-l-4 border-cyan-500 w-full">
                                <div class="flex justify-center mb-3">
                                    <div class="bg-cyan-100 p-3 rounded-full">
                                        <i class="fas fa-lightbulb text-cyan-600 text-xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-lg mb-2 text-gray-800 text-center">Peningkatan Kesadaran Bencana</h4>
                                <p class="text-sm text-gray-600 text-center">
                                    Melalui artikel dan notifikasi, CeBan berperan dalam meningkatkan kesadaran masyarakat akan pentingnya mitigasi dan kesiapan bencana.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <p class="text-lg text-gray-700 text-center mt-8">
                CeBan dikembangkan oleh tim mahasiswa dari Universitas Indonesia, dengan semangat untuk berkontribusi pada keselamatan dan kesejahteraan masyarakat.
                Kami terus berkomitmen untuk mengembangkan dan meningkatkan fitur-fitur CeBan demi Indonesia yang lebih tangguh.
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Existing scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js" defer></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="" defer></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js" defer></script>

    {{-- Swiper JS --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Swiper for "How it Works" section
            var swiper1 = new Swiper(".mySwiper1", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000, // 5 seconds
                    disableOnInteraction: false, // Continue autoplay after user interaction
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    640: { // sm
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: { // md
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: { // lg
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                }
            });

            // Initialize Swiper for "Benefits" section
            var swiper2 = new Swiper(".mySwiper2", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000, // 5 seconds
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    640: { // sm
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: { // md
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: { // lg
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                }
            });
        });

        // The map-related script should still be included in layouts/app or relevant pages
        // but it's not directly related to the "about" page, so it's not copied here unless explicitly needed.
        // If you have a global map initialization on every page, then that logic would remain global.
    </script>
@endsection