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
    <style type="text/css">
        .btn-primary {
            background-color: #817582 !important;
            border-color: #817582 !important;
        }
    </style>
</head>


<?php
$command = escapeshellcmd('rfmmodif.py');
$rec = $freq = $mon = $freq1 = $freq2 = $freq3 = $freqall = $mon1 = $mon2 = $mon3 = $monall = "";
include 'links.php';

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
    <?php
    include 'navbar.php';
    ?>
    <div>
        <div class="container-lg mt-5 mx-auto pt-5">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Edit Weights
            </button>

            <!-- Modal -->

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <!--FORM-->
                    <form action="data.php" method="POST">
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
                                                    <input class="form-control" type="number" min="0" max="1" step="0.01" name="recency" id="recencyValue" placeholder="0.0-1.0" value="<?php echo $rec ?>">
                                                </div>
                                            </form>
                                        </div>

                                        <!--FREQUENCY-->
                                        <div class="card-header" data-toggle="collapse" data-target="#collapseOne">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label class="mr-3">Frequency</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="frequency" id="frequencyValue" placeholder="0.0-1.0" value="<?php echo $freq ?>">
                                            </div>
                                        </div>
                                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <label>Past year</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="f1" id="frequency1" placeholder="Past year" value="<?php echo $freq1 ?>">
                                                <label>Past 2 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="f2" id="frequency2" placeholder="Past 2 years" value="<?php echo $freq2 ?>">
                                                <label>Past 3 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="f3" id="frequency3" placeholder="Past 3 years" value="<?php echo $freq3 ?>">
                                                <label>All</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="fall" id="frequencyAll" placeholder="All" value="<?php echo $freqall ?>">
                                            </div>
                                        </div>


                                        <!--MONETARY-->
                                        <div class="card-header" data-toggle="collapse" data-target="#collapseTwo">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label class="mr-3">Monetary</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="monetary" id="monetaryValue" placeholder="0.0-1.0" value="<?php echo $mon ?>">
                                            </div>
                                        </div>
                                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <label>Past year</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="m1" id="monetary1" placeholder="Past year" value="<?php echo $mon1 ?>">
                                                <label>Past 2 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="m2" id="monetary2" placeholder="Past 2 years" value="<?php echo $mon2 ?>">
                                                <label>Past 3 years</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="m3" id="monetary3" placeholder="Past 3 years" value="<?php echo $mon3 ?>">
                                                <label>All</label>
                                                <input class="form-control" type="number" min="0" max="1" step="0.01" name="mall" id="monetaryAll" placeholder="All" value="<?php echo $monall ?>">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!--SUBMIT-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" name="generate" value="Generate Reports"></input>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>

        </div>

        <div class="container-lg mt-3">
            <div class="table-responsive">
                <div style="overflow-x: auto;">
                    <!-- <table id="example" class="table table-striped" style="width:100%; text-align: center;"> -->
                    <?php include 'table_data_modif.php'; ?>
                    <!-- </table> -->
                </div>
            </div>
        </div>
        <div class="container-lg mt-3 px-auto">
            <img src="silhouette_plot.png" alt="" width="500px">
        </div>

        <script>
            $(document).ready(function() {
                var table = $('.rfm_table').DataTable({
                    buttons: [{
                            extend: 'createState',
                            config: {
                                creationModal: true,
                                toggle: {
                                    columns: {
                                        search: true,
                                        visible: true
                                    },
                                    length: true,
                                    order: true,
                                    paging: true,
                                    search: true,
                                }
                            }
                        },
                        'savedStates'
                    ],
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All'],
                    ],
                });

                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            });
        </script>
</body>


</html>