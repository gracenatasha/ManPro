
<?php
    include "connect.php";
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" href="#">Event</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Data</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">RFM</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Donor Darah</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    
    <div class="container-fluid">
        
        
        <button type="button" class="btn btn-secondary"  style="margin-top: 50px;">Filter</button>
        
       
        <div class="row" style="margin-top: 50px;">
        <div class="box-data">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Nama Pendonor</th>
                <th scope="col">Goldar</th>
                <th scope="col">Rhesus</th>
                <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM pendonor";
                    $result = $conn->query($sql);
    
                    if ($result->num_rows > 0) {
                    // echo "<table><tr><th>ID</th><th>Name</th></tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["nama_pendonor"]."</td><td>".$row["golongan_darah"]."</td><td>".$row["rhesus"]."</td><td>".$row["email"]."</tr>";
                    }
                    echo "</table>";
                    } else {
                    echo "0 results";
                    }
                    // $conn->close();
                
                ?>
               
                <!-- <tr>
                
                        $sql = "SELECT nama_pendonor, golongan_darah, rhesus, email FROM pendonor";
                        $result = $conn->query($sql);
                        var_dump($result);
                        
                        if ($result->num_rows > 0) {
                          // output data of each row
                          while($row = $result->fetch_assoc()) {
                            echo "<td>".$row["nama_pendonor"]."</td>";
                            // echo ". $row["firstname"].  " . $row["lastname"]. <br>";
                          }
                        } else {
                          echo "0 results";
                        }
                        $conn->close();
                        
                    
                    
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Larry the Bird</td>
                    <td>@twitter</td>
                    <td>@twitter</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Larry the Bird</td>
                    <td>@twitter</td>
                    <td>@twitter</td>
                    <td>@mdo</td>
                </tr>
            </tbody> -->
        </table>

        </div>

        </div>
        
    </div>

</body>
</html>