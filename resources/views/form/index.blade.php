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

            <form action="{{ route('forms.store') }}" method="POST">
                @csrf
                <h3>Data Pribadi</h3>

                <div class="row">
                    <div class="input-group">
                        <label>Nama Lengkap</label>
                        <input name="name" type="text" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="input-group">
                        <label>NIK</label>
                        <input name="nik" type="text" placeholder="Masukkan NIK">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label>Tempat Lahir</label>
                        <input name="tempat_lahir" type="text" placeholder="Tempat lahir">
                    </div>

                    <div class="input-group">
                        <label>Tanggal Lahir</label>
                        <input name="tanggal_lahir" type="date">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option>Pilih Jenis Kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Agama</label>
                        <select name="agama">
                            <option>Pilih Agama</option>
                            <option>Islam</option>
                            <option>Kristen</option>
                            <option>Katolik</option>
                            <option>Hindu</option>
                            <option>Buddha</option>
                            <option>Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="4" placeholder="Masukkan alamat lengkap"></textarea>
                </div>

                <h3>Kontak</h3>

                <div class="row">
                    <div class="input-group">
                        <label>No. HP / WhatsApp</label>
                        <input name="no_hp" type="text" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input name="email" type="email" placeholder="email@example.com">
                    </div>
                </div>

                <h3>Data Pendidikan</h3>

                <div class="row">
                    <div class="input-group">
                        <label>Asal Sekolah</label>
                        <input name="asal_sekolah" type="text" placeholder="Nama sekolah">
                    </div>

                    <div class="input-group">
                        <label>Tahun Lulus</label>
                        <input name="tahun_lulus" type="number" placeholder="2025">
                    </div>
                </div>

                <div class="row">
                    <div class="input-group">
                        <label>Program Studi</label>
                        <select name="program_studi">
                            <option>Pilih Program Studi</option>
                            <option>Sistem Informasi</option>
                            <option>Teknik Informatika</option>
                            <option>Manajemen Informatika</option>
                            <option>Pendidikan Matematika</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Kelas</label>
                        <select name="kelas">
                            <option>Pilih Kelas</option>
                            <option>Reguler</option>
                            <option>Karyawan</option>
                            <option>Online</option>
                        </select>
                    </div>
                </div>

                <!-- <h3>Upload Berkas</h3>

                <div class="row">
                    <div class="input-group">
                        <label>Pas Foto</label>
                        <input name="pas_foto" type="file">
                    </div>

                    <div class="input-group">
                        <label>Ijazah</label>
                        <input name="ijazah" type="file">
                    </div>
                </div> -->

                <div class="checkbox">
                    <input name="setuju" type="checkbox" id="setuju">
                    <label for="setuju">
                        Saya menyatakan data yang saya isi benar dan dapat dipertanggungjawabkan.
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Daftar Sekarang
                </button>

            </form>
        </div>
    </div>

</body>

</html>