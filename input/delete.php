<?php
$id = $_GET['id'];

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb_acara8";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Hapus data berdasarkan ID
$sql = "DELETE FROM data_kecamatan WHERE id = $id";

if ($conn->query($sql) === TRUE) {
  echo "Record with id $id deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>