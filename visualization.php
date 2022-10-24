<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View RFM Segmentation</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<?php
$rec = "";
$freq = "";
$mon = "";
if (isset($_GET["recency"]) && isset($_GET["frequency"]) && isset($_GET["monetary"])) {
    $rec = $_GET["recency"];
    $freq = $_GET["frequency"];
    $mon = $_GET["monetary"];
}
?>

<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Donor Darah</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Data</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="visualization.php">RFM</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="row d-inline-block">
            <form class="form-inline" action="" method="get">
                <label>Recency</label>
                <input class="form-control ml-2 mr-3" type="number" min="0" max="1" step="any" name="recency" id="recencyValue" placeholder="0.0-1.0">
                <label>Frequency</label>
                <input class="form-control ml-2 mr-3" type="number" min="0" max="1" step="any" name="frequency" id="frequencyValue" placeholder="0.0-1.0">
                <label>Monetary</label>
                <input class="form-control ml-2 mr-3" type="number" min="0" max="1" step="any" name="monetary" id="monetaryValue" placeholder="0.0-1.0">
                <button type="submit" class="btn btn-warning">Generate Reports</button>
            </form>
        </div>
        <div class="row">
            <div class="jumbotron my-3" id="report">
                <?php
                    $response = "";

                    //kalau blm diisi
                    if ($rec == "" || $freq == "" || $mon == "") {
                        $response = "Please input RFM weights!";
                    }
                    //kalau lebih/kurang dari 1 total weightnya
                    else if ($rec + $freq + $mon != 1){
                        $response = "RFM weights must add up to 1";
                    }
                    else {
                        $response = '<center><iframe src="rfmrecency.html" height="800" width="1000" frameBorder="0"></iframe></center>';
                        //nanti bagian src diganti urlnya diagram yang dari python
                    }
                    echo $response;
                ?>
            </div>
        </div>
    </div>
</body>


</html>