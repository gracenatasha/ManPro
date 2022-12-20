<?php
session_start();
$command = escapeshellcmd('rfm.py');
$rec = $freq = $mon = "";
if (isset($_SESSION["rec"])) {
    $rec = $_SESSION["rec"];
    $freq = $_SESSION["freq"];
    $mon = $_SESSION["mon"];

    $output = shell_exec("/usr/local/bin/python3 $command $rec $freq $mon");
} else {
    $output = shell_exec("/usr/local/bin/python3 $command");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="" sizes="20">
    <link rel="stylesheet" type="text/css" href="style.css">

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
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
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="table-responsive">
            <div style="overflow-x: auto;">
                <form action="index.php" method="post">
                    <?php include 'table_data.php'; ?>
                    <input type="submit" class="btn btn-primary" name="submit" value="Broadcast" id="btn_broadcast">
                </form>
            </div>
            <?php //echo "Weights =  Rec: ".$_SESSION["rec"]." Freq: ".$_SESSION["freq"]." Mon: ".$_SESSION["mon"]?>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.rfm_table thead tr')
                    .clone(true)
                    .attr('id', 'filters2')
                    .appendTo('.rfm_table thead');

            

            var table = $('.rfm_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ], 
                initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        var column = this;
                        // alert(column);
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.header()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
    
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                                // alert("appended");
                            });
                    });
            },
                });
                
                // table.buttons().container().appendTo( '.tablealb_wrapper .col-md-6:eq(0)' );

                $('.rfm_table tbody').append($(".rfm_table tbody tr:last").clone());
            $('.rfm_table tbody tr:last :checkbox').attr('checked', false);
            $('.rfm_table tbody tr:last td:first').html($('#row').val());

            $('.rfm_table tr').prepend($("<td>"));
            $('.rfm_table thead tr>td:first-child').html($('#col').val());
            $('.rfm_table tbody tr').each(function() {
                $(this).children('td:first-child').append($('<input type="checkbox" class="checkbox" name="check_list[]" value="">'))
            });
        });
        

        $("#btn_broadcast").click(function() {
            var checkboxes = $(".checkbox");
            // loop over them all
            for (var i = 0; i < checkboxes.length; i++) {
                // And stick the checked ones onto an array...
                if (checkboxes[i].checked) {
                    checkboxes[i].value = checkboxes[i].parentElement.parentElement.cells[0].innerHTML
                }
            }
        });
    </script>
</body>

</html>
