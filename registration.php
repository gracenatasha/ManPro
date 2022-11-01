<?php

require 'connect_db.php';
require 'functions.php';

if (isset($_POST["btnRegister"])) {
    $golongan_darah = $_POST['golongan_darah'];


    if (empty($golongan_darah)) {
        $msg = 'Pilih golongan darah';
    } else {

        if (registrasi($_POST) > 0) {
            echo "<script>
                    alert('new user added!');
                    </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
}


if (isset($_POST['data_json']) && $_POST['data_json'] == 'kecamatan') {
    $id_kota = mysqli_real_escape_string($conn, $_POST['id_kota']);
    $get_kecamatan = mysqli_query($conn, "SELECT id_kecamatan, nama_kecamatan FROM kecamatan WHERE id_kota = '$id_kota' ORDER BY id_kecamatan ASC");

    while ($kecamatan = mysqli_fetch_object($get_kecamatan))
        echo '<option value="' . $kecamatan->id_kecamatan . '">' . $kecamatan->nama_kecamatan . '</option>';

    exit;
}

if (isset($_POST['data_json']) && $_POST['data_json'] == 'kelurahan') {
    $id_kecamatan = mysqli_real_escape_string($conn, $_POST['id_kecamatan']);
    $get_kelurahan = mysqli_query($conn, "SELECT id_kelurahan, nama_kelurahan FROM kelurahan WHERE id_kecamatan = '$id_kecamatan ' ORDER BY id_kelurahan ASC");

    while ($kelurahan = mysqli_fetch_object($get_kelurahan))
        echo '<option value="' . $kelurahan->id_kelurahan . '">' . $kelurahan->nama_kelurahan . '</option>';

    exit;
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRATION PAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css'>
    <link rel='stylesheet' href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">

                    <div class="card-header text-center">
                        REGISTRATION PAGE
                    </div>

                    <div class="card-body">
                        <?= isset($msg) ? $msg : '' ?>

                        <form method="post" action="">

                            <!-- NAMA PENDONOR -->
                            <label for="nama_pendonor" class="form-label">Nama</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg>

                                </span>

                                <input type="text" class="form-control" id="nama_pendonor" name="nama_pendonor" require placeholder="Masukkan nama anda" aria-describedby="basic-addon3">

                            </div>

                            <!-- TANGGAL LAHIR -->
                            <label for="date">Tanggal Lahir</label>
                            <div class="input-group mb-3 date" id="datepicker">

                                <span class="input-group-append" id="basic-addon3">

                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa-solid fa-calendar"></i>
                                    </span>

                                </span>

                                <input type="text" class="form-control" id="date" name="date_donor" placeholder="Masukkan Tanggal lahir" aria-describedby="basic-addon3" />
                            </div>
                            
                            <!-- EMAIL -->
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-envelope"></i>

                                </span>

                                <input type="text" class="form-control" id="email" name="email" require placeholder="Masukkan email" aria-describedby="basic-addon3">

                            </div>

                            <!-- GOLONGAN DARAH -->
                            <label for="bloodType" class="form-label">Golongan darah</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">
                                    <i class="fa-solid fa-droplet"></i>
                                </span>

                                <?php $arrGol = ['O', 'A', 'B', 'AB']; ?>
                                <select class="form-select" name="golongan_darah">

                                    <?php if (!isset($_POST['golongan_darah'])) : ?>

                                        <option value="">Pilih Golongan Darah</option>

                                    <?php endif;

                                    foreach ($arrGol as $data) : ?>

                                        <option value="<?= $data ?>"><?= $data ?></option>

                                    <?php endforeach ?>

                                </select>

                            </div>

                            <!-- JENIS KELAMIN -->
                            <label for="sex" class="form-label">Jenis Kelamin</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">
                                    <i class="fa-solid fa-mars-and-venus"></i>
                                </span>

                                <?php $arrGender = ['P', 'L']; ?>
                                <select class="form-select" name="gender">

                                    <?php if (!isset($_POST['gender'])) : ?>

                                        <option value="">Pilih Jenis Kelamin</option>

                                    <?php endif;

                                    foreach ($arrGender as $data) : ?>

                                        <option value="<?= $data ?>"><?= $data ?></option>

                                    <?php endforeach ?>

                                </select>

                            </div>

                            <!-- RHESUS -->
                            <label for="sex" class="form-label">Rhesus</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-plus-minus"></i>

                                </span>

                                <?php $arrGender = ['+', '-']; ?>
                                <select class="form-select" name="rhesus">

                                    <?php if (!isset($_POST['rhesus'])) : ?>

                                        <option value="">Pilih Rhesus</option>

                                    <?php endif;

                                    foreach ($arrGender as $data) : ?>

                                        <option value="<?= $data ?>"><?= $data ?></option>

                                    <?php endforeach ?>

                                </select>

                            </div>

                            <!-- ALAMAT -->
                            <label for="alamat" class="form-label">Alamat Rumah</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-house"></i>

                                </span>

                                <input type="text" class="form-control" id="alamat" name="alamat" require placeholder="Masukkan alamat" aria-describedby="basic-addon3">

                            </div>

                            <!-- KOTA -->
                            <label for="kota" class="form-label">Kota</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-house"></i>

                                </span>


                                <?php

                                $data_kota = mysqli_query($conn, "SELECT id_kota, nama_kota FROM kota ORDER BY id_kota ASC");

                                ?>

                                <select class="form-select" name="kota" id="kota-select">

                                    <option value="">Pilih Kota</option>

                                    <?php while ($kot = mysqli_fetch_object($data_kota)) : ?>

                                        <option value="<?= htmlspecialchars($kot->id_kota) ?>"><?= htmlspecialchars($kot->nama_kota) ?></option>

                                    <?php endwhile ?>
                                </select>

                            </div>

                            <!-- KECAMATAN -->
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-house"></i>

                                </span>

                                <select class="form-select" name="kecamatan" id="kecamatan-select">

                                    <option value="">Pilih Kecamatan</option>


                                </select>

                            </div>

                            <!-- KELURAHAN -->
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-house"></i>

                                </span>

                                <select class="form-select" name="kelurahan" id="kelurahan-select">
                                    <option value="">Pilih Kelurahan</option>
                                </select>

                            </div>

                            <!-- ALAMAT KANTOR -->
                            <label for="alamatKantor" class="form-label">Alamat Kantor</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-building"></i>

                                </span>

                                <input type="text" class="form-control" id="alamatKantor" name="alamatKantor" require placeholder="Masukkan alamat kantor" aria-describedby="basic-addon3">

                            </div>

                            <!-- KOTA KANTOR -->
                            <label for="kota" class="form-label">Kota kantor</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-building"></i>

                                </span>


                                <?php

                                $data_kota = mysqli_query($conn, "SELECT id_kota, nama_kota FROM kota ORDER BY id_kota ASC");

                                ?>
                                
                                <select class="form-select" name="kotaKantor" id="kotaKantor-select">

                                    <option value="">Pilih Kota</option>

                                    <?php while ($kot = mysqli_fetch_object($data_kota)) : ?>

                                        <option value="<?= htmlspecialchars($kot->id_kota) ?>"><?= htmlspecialchars($kot->nama_kota) ?></option>

                                    <?php endwhile ?>
                                </select>
                            </div>

                            <!-- KECAMATAN KANTOR -->
                            <label for="kecamatan" class="form-label">Kecamatan kantor</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-building"></i>

                                </span>

                                <select class="form-select" name="kecamatanKantor" id="kecamatanKantor-select">

                                    <option value="">Pilih Kecamatan Kantor</option>


                                </select>
                            </div>

                            <!-- KELURAHAN KANTOR -->
                            <label for="kelurahan" class="form-label">Kelurahan Kantor</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-building"></i>

                                </span>

                                <select class="form-select" name="kelurahanKantor" id="kelurahanKantor-select">
                                    <option value="">Pilih Kelurahan</option>
                                </select>

                            </div>

                            <!-- TELEPON -->
                            <label for="telp" class="form-label">Telepon</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <i class="fa-solid fa-phone"></i>

                                </span>

                                <input type="text" class="form-control" id="telp" name="telp" require placeholder="Masukkan No. Telp" aria-describedby="basic-addon3">

                            </div>

                            <!-- PASSWORD -->
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                    </svg>

                                </span>

                                <input type="password" class="form-control" id="password" name="password" require placeholder="Enter password" aria-describedby="basic-addon3">

                            </div>

                            <!-- CONFIRM PASSWORD -->
                            <label for="password" class="form-label">Confirm Password</label>
                            <div class="input-group mb-3">

                                <span class="input-group-text" id="basic-addon3">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                    </svg>

                                </span>

                                <input type="password" class="form-control" id="password2" name="password2" require placeholder="Enter password" aria-describedby="basic-addon3">

                            </div>

                            <!-- BUTTON REGISTER -->
                            <div class="row mb-3">
                                <button class="btn btn-primary" name="btnRegister">
                                    REGISTER
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'></script>
    <script>
        $(function() {
            $('#datepicker').datepicker();

            $('#kota-select').change(function() {
                const id_kota = $(this).val();

                $.ajax({
                    url: 'registration.php',
                    type: 'POST',
                    data: 'data_json=kecamatan&id_kota=' + id_kota,
                    success: function(e) {
                        $('#kecamatan-select').append(e)
                    }
                })
            });

            $('#kecamatan-select').change(function() {
                const id_kecamatan = $(this).val();

                $.ajax({
                    url: 'registration.php',
                    type: 'POST',
                    data: 'data_json=kelurahan&id_kecamatan=' + id_kecamatan,
                    success: function(e) {
                        $('#kelurahan-select').append(e)
                    }
                })

            })

            $('#kotaKantor-select').change(function() {
                const id_kota = $(this).val();

                $.ajax({
                    url: 'registration.php',
                    type: 'POST',
                    data: 'data_json=kecamatan&id_kota=' + id_kota,
                    success: function(e) {
                        $('#kecamatanKantor-select').append(e)
                    }
                })

            });

            $('#kecamatanKantor-select').change(function() {
                const id_kecamatan = $(this).val();

                $.ajax({
                    url: 'registration.php',
                    type: 'POST',
                    data: 'data_json=kelurahan&id_kecamatan=' + id_kecamatan,
                    success: function(e) {
                        $('#kelurahanKantor-select').append(e)
                    }
                })

            })

        });
    </script>

</body>

</html>