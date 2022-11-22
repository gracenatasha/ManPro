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
$command = escapeshellcmd('rfmgraph.py');
$page = $rec = $freq = $mon = $freq1 = $freq2 = $freq3 = $freqall = $mon1 = $mon2 = $mon3 = $monall = "";
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}

if (isset($_POST["generate"])) {
    $rec = $_POST["recency"];
    $freq = $_POST["frequency"];
    $mon = $_POST["monetary"];
    $freq1 = $_POST["f1"];
    $freq2 = $_POST["f2"];
    $freq3 = $_POST["f3"];
    $freqall = $_POST["fall"];
    $mon1 = $_POST["m1"];
    $mon2 = $_POST["m2"];
    $mon3 = $_POST["m3"];
    $monall = $_POST["mall"];
    //echo "Rec: " . $rec . " Freq: " . $freq . " Mon: " . $mon;
    //echo "Freq1: " . $freq1 . " Freq2: " . $freq2 . " Freq 3: " . $freq3 . " Freq All: " . $freqall;
    //echo "Mon1: " . $mon1 . " Mon2: " . $mon2 . " Mon 3: " . $mon3 . " Mon All: " . $monall;
    $output = shell_exec("/usr/local/bin/python3 $command $rec $freq $mon $freq1 $freq2 $freq3 $freqall $mon1 $mon2 $mon3 $monall");
} else {
    $output = shell_exec("/usr/local/bin/python3 $command");
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
                    <a class="nav-link" href="displayAllEvent.php">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="data.php">Data</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="visualization.php">RFM</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="row d-inline-block">
            <div class="btn-group" role="group">
                <a href="visualization.php?page=recency" class="<?php if ($page == 'recency' || $page == "") {
                                                                    echo 'btn btn-primary';
                                                                } else {
                                                                    echo 'btn btn-secondary';
                                                                } ?>">Recency</a>
                <a href="visualization.php?page=frequency" class="<?php if ($page == 'frequency') {
                                                                        echo 'btn btn-primary';
                                                                    } else {
                                                                        echo 'btn btn-secondary';
                                                                    } ?>">Frequency</a>
                <a href="visualization.php?page=monetary" class="<?php if ($page == 'monetary') {
                                                                        echo 'btn btn-primary';
                                                                    } else {
                                                                        echo 'btn btn-secondary';
                                                                    } ?>">Monetary</a>
            </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Edit Weights
            </button>

            <!-- Modal -->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <!--FORM-->
                    <form action="visualization.php" method="POST">
                        <div class="modal-content">

                            <!--MODAL HEADER-->
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit RFM Weights</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!--MODAL BODY-->
                            <div class="modal-body">
                                <div class="form-group">

                                    <div id="accordion">
                                        <!--RECENCY-->
                                        <div class="card-header" data-toggle="collapse" data-target="#collapseZero">
                                            <form class="form-inline">
                                                <div class="form-group mx-sm-3 mb-2">
                                                    <label class="mr-3">Recency</label>
                                                    <input class="form-control" type="number" min="0" max="1" step="0.1" name="recency" id="recencyValue" placeholder="0.0-1.0">
                                                </div>
                                            </form>
                                        </div>

                                        <!--FREQUENCY-->
                                        <div class="card-header" data-toggle="collapse" data-target="#collapseOne">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label class="mr-3">Frequency</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="frequency" id="frequencyValue" placeholder="0.0-1.0">
                                            </div>
                                        </div>
                                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <label>Past year</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="f1" id="frequency1" placeholder="Past year">
                                                <label>Past 2 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="f2" id="frequency2" placeholder="Past 2 years">
                                                <label>Past 3 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="f3" id="frequency3" placeholder="Past 3 years">
                                                <label>All</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="fall" id="frequencyAll" placeholder="All">
                                            </div>
                                        </div>


                                        <!--MONETARY-->
                                        <div class="card-header" data-toggle="collapse" data-target="#collapseTwo">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label class="mr-3">Monetary</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="monetary" id="monetaryValue" placeholder="0.0-1.0">
                                            </div>
                                        </div>
                                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <label>Past year</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="m1" id="monetary1" placeholder="Past year">
                                                <label>Past 2 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="m2" id="monetary2" placeholder="Past 2 years">
                                                <label>Past 3 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="m3" id="monetary3" placeholder="Past 3 years">
                                                <label>All</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.1" name="mall" id="monetaryAll" placeholder="All">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!--SUBMIT-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" name="generate" value="Generate Reports"></input>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="jumbotron my-3" id="report">
                <?php
                if ($page == "") {
                    $src = "rfmrecency.html";
                } else {
                    $src = "rfm$page.html";
                }

                $response = "<center><iframe src='$src' height='800' width='1000' frameBorder='0'></iframe></center>";

                echo $response;
                ?>
            </div>
        </div>
    </div>

</body>


</html>