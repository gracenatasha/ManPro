<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">    
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <title>Send email</title>
</head>
<body>
    
   
    <div class="container">
    <form class="" action="send.php" method="post">
        <label for="Email">Email:</label>
        <br>
    <?php
        include 'connect.php';

        if (isset($_POST['submit'])){
             if(!empty($_POST['check_list'])){
                foreach($_POST['check_list'] as $key => $value){
                    $sql = "SELECT * FROM pendonor";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result)) {
                        if ($row['id_pendonor'] == $_POST['check_list'][$key]){
                            echo '-<input type="email" name="email[]" value="'.$row['email'].'" readonly> : ';
                            echo '<input type="text" name="nama[]" value="'.$row['nama_pendonor'].'" readonly>';
                      }  
                      } 
                      echo '<br>';
                }
            }
        }
    ?>
        <br>
        Subject <input type="text" name="subject" value=""> <br>
        <br>
        Message <input type="text" name="message" value=""> <br>
        <button type="submit" name="submit" value="">send</button>
        <!-- <input class="btn btn-success" type="submit" name="send" value="send"> -->
    </form>
    </div>
</body>
</html>
