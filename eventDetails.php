<?php
include 'connection.php';
include 'links.php';
session_start();
$_SESSION['eventId'] = $_GET['eventId'];
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    <!-- <style>
        #hrEventDetails {
            border: 1.5px solid;
            border-radius: 10px;
            background: black;
        }
    </style> -->
    </head>
    <body>
        <?php
            include 'navbar.php';
            $sql = mysqli_query($conn, "SELECT * FROM event WHERE id_event = '{$_SESSION['eventId']}'");
            $hasil = $sql->fetch_assoc();
            ?>
            <div class="container">
                <div class="row">
                <h1 style="text-align: center;"><span id="ourEvent"> &nbsp;<?php echo $hasil['nama_event'] ?> &nbsp;</span></h1>
                </div>
                <br>
                <h3>Event Details</h3>
                <hr style="width:50%;text-align:left;margin-left:0">
                <div class="row">
                    <?php
                        //ambil waktu event dari table event
                        echo '<h3>Time&#9200;  </h3></div>';
                        echo '<div class="row"><p>'.$hasil['waktu_mulai_event'].'  -  '.$hasil['waktu_akhir_event'].'</p></div><br>';
                        //ambil lokasi id dari table event untuk tahu nama lokasi
                        $idLokasi = $hasil['id_lokasi']; #ganti bentar
                        $lokasi = mysqli_query($conn,"SELECT * FROM lokasi WHERE id_lokasi =$idLokasi");
                        $hasilLokasi = $lokasi->fetch_assoc();
                        echo '<div class="row"><h3>Address</h3></div>';
                        // echo '<div class="row"><p>'.$hasilLokasi['nama_lokasi'].' </p></div>';

                        //ambil id kelurahan dari table lokasi untuk tahu nama kelurahan
                        $idKelurahan = $hasilLokasi['id_kelurahan'];
                        $kelurahan = mysqli_query($conn,"SELECT * FROM kelurahan WHERE id_kelurahan =$idKelurahan");
                        $hasilKelurahan = $kelurahan->fetch_assoc();
                        // echo '<div class="row"> <h4>Kelurahan: '.$hasilKelurahan['nama_kelurahan'].' </h4></div>';

                        //ambil id kecamatan dari table kelurahan untuk tahu nama kecamatan
                        $idKecamatan = $hasilKelurahan['id_kecamatan'];
                        $kecamatan = mysqli_query($conn,"SELECT * FROM kecamatan WHERE id_kecamatan = $idKecamatan");
                        $hasilKecamatan = $kecamatan->fetch_assoc();
                        // echo '<div class="row"> <h4>Kecamatan: '.$hasilKecamatan['nama_kecamatan'].' </h4></div>';

                        //ambil id kota dari table kecamatan untuk tahu nama kota
                        $idKota = $hasilKecamatan['id_kota'];
                        $kota = mysqli_query($conn,"SELECT * FROM kota WHERE id_kota = $idKota");
                        $hasilKota = $kota->fetch_assoc();
                        // echo '<div class="row"> <h4>Kota: '.$hasilKota['nama_kota'].' </h4></div>';

                        echo '<p>Lokasi: '.$hasilLokasi['nama_lokasi'].', '.$hasilKelurahan['nama_kelurahan'].', '.$hasilKecamatan['nama_kecamatan'].', '.$hasilKota['nama_kota'].'</p></div><hr>';
                    ?>
                <!-- <div class="row">
                    <p>Total Pendonor: </p>
                </div>
                <div class="row">
                    <p>Total Golongan Darah A yang terkumpul: </p>
                </div> -->
                <!-- <div class="row">
                    <button>lihat daftar pendonor</button>
                </div> -->
                <br>
                <div class="row">
                    <div class="col mx-4">
                        <a type="button" class="btn btn-primary" href="broadcast.php">Sent Broadcast</a>
                        <a class="btn" href="displayAllEvent.php">Back</a>
                    <!-- <a type="button" class="btn btn-secondary" href="insertevent.php">Duplicate</a> -->
                    </div>
                </div>
            </div>

            <?php

            mysqli_close($conn);
        ?>
    </body>
</html>