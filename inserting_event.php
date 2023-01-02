<html>
    <?php 
        require_once "connection.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Cek nama event
            if (empty($_POST['namaEvent'])) {
                $errNamaEvent = "Nama event tidak boleh kosong!";
            } else {
                $namaEvent = saring_input($_POST['namaEvent']);
            }

            // Cek tanggal event
            if (empty($_POST['tanggal_event'])) {
                $errTanggal = "tanggal tidak boleh kosong!";
            } else {
                $tgl = saring_input($_POST['tanggal_event']);
            
            }

            // Cek waktu event
            if (empty($_POST['waktu_event_mulai'])) {
                $errWaktuMulai = "Waktu tidak boleh kosong!";
            } else {
                $waktuMulai = saring_input($_POST['waktu_event_mulai']);
                
            }
            if (empty($_POST['waktu_event_akhir'])) {
                $errWaktuSelesai = "Waktu tidak boleh kosong!";
            } else {
                $waktuSelesai = saring_input($_POST['waktu_event_akhir']);
                
            }

            // Cek lokasi event
            if (empty($_POST['select_box'])) {
                $errLokasi = "Lokasi tidak boleh kosong!";
            } else {
                $simpanLokasi=saring_input($_POST['select_box']);
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
            if (!empty($namaEvent)) {
                $kalimatquery1 = "SELECT nama_event FROM event WHERE nama_event = '$namaEvent' ";
                $hasilquery1 = $conn->query($kalimatquery1);

                // Jika nama event sudah ada
                if ($hasilquery1->num_rows > 0) {
                    echo "Nama event sudah ada, silahkan input ulang!";
                }
                // Jika nama event belum ada
                else{
                    // Prepare sql statement, values jadiin tanda tanya
                    $kalimatquery = $conn->prepare("INSERT INTO event (nama_event,tanggal_event,waktu_event_mulai,waktu_event_selesai,id_lokasi) VALUES (?,?,?,?,?)");
                    $kalimatquery->bind_param("ssssi", $namaEvent, $tgl, $waktuMulai, $waktuSelesai, $simpanLokasi);
                    $kalimatquery->execute();
                    header("Location:displayAllEvent.php");
                }
            } else {
                echo "$errNamaEvent <br>";
            }

            if(empty($tgl)){
                echo "$errTanggal <br>";
            }

            if(empty($waktuMulai)){
                echo "$errWaktuMulai <br>";
            }
            if(empty($waktuSelesai)){
                echo "$errWaktuSelesai <br>";
            }

            if(empty($simpanLokasi)){
                echo "$errLokasi <br>"; 
            }
 
             ?>
    </body>
</html>
