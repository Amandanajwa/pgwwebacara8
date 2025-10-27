<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kecamatan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
            padding: 40px;
            max-width: 900px;
        }
        h2 {
            color: #6a0dad;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            border-radius: 10px;
            overflow: hidden;
        }
        thead {
            background: linear-gradient(90deg, #7b2cbf, #9d4edd);
            color: #fff;
        }
        tbody tr:hover {
            background-color: #f8f0ff;
            transition: 0.3s;
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
        .footer {
            text-align: center;
            color: #6a0dad;
            margin-top: 40px;
            font-weight: 500;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>📍 Data Kecamatan</h2>

    <div class="text-end mb-3">
        <a href="input/index.html" class="btn btn-custom">
            ➕ Input Data Wilayah
        </a>
    </div>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pgweb_acara8";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("<div class='alert alert-danger text-center'>❌ Koneksi gagal: " . $conn->connect_error . "</div>");
    }

    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover text-center align-middle'>";
        echo "<thead><tr>
                <th>ID</th>
                <th>Nama Kecamatan</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Luas</th>
                <th>Jumlah Penduduk</th>
              </tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["kecamatan"] . "</td>
                    <td>" . $row["longitude"] . "</td>
                    <td>" . $row["latitude"] . "</td>
                    <td>" . $row["luas"] . "</td>
                    <td>" . $row["jumlah_penduduk"] . "</td>
                  </tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<div class='alert alert-warning text-center'>⚠️ Belum ada data kecamatan yang tersimpan.</div>";
    }

    $conn->close();
    ?>
</div>

<div class="footer">
    © 2025 Sistem Informasi Geografis -  Amanda Najwa Paramitha - Praktikum PGWEB
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
