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
            }
        </style>
    </head>
    <body>
        <?php include 'navbar.php';?>
        <div class="container mt-5">
            <?php include 'clustering.html';?>
        </div>
        <script>
        </script>
    </body>
</html>
