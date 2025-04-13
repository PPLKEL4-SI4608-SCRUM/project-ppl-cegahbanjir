<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CeBan - Cegah Banjir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/img/flood-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            min-height: 500px;
        }
        .feature-icon {
            font-size: 40px;
            margin-bottom: 15px;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>CeBan</strong> | Cegah Banjir
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('home') }}">Dashboard</a></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">CeBan - Cegah Banjir</h1>
            <p class="lead mb-5">Solusi terpadu untuk pemantauan, prediksi, dan pencegahan bencana banjir di Indonesia</p>
            <div>
                <a href="#fitur" class="btn btn-primary btn-lg me-3">Pelajari Lebih Lanjut</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="fitur">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Fitur Utama</h2>
                <p class="lead text-muted">CeBan hadir dengan beragam fitur untuk membantu Anda mencegah dan mengantisipasi banjir</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="feature-icon">
                                <i class="bi bi-cloud-rain"></i>
                                <!-- Jika tidak menggunakan Bootstrap Icons, bisa diganti dengan teks -->
                                ☔
                            </div>
                            <h5 class="card-title">Pemantauan Curah Hujan</h5>
                            <p class="card-text">Pantau data curah hujan secara real-time dari berbagai stasiun pemantau di seluruh Indonesia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up"></i>
                                <!-- Alternatif teks -->
                                📈
                            </div>
                            <h5 class="card-title">Prediksi Potensi Banjir</h5>
                            <p class="card-text">Analisis data cuaca dan prediksi potensi banjir berdasarkan algoritma canggih dan data historis</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="feature-icon">
                                <i class="bi bi-bell"></i>
                                <!-- Alternatif teks -->
                                🔔
                            </div>
                            <h5 class="card-title">Sistem Peringatan Dini</h5>
                            <p class="card-text">Dapatkan notifikasi peringatan dini ketika terdapat potensi banjir di area Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light" id="tentang">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="fw-bold mb-4">Tentang CeBan</h2>
                    <p class="mb-4">CeBan (Cegah Banjir) adalah platform terpadu yang dirancang untuk membantu masyarakat dan pemerintah dalam upaya pencegahan dan mitigasi bencana banjir di Indonesia.</p>
                    <p class="mb-4">Dengan menggabungkan teknologi pemantauan cuaca terkini, analisis data, dan sistem prediksi, CeBan menyediakan informasi akurat dan tepat waktu untuk membantu pengguna mengambil tindakan yang diperlukan sebelum bencana terjadi.</p>
                    <p>CeBan dikembangkan oleh tim yang terdiri dari 6 ahli teknologi dan lingkungan yang berkomitmen untuk mengurangi dampak banjir di Indonesia.</p>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Statistik CeBan</h4>
                            <div class="mb-4">
                                <h5>500+</h5>
                                <p class="text-muted">Stasiun pemantau cuaca terintegrasi</p>
                            </div>
                            <div class="mb-4">
                                <h5>85%</h5>
                                <p class="text-muted">Tingkat akurasi prediksi</p>
                            </div>
                            <div>
                                <h5>15+</h5>
                                <p class="text-muted mb-0">Kota besar di Indonesia yang telah menggunakan CeBan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Siap Mencegah Banjir Bersama CeBan?</h2>
            <p class="lead mb-4">Daftar sekarang dan dapatkan akses ke semua fitur CeBan untuk membantu Anda dan masyarakat menghadapi potensi banjir</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="kontak">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Hubungi Kami</h2>
                <p class="lead text-muted">Punya pertanyaan? Jangan ragu untuk menghubungi tim CeBan</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h5><i class="bi bi-envelope me-2"></i> Email</h5>
                                <p class="mb-0">info@ceban.id</p>
                            </div>
                            <div class="mb-4">
                                <h5><i class="bi bi-telephone me-2"></i> Telepon</h5>
                                <p class="mb-0">+62 21 1234 5678</p>
                            </div>
                            <div>
                                <h5><i class="bi bi-geo-alt me-2"></i> Alamat</h5>
                                <p class="mb-0">Jl. Pemantau Cuaca No. 123, Jakarta Pusat, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>CeBan - Cegah Banjir</h5>
                    <p class="mb-0">© 2023 CeBan. Hak Cipta Dilindungi.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-white">Kebijakan Privasi</a></li>
                        <li class="list-inline-item"><a href="#" class="text-white">Syarat & Ketentuan</a></li>
                        <li class="list-inline-item"><a href="#" class="text-white">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>