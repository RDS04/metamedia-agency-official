<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">

                <div class="card shadow border-0">
                    <div class="card-body text-center p-5">

                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#198754"
                                class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.08.022l3.992-4.99a.75.75 0 1 0-1.172-.938L7.477 9.417 5.383 7.323a.75.75 0 0 0-1.06 1.06l2.647 2.647z" />
                            </svg>
                        </div>

                        <h2 class="fw-bold text-success">
                            Selamat!
                        </h2>

                        <p class="fs-5 mt-3">
                            Anda telah berhasil terdaftar.
                        </p>

                        <p class="text-muted">
                            Terima kasih telah melakukan pendaftaran. Data Anda telah kami terima dan akan segera
                            diproses.
                        </p>

                        <div class="mt-4">
                            <a href="{{ route('showName') }}" class="btn btn-success px-4">
                                Kembali ke Beranda
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            window.location.href =
                "{{ route('show', $mahasiswa->id) }}";
        }, 5000);
    </script>
</body>

</html>