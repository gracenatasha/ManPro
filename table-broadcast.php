<?php 
    $command = escapeshellcmd('python rfm.py');
    $output = shell_exec($command);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="" sizes="20">

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
    
        <title>RFM</title>
        <style>
            body{
                background-color: #F0F0F0;
            }
            .container {
                margin: 100px auto;
            }

            .table-striped {
            background-color: white;
            }
            .center{
                margin-left: auto;
                margin-right: auto;
                display: block;
                width: 70%;
            }
            .table td{
                /* max-width: 120px; */
                white-space: normal;
                /* text-overflow: ellipsis; */
                word-break: break-all;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <?php include 'navbar.php';?>
        <div class="container">
            <div class="table-responsive">
            <div style="overflow-x: auto;">
            <form action="index.php" method="post">
                <!-- <table id="example" class="table table-striped" style="width:100%; text-align: center;"> -->
                    <?php include 'table_data-broadcast.php'; 
                    // echo '<input type="submit" class="btn btn-success" name="submit" value="broadcast">';
                    // echo '</form>';
                    ?>
                <!-- </table> -->
                <input type="submit" class="btn btn-success" name="submit" value="broadcast">
                </form>
            </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var table = $('.rfm_table').DataTable({
                    buttons:[
                        {
                            extend: 'createState',
                            config: {
                                creationModal: true,
                                toggle: {
                                    columns:{
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
                    .appendTo( '#example_wrapper .col-md-6:eq(0)' );
            });
        </script>
    
    </body>
</html>