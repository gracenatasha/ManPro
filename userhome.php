<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Home</title>
</head>

<body>
    <?php
    session_start();
    include "usernavbar.php";
    include "links.php";
    include "connection.php";

    $sql = "SELECT * FROM pendonor WHERE id_pendonor = " . $_SESSION['id'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    //RECENCY
    $sqlrec = "SELECT e.tanggal_event, d.jumlah_darah, e.nama_event FROM donor d JOIN event e ON d.id_event = e.id_event WHERE e.tanggal_event IN (SELECT max(e.tanggal_event) FROM donor d JOIN event e ON d.id_event = e.id_event WHERE d.id_pendonor = ". $_SESSION['id'].") AND id_pendonor= ". $_SESSION['id'];
    //FREQUENCY
    $sqlfreq1 = "SELECT COUNT(id_donor) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = " . $_SESSION['id'] . " AND FLOOR(DATEDIFF(SYSDATE(), e.tanggal_event)/365) <= 1 GROUP BY id_pendonor";
    $sqlfreq2 = "SELECT COUNT(id_donor) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = " . $_SESSION['id'] . " AND FLOOR(DATEDIFF(SYSDATE(), e.tanggal_event)/365) <= 2 GROUP BY id_pendonor";
    $sqlfreq3 = "SELECT COUNT(id_donor) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = " . $_SESSION['id'] . " AND FLOOR(DATEDIFF(SYSDATE(), e.tanggal_event)/365) <= 3 GROUP BY id_pendonor";
    //MONETARY
    $sqlmon = "SELECT SUM(jumlah_darah) FROM `donor` d JOIN `event` e ON d.id_event = e.id_event WHERE id_pendonor = ". $_SESSION['id'] ." GROUP BY d.id_pendonor";

    //FETCH
    $rec = mysqli_fetch_row(mysqli_query($conn, $sqlrec));
    $freq1 = mysqli_fetch_row(mysqli_query($conn, $sqlfreq1));
    $freq2 = mysqli_fetch_row(mysqli_query($conn, $sqlfreq2));
    $freq3 = mysqli_fetch_row(mysqli_query($conn, $sqlfreq3));
    $mon = mysqli_fetch_row(mysqli_query($conn, $sqlmon));
    
    ?>

    <div class="container">
        <div class="row">
            <div class="jumbotron pl-3">
                <h1>Welcome, <?php echo $_SESSION["name"] ?>!</h1>
                <small>Blood Type: <?php echo $row["golongan_darah"] . $row["rhesus"] ?></small>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Your last donor activity:</h6>
                        <h1><?php echo $rec[0]?></h1>
                        <h7>You donated <b><?php echo $rec[1]."cc "?></b> of blood in event <b> <?php echo $rec[2]?></b></h7>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h6>You have donated a total of</h6>
                        <h1><?php echo $mon[0]?> cc</h1>
                        <h6>of blood in the past years! Let's keep donating!</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var xValues = ["Past year", "Past 2 years", "Past 3 years"];
    var yValues = [<?php echo $freq1[0] ?>, <?php echo $freq2[0] ?>, <?php echo $freq3[0] ?>];
    var barColors = ["red", "blue", "orange"];

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "<?php echo $_SESSION["name"] ?>'s Blood Drive Frequency in the Past Years"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</html>