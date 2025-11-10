<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Data Kecamatan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body {
        background: linear-gradient(135deg, #c3aed6, #a8edea);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        padding-top: 50px;
    }
    .container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.15);
        padding: 40px;
        max-width: 700px;
    }
    h2 {
        color: #6a0dad;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
    }
    .btn-custom {
        background: linear-gradient(90deg, #7b2cbf, #9d4edd);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background: linear-gradient(90deg, #5a189a, #7b2cbf);
        transform: scale(1.05);
    }
</style>
</head>

<body>

<div class="container">
    <h2>✏️ Edit Data Kecamatan</h2>

    <?php
        if(!isset($_GET['id'])){
            die("<div class='alert alert-danger text-center'>ID tidak ditemukan</div>");
        }

        $id = intval($_GET['id']);
        $conn = new mysqli("localhost","root","","pgweb_acara8");

        if($conn->connect_error){
            die("<div class='alert alert-danger text-center'>Koneksi gagal: " . $conn->connect_error . "</div>");
        }

        $sql = "SELECT * FROM data_kecamatan WHERE id = $id";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
    ?>

    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <label>Kecamatan</label>
        <input class="form-control mb-2" type="text" name="kecamatan" value="<?= $row['kecamatan'] ?>">

        <label>Longitude</label>
        <input class="form-control mb-2" type="text" name="longitude" value="<?= $row['longitude'] ?>">

        <label>Latitude</label>
        <input class="form-control mb-2" type="text" name="latitude" value="<?= $row['latitude'] ?>">

        <label>Luas</label>
        <input class="form-control mb-2" type="text" name="luas" value="<?= $row['luas'] ?>">

        <label>Jumlah Penduduk</label>
        <input class="form-control mb-4" type="text" name="jumlah_penduduk" value="<?= $row['jumlah_penduduk'] ?>">

        <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
        <a href="../index.php" class="btn btn-secondary">Kembali</a>
    </form>

    <?php
        }else{
            echo "<div class='alert alert-warning text-center'>Data tidak ditemukan</div>";
        }
        $conn->close();
    ?>
</div>

</body>
</html>
