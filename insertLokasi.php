<?php
    //start session
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <title>Backend | Add Lokasi</title>
    </head>
    <body style="font-family: 'Poppins', sans-serif; font-size: 20px;">

        <?php 
            require_once "connection.php";

            $simpanKelurahan = "SELECT * FROM kelurahan"; #untuk execute 
            $hasilKelurahan = $conn->query($simpanKelurahan); #simpan hasil query
        ?> 

        <!-- Content -->
        <div class="container">
        <div class="content" style="padding-top: 12px; padding-bottom: 8px;">
            <h1 style="text-align: center;font-family: 'Poppins', sans-serif; font-size: xx-large;"><b>ADD LOKASI</b></h1>
            <br>
            <form action="inserting_lokasi.php" method="post">
                <!--insert nama lokasi-->
                <label for="namaLokasi">Nama Lokasi: </label> 
                <input type="text" name="namaLokasi">
                <br>
                <br>
                <!--insert kota-->
                <select name="select_box_lokasi" class="form-select" id="select_box_lokasi">
                    <option value="">Pilih Kelurahan,Kecamatan,Kota</option>
                <?php
                            while($row = $hasilKelurahan->fetch_assoc()) {
                                $idKecamatan = $row['id_kecamatan'];
                                $kecamatan = "SELECT * FROM kecamatan WHERE id_kecamatan=$idKecamatan";
                                $simpan = mysqli_query($conn,$kecamatan);
                                $hasilKecamatan = $simpan->fetch_assoc();
                                $hasilAkhirKecamatan = $hasilKecamatan['nama_kecamatan'];
                                $tempKota = $hasilKecamatan['id_kota'];
                                $kota = "SELECT nama_kota FROM kota WHERE id_kota=$tempKota";
                                $simpanKota = mysqli_query($conn,$kota);
                                $hasilKota = $simpanKota->fetch_assoc();
                                $hasilKota = $hasilKota['nama_kota'];
                                echo "<option value='".$row['id_kelurahan']."'>".$row['nama_kelurahan'].", ".$hasilAkhirKecamatan.", ".$hasilKota."</option>";
                            }
                            mysqli_close($conn);
                    ?>
                </select>
                <br>
                <input class="btn btn-primary" type="submit" value="Add"> 
            </form>
        </div>
        </div>

        <script>
        </script>
    </body>
</html>

