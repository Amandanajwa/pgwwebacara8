<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Kecamatan</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    body {
        background: linear-gradient(135deg, #c3aed6, #a8edea);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        padding-top: 30px;
    }
    .container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
        padding: 40px;
        max-width: 1100px;
        margin-bottom: 30px;
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
        cursor: pointer;
    }
    #map {
        width: 100%;
        height: 500px;
        margin-top: 20px;
        border-radius: 15px;
    }
    .map-container {
        background: rgba(173, 216, 230, 0.4);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 20px;
        width: 90%;
        max-width: 1100px;
        margin: auto;
    }
    .map-title {
        text-align: center;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    .btn-custom {
        background: linear-gradient(90deg, #7b2cbf, #9d4edd);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
        transition: 0.3s;
        text-decoration: none;
    }
    .btn-custom:hover {
        background: linear-gradient(90deg, #5a189a, #7b2cbf);
        transform: scale(1.05);
        color: #fff;
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

    <?php
    // Pesan status input
    if(isset($_GET['status']) && isset($_GET['message'])){
        $status = $_GET['status'];
        $message = $_GET['message'];
        $alertClass = $status == 'success' ? 'alert-success' : 'alert-danger';
        echo "<div class='alert $alertClass text-center fade show' role='alert'>$message</div>";
    }

    // Koneksi database
    $conn = new mysqli("localhost","root","","pgweb_acara8");
    if($conn->connect_error) die("<div class='alert alert-danger text-center'>Koneksi gagal: ".$conn->connect_error."</div>");

    $sql = "SELECT * FROM data_kecamatan";
    $result = $conn->query($sql);

    $data = []; // array untuk peta
    if($result->num_rows > 0){
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover text-center align-middle'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kecamatan</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Luas</th>
                    <th>Jumlah Penduduk</th>
                    <th colspan='2'>Aksi</th>
                </tr>
              </thead><tbody>";
        while($row = $result->fetch_assoc()){
            $data[] = $row; // simpan untuk peta
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['kecamatan']}</td>
                    <td>{$row['longitude']}</td>
                    <td>{$row['latitude']}</td>
                    <td>{$row['luas']}</td>
                    <td>{$row['jumlah_penduduk']}</td>
                    <td><a href='delete.php?id={$row["id"]}'>hapus</a></td>
                    <td><a href='edit/index.php?id={$row["id"]}'>edit</a></td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "<div class='alert alert-warning text-center'>Belum ada data kecamatan.</div>";
    }

    $conn->close();
    ?>

    <div class="text-center mt-4">
        <a href="input/index.html" class="btn-custom shadow-sm">➕ Input Data Wilayah Baru</a>
        <a href="leafletjs.php" class="btn-custom shadow-sm">🌍 Explore Peta</a>
    </div>
</div>

<!-- Peta di bawah tabel -->
<div class="map-container">
    <h4 class="map-title">🗺 Peta Sebaran Kecamatan</h4>
    <div id="map"></div>
</div>

<div class="footer">
    © 2025 Sistem Informasi Geografis - Amanda Najwa Paramitha
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const data = <?php echo json_encode($data); ?>;
    const map = L.map('map').setView([-7.75, 110.35], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Tambahkan marker
    const markers = [];
    data.forEach(function(item){
        if(item.latitude && item.longitude){
            const marker = L.marker([item.latitude, item.longitude]).addTo(map);
            marker.bindPopup(`
                <b>${item.kecamatan}</b><br>
                Luas: ${item.luas} km²<br>
                Penduduk: ${item.jumlah_penduduk}
            `);
            markers.push(marker);
        }
    });

    // Fit map ke semua marker
    if(markers.length > 0){
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.2));
    }
</script>

</body>
</html>