@extends('layouts.app')

@section('title', 'Tentang CeBan - Cegah Banjir')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEbFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        /* General styles, keeping them for completeness but focusing on About page specifics */
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
        .swiper-container {
            width: 100%;
            padding-bottom: 50px;
            padding-top: 10px;
            padding-left: 50px;
            padding-right: 50px;
            box-sizing: border-box;
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: stretch;
            height: auto;
            padding: 10px;
        }
        .swiper-button-prev,
        .swiper-button-next {
            color: #FFA404 !important;
            --swiper-navigation-size: 24px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        .swiper-button-prev {
            left: 10px;
        }
        .swiper-button-next {
            right: 10px;
        }

        .swiper-pagination-bullet {
            background: #FFA404 !important;
        }

        /* Card-specific styling for consistency and hover */
        .info-card {
            background-color: #F8F9FA;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            text-align: center;
            transition: all 0.2s ease-in-out;
            border-left-width: 4px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            height: 100%;
        }
        .info-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-3px);
        }

        .info-card .icon-wrapper {
            padding: 0.75rem;
            border-radius: 9999px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-card h4 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }
        .info-card p {
            font-size: 0.875rem;
            color: #4b5563;
            line-height: 1.5;
        }

        /* Adjustments for section header icons */
        .section-header-icon {
            background-color: #3b82f6; /* bg-blue-500 */
            padding: 0.5rem;
            border-radius: 0.5rem;
            color: white;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .section-header-icon.cyan {
            background-color: #06b6d4; /* bg-cyan-500 */
        }

        /* NEW: Comprehensive header and intro styling with background image */
        .about-hero-section {
            background-image: url('{{ asset('images/images-aboutus.jpeg') }}'); /* Set background image */
            background-size: cover; /* Cover the entire area */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: #ecf0f1;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
            z-index: 0; /* Ensure content above overlay */
        }

        /* Overlay for readability */
        .about-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(18, 27, 34, 0.7); /* Dark blue/black with 70% opacity */
            border-radius: 1rem; /* Match parent border-radius */
            z-index: 1; /* Place overlay above background image, below content */
        }

        .about-hero-section .header-content {
            position: relative; /* Make sure content is above the overlay */
            z-index: 2; /* Higher z-index than overlay */
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            width: 100%; /* Take full width for centering */
        }

        .about-hero-section .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .about-hero-section .header-title .icon-wrapper {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 0.75rem;
            border-radius: 50%;
            font-size: 2rem;
            color: #FFA404;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 0 15px rgba(255, 164, 4, 0.4);
        }

        .about-hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0;
            color: #ecf0f1;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }

        .about-hero-section .intro-paragraph {
            font-size: 1.15rem;
            line-height: 1.8;
            max-width: 55rem;
            margin: 0 auto;
            color: #bdc3c7;
            font-weight: 400;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-2xl shadow-lg p-6 text-gray-800">

            {{-- Revamped Hero Section with Background Image and Overlay --}}
            <div class="about-hero-section">
                <div class="header-content"> {{-- Wrapper for content above overlay --}}
                    <div class="header-title">
                        <div class="icon-wrapper">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h1>Tentang CeBan (Cegah Banjir)</h1>
                    </div>
                    <p class="intro-paragraph">
                        CeBan adalah sebuah platform web inovatif yang didedikasikan untuk membantu masyarakat menghadapi tantangan banjir di Indonesia.
                        Dibangun dengan visi untuk menciptakan lingkungan yang lebih aman dan tangguh terhadap bencana, CeBan berfungsi sebagai jembatan informasi antara kondisi cuaca, potensi banjir, dan kesiapan komunitas.
                    </p>
                </div>
            </div>


            <div class="mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="section-header-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Bagaimana CeBan Berfungsi?</h3>
                </div>
                <div class="swiper swiper-container mySwiper1">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #3b82f6;">
                                <div class="icon-wrapper" style="background-color: #bfdbfe;">
                                    <i class="fas fa-cloud-sun text-blue-600 text-xl"></i>
                                </div>
                                <h4 class="">1. Pemantauan Cuaca Real-time</h4>
                                <p class="">
                                    Kami terintegrasi dengan stasiun pemantauan cuaca dan data curah hujan untuk memberikan informasi yang akurat dan terkini.
                                    Data ini menjadi dasar bagi sistem prediksi kami untuk mengidentifikasi potensi ancaman banjir.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #3b82f6;">
                                <div class="icon-wrapper" style="background-color: #bfdbfe;">
                                    <i class="fas fa-map-marked-alt text-blue-600 text-xl"></i>
                                </div>
                                <h4 class="">2. Prediksi & Peta Interaktif</h4>
                                <p class="">
                                    Menggunakan algoritma canggih, CeBan memproses data cuaca untuk memprediksi area yang berisiko banjir.
                                    Informasi ini divisualisasikan dalam peta interaktif yang mudah dipahami, menunjukkan tingkat kerentanan dan lokasi potensi banjir.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #3b82f6;">
                                <div class="icon-wrapper" style="background-color: #bfdbfe;">
                                    <i class="fas fa-pencil-alt text-blue-600 text-xl"></i>
                                </div>
                                <h4 class="">3. Laporan Insiden dari Masyarakat</h4>
                                <p class="">
                                    Masyarakat dapat secara aktif melaporkan kejadian banjir atau genangan air melalui fitur pelaporan kami.
                                    Setiap laporan diverifikasi oleh tim admin untuk memastikan keakuratan, memperkaya data lapangan, dan memungkinkan respons yang lebih cepat dari pihak terkait.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #3b82f6;">
                                <div class="icon-wrapper" style="background-color: #bfdbfe;">
                                    <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                                </div>
                                <h4 class="">4. Edukasi & Rekomendasi</h4>
                                <p class="">
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
                    <div class="section-header-icon cyan">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Manfaat CeBan bagi Masyarakat</h3>
                </div>
                <div class="swiper swiper-container mySwiper2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #06b6d4;">
                                <div class="icon-wrapper" style="background-color: #ccfbf1;">
                                    <i class="fas fa-shield-alt text-cyan-600 text-xl"></i>
                                </div>
                                <h4 class="">Kesiapan Lebih Awal</h4>
                                <p class="">
                                    Dengan informasi prediksi yang cepat, masyarakat dapat mempersiapkan diri lebih awal, mengamankan barang berharga,
                                    dan merencanakan evakuasi jika diperlukan, mengurangi risiko kerugian material dan jiwa.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #06b6d4;">
                                <div class="icon-wrapper" style="background-color: #ccfbf1;">
                                    <i class="fas fa-check-circle text-cyan-600 text-xl"></i>
                                </div>
                                <h4 class="">Informasi Akurat & Terpercaya</h4>
                                <p class="">
                                    Kami memastikan data yang disajikan akurat dan diverifikasi, memberikan ketenangan pikiran bagi pengguna.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #06b6d4;">
                                <div class="icon-wrapper" style="background-color: #ccfbf1;">
                                    <i class="fas fa-users-cog text-cyan-600 text-xl"></i>
                                </div>
                                <h4 class="">Partisipasi Aktif Masyarakat</h4>
                                <p class="">
                                    Fitur pelaporan memungkinkan masyarakat menjadi bagian dari solusi, membantu pihak berwenang mendapatkan gambaran situasi yang lebih komprehensif di lapangan.
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="info-card" style="border-color: #06b6d4;">
                                <div class="icon-wrapper" style="background-color: #ccfbf1;">
                                    <i class="fas fa-lightbulb text-cyan-600 text-xl"></i>
                                </div>
                                <h4 class="">Peningkatan Kesadaran Bencana</h4>
                                <p class="">
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

            <p class="text-lg text-gray-700 text-center mt-8 max-w-4xl mx-auto">
                CeBan dikembangkan oleh tim mahasiswa dari Telkom University, dengan semangat untuk berkontribusi pada keselamatan dan kesejahteraan masyarakat.
                Kami terus berkomitmen untuk mengembangkan dan meningkatkan fitur-fitur CeBan demi Indonesia yang lebih tangguh.
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js" defer></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="" defer></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js" defer></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var swiper1 = new Swiper(".mySwiper1.swiper-container", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
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
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                }
            });

            var swiper2 = new Swiper(".mySwiper2.swiper-container", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
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
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                }
            });
        });
    </script>
@endsection