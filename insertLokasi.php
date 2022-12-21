<?php
    include 'links.php';
    require 'functions.php';
    if (isset($_POST["btnAdd"])) {
            if (addLokasi($_POST) > 0) {
                echo "<script>
                        alert('new location added!');
                        document.location.href = 'insertevent.php';
                        </script>";
                
            } else {
                echo mysqli_error($conn);
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

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css'>
    <link rel='stylesheet' href=https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css>
        <title>Backend | Add Lokasi</title>
    </head>
    <body style="font-family: 'Poppins', sans-serif; font-size: 20px;">

        <!-- Content -->
        <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">

                    <div class="card-header text-center">
                        ADD LOCATION
                    </div>

                    <div class="card-body">
                         

                        <form method="post" action="">
                <label for="namaLokasi">Nama Lokasi: </label> 
                <input type="text" name="namaLokasi">
                <br>
                <br>
                <!--insert kota -->
                <label for="kota" class="form-label">Kota</label>
                            <div class="input-group mb-3">

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
                                <select class="form-select" name="kecamatan" id="kecamatan-select">

                                    <option value="">Pilih Kecamatan</option>


                                </select>

                            </div>

                            <!-- KELURAHAN -->
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <div class="input-group mb-3">
                                <select class="form-select" name="idKelurahan" id="kelurahan-select">
                                    <option value="">Pilih Kelurahan</option>
                                </select>

                            </div>
           
                <br>
                <button name="btnAdd" class="btn btn-primary">Add</button>
     
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
            $('#kota-select').change(function() {
                const id_kota = $(this).val();

                $.ajax({
                    url: 'insertLokasi.php',
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
                    url: 'insertLokasi.php',
                    type: 'POST',
                    data: 'data_json=kelurahan&id_kecamatan=' + id_kecamatan,
                    success: function(e) {
                        $('#kelurahan-select').append(e)
                    }
                })

            })


        });
        </script>
    </body>
</html>

