<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Website Donor Darah</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        .card-body {
            text-align: center;
            align-items: center;
        }
        .card-header{
            background-color: #880002;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">

            <div class="card mx-auto my-auto">
                <div class="card-header justify-content-center">
                    <img src="assets/pmi_logo.png" width="300px">
                </div>
                <div class="card-body align-items-center">
                    <h3>Welcome to Donor Darah Online</h3>
                    <h5>Login as...</h5>
                    <a class="btn btn-primary mt-3 d-block" href="login.php">User</a>
                    <!--nti diganti halaman loginnya tiff-->
                    <a class="btn btn-primary mt-3 mb-3 d-block" href="cariEvent.php">Admin</a>
                    <small>Don't have an account yet? <a href="registration.php">Register Now</a></small>
                </div>
            </div>

        </div>

    </div>
</body>

</html>