<?php
require_once 'connect_db.php';

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function registrasi($data)
{
    global $conn;

    $email = strtolower($data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);
    $tgl_donor = date('Y-m-d', strtotime($_POST['date_donor']));
    $namaPendonor = $data['nama_pendonor'];
    $golonganDarah = $data['golongan_darah'];
    $jenisKelamin = $data['gender'];
    $rhesus = $data['rhesus'];
    $alamatRumah = $data['alamat'];
    $alamatKantor = $data['alamatKantor'];
    $idKelurahan = $data['kelurahan'];
    $idKelurahanKantor = $data['kelurahanKantor'];
    $telp = $data['telp'];


    //password confirmation
    if ($password !== $password2) {
        echo "<script>
                alert('password doesn't match');
              </script>";

        return false;
    }

    //password encryption
    $password = password_hash($password, PASSWORD_DEFAULT);

    //add new user to database
    mysqli_query($conn, "INSERT INTO pendonor VALUES(NULL, '$namaPendonor', '$tgl_donor', '$jenisKelamin', '$golonganDarah', '$rhesus', '$alamatRumah', $idKelurahan, '$alamatKantor', $idKelurahanKantor, '$telp', '$email', '$password')");

    return mysqli_affected_rows($conn);
}

//cari
function cari($keyword){
    $query = "SELECT * FROM event
                WHERE 
                nama_event LIKE '%$keyword%' OR
                id_event LIKE '%$keyword%'
            ";
    
    return query($query);
}

//tambah
function tambah($data)
{
    global $conn;

    $jumlah_darah = htmlspecialchars($data["jumlah_darah"]);
    $id_pendonor = htmlspecialchars($data["id_pendonor"]);
    $id_event = htmlspecialchars($data["id_event"]);

    $sql = "INSERT INTO donor
				VALUES
			(NULL, $jumlah_darah, $id_pendonor, $id_event)";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}