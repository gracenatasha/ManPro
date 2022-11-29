<?php
require 'functions.php';

$id = $_GET["id"];

$data_donor = query("SELECT * FROM donor WHERE id_event = $id");

if (isset($_POST["tambah"])) {
    if (tambah($_POST) > 0) {
        echo "<script>
				alert('data berhasil ditambahkan!');
				document.location.href = 'table.php';
			  </script>";
    } else {
        echo "<script>
				alert('data gagal ditambahkan!');
				document.location.href = 'cariEvent.php';
			  </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cari Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <br><br><br>

    <h1>Tambah Data Donor</h1>

    <div class="card" style=" width: 50rem;">
        <div class="card-body">
            <form action="" method="post" class="row g-3">
                <div class="col-md-6">
                    <label for="id_event" class="form-label"> ID Event </label>
                    <input type="text" class="form-control" id="id_event" name="id_event" value="<?= $id ?>">
                </div>
                <div class="col-md-6">
                    <label for="id_pendonor" class="form-label">ID Pendonor</label>
                    <input type="text" class="form-control" id="id_pendonor" name="id_pendonor">
                </div>
                <div class="col-md-6">
                    <label for="jumlah_darah" class="form-label">Jumlah Darah (cc)</label>
                    <input type="text" class="form-control" id="id_pendonor" name="jumlah_darah">
                </div>
                <button type="submit" class="btn btn-primary" name="tambah"> Tambah Data! </button>
            </form>
        </div>
    </div>

    <script src="jquery-3.1.1.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"> </script>
</body>

</html>