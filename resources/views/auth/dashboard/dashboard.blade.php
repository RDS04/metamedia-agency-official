<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
        }

        .welcome-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .header-bg {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            padding: 50px 30px;
        }

        .menu-card {
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <!-- Welcome Section -->
        <div class="card shadow border-0 welcome-card mb-4">
            <div class="header-bg text-center">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <h1 class="fw-bold">
                    Selamat Datang 👋
                </h1>

                <p class="mb-0 fs-5">
                    Anda berhasil masuk ke sistem.
                </p>

            </div>

            <div class="card-body text-center">
                <h4 class="fw-bold">
                    Halo, {{ $user->name ?? 'Pengguna' }}
                </h4>

                <p class="text-muted">
                    Selamat bekerja dan semoga aktivitas Anda hari ini berjalan lancar.
                </p>
            </div>
        </div>

        <!-- Menu Dashboard -->
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0 menu-card">
                    <div class="card-body text-center">
                        <h2>👨‍🎓</h2>
                        <h5>Data Mahasiswa</h5>
                        <a href="" class="btn btn-primary mt-2">
                            Kelola Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 menu-card">
                    <div class="card-body text-center">
                        <h2>📚</h2>
                        <h5>Data Akademik</h5>
                        <a href="#" class="btn btn-success mt-2">
                            Lihat Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 menu-card">
                    <div class="card-body text-center">
                        <h2>⚙️</h2>
                        <h5>Pengaturan</h5>
                        <a href="#" class="btn btn-warning mt-2">
                            Kelola
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Statistik -->
        <div class="row mt-5">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-primary">150</h3>
                        <p>Total Mahasiswa</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-success">25</h3>
                        <p>Dosen</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-warning">10</h3>
                        <p>Kelas</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="text-danger">5</h3>
                        <p>Pengumuman</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>

</html>