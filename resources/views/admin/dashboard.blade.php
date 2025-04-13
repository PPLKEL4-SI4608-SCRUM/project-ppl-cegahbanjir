<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CeBan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">CeBan Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button" data-bs-toggle="dropdown">
                            Manajemen Data Cuaca
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.weather.stations.index') }}">Stasiun Cuaca</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.weather.rainfall.index') }}">Data Curah Hujan</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.weather.predictions.index') }}">Prediksi Potensi Banjir</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.weather.parameters.index') }}">Parameter Peringatan</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('home') }}">User Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Admin Dashboard</div>
                    <div class="card-body">
                        <h5>Selamat datang, Admin {{ Auth::user()->name }}!</h5>
                        <p>Ini adalah panel admin CeBan (Cegah Banjir).</p>
                        
                        <h6 class="mt-4">Quick Links:</h6>
                        <div class="row mt-3">
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Stasiun Cuaca</h5>
                                        <p class="card-text">Kelola stasiun cuaca</p>
                                        <a href="{{ route('admin.weather.stations.index') }}" class="btn btn-primary">Akses</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Data Curah Hujan</h5>
                                        <p class="card-text">Input dan edit data curah hujan</p>
                                        <a href="{{ route('admin.weather.rainfall.index') }}" class="btn btn-primary">Akses</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Prediksi Banjir</h5>
                                        <p class="card-text">Kelola prediksi potensi banjir</p>
                                        <a href="{{ route('admin.weather.predictions.index') }}" class="btn btn-primary">Akses</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Parameter Peringatan</h5>
                                        <p class="card-text">Atur parameter peringatan banjir</p>
                                        <a href="{{ route('admin.weather.parameters.index') }}" class="btn btn-primary">Akses</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>