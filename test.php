<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ni test</title>
</head>
<body>
    <h1>coba php->python dek</h1>

    <?php
    //  $command = escapeshellcmd('rfmcopy.py');
    //  $output = shell_exec($command);
    //  echo $output;
    //  $arr = json_decode($output);
    //  var_dump($arr);
    //  $command = escapeshellcmd('r.py');
    //  $output = shell_exec($command);
    //  echo $output, "<br>";
    // //  echo;
    //  $command = escapeshellcmd('f.py');
    //  $output = shell_exec($command);
    //  echo $output;
    // echo exec("rfmcopy.py")
    $command = escapeshellcmd('rfmgraph.py');
    $output = shell_exec($command);
    echo $output;
    ?>
</body>
</html>