<html>
    <?php 
        require_once "connection.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Cek nama event
            if (empty($_POST['namaLokasi'])) {
                $errNamaLokasi = "Nama Lokasi tidak boleh kosong!";
            } else {
                $namaLokasi = saring_input($_POST['namaLokasi']);
            }

            // Cek lokasi event
            if (empty($_POST['select_box_lokasi'])) {
                $errLokasi = "Lokasi tidak boleh kosong!";
            } else {
                $simpanLokasi=saring_input($_POST['select_box_lokasi']);
                print $simpanLokasi;
            }

            
        }

        function saring_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <body>
        <?php
            // Proses nama
            if (!empty($namaLokasi)) {
                // Ambil nrp limit 1 saja, jika memang ada 1 saja nama yang sama maka langsung tidak diinput
                $kalimatquery1 = "SELECT nama_lokasi FROM lokasi WHERE nama_lokasi = '$namaLokasi' ";
                $hasilquery1 = $conn->query($kalimatquery1);

                // Jika nama event sudah ada
                if ($hasilquery1->num_rows > 0) {
                    echo "Lokasi sudah ada, silahkan input ulang!";
                }
                // Jika nama event belum ada
                else{
                    // Prepare sql statement, values jadiin tanda tanya
                    $kalimatquery = $conn->prepare("INSERT INTO lokasi (nama_lokasi,id_kelurahan) VALUES (?,?)");
                    $kalimatquery->bind_param ("si",$namaLokasi,$simpanLokasi);
                    $kalimatquery->execute();
                    header("Location:insertevent.php");
                }
            } else {
                echo "$errNamaLokasi <br>";
            }
            if(empty($simpanLokasi)){
                echo "$errLokasi <br>"; 
            }
 
             ?>
    </body>
</html>