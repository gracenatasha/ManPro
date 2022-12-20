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
            #btn_detail{
                /* position: fixed; */
            }
        </style>
    </head>
    <body>
        <?php include 'navbar.php';?>
        <div class="container mt-3">
            <h1 style="text-align: center;">HASIL CLUSTERING RFM</h1>
            <div class="row justify-content-center" style="margin-bottom: 50px;">
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="rfm_detil.php">
                        <button class="btn btn-dark mx-auto" type="button" id="btn_detail" style="width: 100%;">Details</button>
                    </a>
                </div>
            </div>
            <?php include 'clustering.html';?>
            
        </div>
        <script>
        </script>
    </body>
</html>
