<?php
//start session
session_start();
include 'links.php'
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Backend | Add Menu</title>
</head>

<body style="font-family: 'Poppins', sans-serif; font-size: 20px;">
    <?php
    require_once "connection.php";

    $simpanLokasi = "SELECT * FROM lokasi"; #untuk execute 
    $hasilLokasi = $conn->query($simpanLokasi); #simpan hasil query
    ?>


    <!-- Content -->
    <div class="container">
        <div class="content" style=" padding-top: 12px; padding-bottom: 8px;">
            <h1 style="text-align: center;font-family: 'Poppins', sans-serif; font-size: xx-large;"><b>ADD EVENT</b></h1>
            <br>
            <hr>
            <br>
            <form class="form-group" action="inserting_event.php" method="post">
                <!--insert nama event-->
                <label for="namaEvent">Nama Event: </label>
                <input type="text" class="form-control" name="namaEvent">
                <br>
                <!--insert tanggal event-->
                <label for="tanggalEvent">Tanggal Event:</label>
                <input type="date" class="form-control" name="tanggal_event" id="tanggalEvent">
                <br>
                <label for="waktuEventMulai">Waktu Event:</label>
                <div class="form-inline">
                    <input type="time" class="form-control" name="waktu_event_mulai" id="waktuEventMulai">
                    <label for="waktuEventAkhir">&nbsp;-&nbsp;</label>
                    <input type="time" class="form-control" name="waktu_event_akhir" id="waktuEventAkhir">
                </div>
                <br>
                <label for="lokasiEvent">Lokasi Event</label>
                <br>
                <select name="select_box" class="form-select" id="select_box">
                    <option value="">Select Location</option>
                    <?php
                    while ($row = $hasilLokasi->fetch_assoc()) {
                        $id = $row['id_lokasi'];
                        $lokasi = "SELECT * FROM lokasi WHERE id_lokasi=$id";
                        $simpan = mysqli_query($conn, $lokasi);
                        $hasil1 = $simpan->fetch_assoc();
                        $hasil = $hasil1['nama_lokasi'];
                        //ambil id kelurahan dari table lokasi untuk tahu nama kelurahan
                        $idKelurahan = $hasil1['id_kelurahan'];
                        $kelurahan = mysqli_query($conn, "SELECT * FROM kelurahan WHERE id_kelurahan =$idKelurahan");
                        $hasilKelurahan = $kelurahan->fetch_assoc();

                        //ambil id kecamatan dari table kelurahan untuk tahu nama kecamatan
                        $idKecamatan = $hasilKelurahan['id_kecamatan'];
                        $kecamatan = mysqli_query($conn, "SELECT * FROM kecamatan WHERE id_kecamatan = $idKecamatan");
                        $hasilKecamatan = $kecamatan->fetch_assoc();

                        //ambil id kota dari table kecamatan untuk tahu nama kota
                        $idKota = $hasilKecamatan['id_kota'];
                        $kota = mysqli_query($conn, "SELECT * FROM kota WHERE id_kota = $idKota");
                        $hasilKota = $kota->fetch_assoc();

                        echo "<option name='pilihan' value='" . $id . "'>" . $row['nama_lokasi'] . ", " . $hasilKelurahan['nama_kelurahan'] . ", " . $hasilKecamatan['nama_kecamatan'] . ", " . $hasilKota['nama_kota'] . "</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select>
                <a href="insertLokasi.php"><small>Create location</small></a>
                <br>
                <br>
                <input class="btn btn-primary" type="submit" value="Add">
            </form>
        </div>
    </div>

    <script>
    </script>
</body>

</html>