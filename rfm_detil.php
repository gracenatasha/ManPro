<?php 
    include 'links.php';
    $command = escapeshellcmd('python rfm.py');
    $output = shell_exec($command);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="" sizes="20">
        <title>RFM</title>
        <style>
            body{
                /* background-color: #F0F0F0; */
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php include 'navbar.php';?>
        <div class="container">
            <h1 style="text-align: center">DETIL RFM</h1>
            <div class="row mt-5 justify-content-center">
                <div class="col-6">
                    <div class="row">
                        <h3>Elbow Method</h3>
                        <p>Untuk menentukan jumlah cluster</p>
                    </div>
                    <div class="row">
                        <img src="elbow.png" style="width: 100%; ">
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <h3>Silhouette Index</h3>
                        <p>Untuk menentukan jumlah cluster</p>
                    </div>
                    <div class="row">
                        <img src="silhouette.png" style="width: 100%; ">
                    </div>
                </div>
                <div class="col-6 mt-3">
                    <h3>Silhouette Coefficient</h3>
                    <p><?php echo $output?></p>
                </div>
            </div>
            
            </div>
        </div>
        <script>
        </script>
    </body>
</html>
