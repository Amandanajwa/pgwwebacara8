<?php 
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    $conn = new mysqli("localhost", "root", "", "pgweb_acara8");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE data_kecamatan SET 
                kecamatan='$kecamatan', 
                longitude='$longitude', 
                latitude='$latitude', 
                luas='$luas', 
                jumlah_penduduk='$jumlah_penduduk' 
            WHERE id=$id";

    $conn->query($sql);
    $conn->close();

    header("Location: ../index.php");
?>
