<?php
include 'connection.php';
include 'links.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>EVENT</title>
    <style>
        .card a {
            color: black !important;
            text-decoration: none !important;
        }

        .btn:hover {
            transform: scale(1.02);
            transition: 0.5s;
            color: white;
        }

        .card:hover {
            transform: scale(1.04);
            transition: 0.3s;
        }

        .card-header {
            background-color: #88000278;
        }

        .card-body {
            background-color: #8800021c;
        }
    </style>
</head>

<body>
    <?php include 'usernavbar.php'; ?>
    <div class="container mt-5">
        <h1 style="text-align: center; margin-top: 100px;">EVENTS</h1>
        <div class="row justify-content-center">
            <div class="col-6 col-md-4 col-lg-2">
                <a type="button" class="btn btn-dark mt-5" href="insertevent.php" style="width: 100%;">+ Create Event</a>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
            <?php
            $sql = "SELECT * FROM event";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                //echo '<a type="button" class="btn stretched-link" id="addToCartButton" href="details.php?id='. $row["id"].'&rest_name='.$_SESSION['rest_name'].'">+ Add to cart</a>';

                //echo '<a href="eventDetails.php?id='.$row["id_event"].'">';
                echo '<div class="col-lg-4 col-md-6 mb-4">';
                echo '<div class="card h-100" id="event">';
                echo '<div class="card-header justify-content-center">';
                echo '<a class="stretched-link text-center" href="eventDetails.php?id=' . $row["id_event"] . '" class="card_title">';
                echo '<h2 class="card-title text-center" id="nama_event' . $row['id_event'] . '">' . $row['nama_event'] . '</h2></a></div>';
                //echo '<a href="detailEvent.php?id='". $row["id_event"].'&nama_event='.$_SESSION['nama_event'].'"></a>';
                // card body
                echo '<div class="card-body">';
                // Nama Event
                // echo '<h2 class="card-title text-center" id="nama_event' . $row['id_event'] . '">' . $row['nama_event'] . '</h2>';
                // tanggal event
                echo '<h5 class="card-title text-center" id="tgl_event' . $row['id_event'] . '">Date: ' . $row['tanggal_event'] . '</h5>';
                // Lokasi event
                $simpanId = $row['id_lokasi'];
                $lokasi = "SELECT nama_lokasi FROM lokasi WHERE id_lokasi=$simpanId";
                $simpan = mysqli_query($conn, $lokasi);
                $hasil = $simpan->fetch_assoc();
                $hasil = $hasil['nama_lokasi'];
                echo '<p class="card-title text-center" id="lokasi_event' . $row['id_event'] . '">Lokasi : ' . $hasil . '</p>';
                echo '</div>';
                echo '<a href="eventDetails.php?eventId=' . $row["id_event"] . '" class="stretched-link"></a>';
                // Closing div
                echo '</div></div>';
            }

            ?>
        </div>
    </div>


</body>