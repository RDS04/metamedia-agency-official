<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f4f7fc;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .form-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header h1 {
            color: #1f3c88;
            margin-bottom: 10px;
        }

        .header p {
            color: #777;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 15px;
            color: #1f3c88;
            border-left: 5px solid #1f3c88;
            padding-left: 10px;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        input,
        select,
        textarea {
            padding: 12px 15px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            outline: none;
            transition: .3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #1f3c88;
            box-shadow: 0 0 8px rgba(31, 60, 136, .2);
        }

        .checkbox {
            margin-top: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .btn-submit {
            width: 100%;
            margin-top: 25px;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: #1f3c88;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
        }

        .btn-submit:hover {
            background: #16306f;
        }

        @media(max-width:768px) {
            .row {
                flex-direction: column;
            }

            .form-card {
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>Pendaftaran Mahasiswa Agent</h1>
                <p>Silakan lengkapi data berikut dengan benar.</p>
            </div>

            <form action="{{ route('form.update', $mahasiswa->id) }}" method="POST">
                @csrf

                <h3>Data Pribadi</h3>

                <div class="row">
                    <div class="input-group">
                        <label>Nama Lengkap</label>
                        <input name="name" type="text" placeholder="Masukkan nama lengkap"
                            value="{{ $mahasiswa->name }}">
                    </div>

                    <div class="input-group">
                        <label>NIK</label>
                        <input name="nik" type="text" placeholder="Masukkan NIK" value="{{ $mahasiswa->nik }}">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label>Tempat Lahir</label>
                        <input name="tempat_lahir" type="text" placeholder="Tempat lahir"
                            value="{{ $mahasiswa->tempat_lahir }}">
                    </div>

                    <div class="input-group">
                        <label>Tanggal Lahir</label>
                        <input name="tanggal_lahir" type="date" value="{{ $mahasiswa->tanggal_lahir }}">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label>Jenis Kelamin</label>

                        <select name="jenis_kelamin">
                            <option value="">Pilih Jenis Kelamin</option>

                            <option value="Laki-laki" {{ $mahasiswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan" {{ $mahasiswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Agama</label>

                        <select name="agama">
                            <option value="">Pilih Agama</option>

                            <option value="Islam" {{ $mahasiswa->agama == 'Islam' ? 'selected' : '' }}>
                                Islam
                            </option>

                            <option value="Kristen" {{ $mahasiswa->agama == 'Kristen' ? 'selected' : '' }}>
                                Kristen
                            </option>

                            <option value="Katolik" {{ $mahasiswa->agama == 'Katolik' ? 'selected' : '' }}>
                                Katolik
                            </option>

                            <option value="Hindu" {{ $mahasiswa->agama == 'Hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>

                            <option value="Buddha" {{ $mahasiswa->agama == 'Buddha' ? 'selected' : '' }}>
                                Buddha
                            </option>

                            <option value="Konghucu" {{ $mahasiswa->agama == 'Konghucu' ? 'selected' : '' }}>
                                Konghucu
                            </option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label>Alamat Lengkap</label>

                    <textarea name="alamat" rows="4"
                        placeholder="Masukkan alamat lengkap">{{ $mahasiswa->alamat }}</textarea>
                </div>

                <h3>Kontak</h3>

                <div class="row">
                    <div class="input-group">
                        <label>No. HP / WhatsApp</label>

                        <input name="no_hp" type="text" placeholder="08xxxxxxxxxx" value="{{ $mahasiswa->no_hp }}">
                    </div>

                    <div class="input-group">
                        <label>Email</label>

                        <input name="email" type="email" placeholder="email@example.com"
                            value="{{ $mahasiswa->email }}">
                    </div>
                </div>

                <h3>Data Pendidikan</h3>

                <div class="row">
                    <div class="input-group">
                        <label>Asal Sekolah</label>

                        <input name="asal_sekolah" type="text" placeholder="Nama sekolah"
                            value="{{ $mahasiswa->asal_sekolah }}">
                    </div>

                    <div class="input-group">
                        <label>Tahun Lulus</label>

                        <input name="tahun_lulus" type="number" placeholder="2025"
                            value="{{ $mahasiswa->tahun_lulus }}">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label>Program Studi</label>

                        <select name="program_studi">
                            <option value="">Pilih Program Studi</option>

                            <option value="Sistem Informasi" {{ $mahasiswa->program_studi == 'Sistem Informasi' ? 'selected' : '' }}>
                                Sistem Informasi
                            </option>

                            <option value="Teknik Informatika" {{ $mahasiswa->program_studi == 'Teknik Informatika' ? 'selected' : '' }}>
                                Teknik Informatika
                            </option>

                            <option value="Manajemen Informatika" {{ $mahasiswa->program_studi == 'Manajemen Informatika' ? 'selected' : '' }}>
                                Manajemen Informatika
                            </option>

                            <option value="Pendidikan Matematika" {{ $mahasiswa->program_studi == 'Pendidikan Matematika' ? 'selected' : '' }}>
                                Pendidikan Matematika
                            </option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Kelas</label>

                        <select name="kelas">
                            <option value="">Pilih Kelas</option>

                            <option value="Reguler" {{ $mahasiswa->kelas == 'Reguler' ? 'selected' : '' }}>
                                Reguler
                            </option>

                            <option value="Karyawan" {{ $mahasiswa->kelas == 'Karyawan' ? 'selected' : '' }}>
                                Karyawan
                            </option>

                            <option value="Online" {{ $mahasiswa->kelas == 'Online' ? 'selected' : '' }}>
                                Online
                            </option>
                        </select>
                    </div>
                </div>

                <div class="checkbox">
                    <input type="checkbox" name="setuju" id="setuju" value="1" {{ $mahasiswa->setuju ? 'checked' : '' }}>

                    <label for="setuju">
                        Saya menyatakan data yang saya isi benar dan dapat dipertanggungjawabkan.
                    </label>
                </div>

                <a href="{{ route('showName') }}" class="btn-submit"
                    style="display:block;text-align:center;text-decoration:none;background:#6c757d;margin-top:10px;">
                    daftar lagi
                </a>

            </form>
        </div>
    </div>

</body>

</html>