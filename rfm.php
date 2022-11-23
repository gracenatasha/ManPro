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
                background-color: #F0F0F0;
            }
        </style>
    </head>
    <body>
        <?php include 'navbar.php'; ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <img src="clustering.png" style="width: 100%;">
                </div>
            </div>
        </div>
        <script>
        </script>
    </body>
</html>