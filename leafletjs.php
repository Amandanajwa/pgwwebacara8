<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Peta Data Kecamatan</title>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #c3aed6, #a8edea);
      min-height: 100vh;
      margin: 0;
      padding-top: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h2 {
      color: #6a0dad;
      font-weight: 700;
      margin-bottom: 15px;
      text-align: center;
    }

    #map {
      height: 500px;
      width: 90%;
      max-width: 900px;
      border-radius: 20px;
      box-shadow: 0 10px 35px rgba(0,0,0,0.15);
      margin-top: 10px;
    }

    a.btn-back {
      display: inline-block;
      margin-top: 30px;
      background: linear-gradient(90deg, #7b2cbf, #9d4edd);
      color: #fff;
      padding: 10px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    a.btn-back:hover {
      background: linear-gradient(90deg, #5a189a, #7b2cbf);
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <h2>🗺 Peta Data Kecamatan</h2>
  <div id="map"></div>

  <a href="../index.php" class="btn-back">← Kembali ke Data</a>

  <?php
  $conn = new mysqli("localhost", "root", "", "pgweb_acara8");
  if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

  $sql = "SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk FROM data_kecamatan";
  $result = $conn->query($sql);

  $data = [];
  while ($row = $result->fetch_assoc()) {
      $data[] = $row;
  }
  $conn->close();
  ?>

  <script>
    const dataKecamatan = <?php echo json_encode($data); ?>;

    const map = L.map('map').setView([-7.77, 110.37], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    dataKecamatan.forEach(item => {
      if (item.latitude && item.longitude) {
        L.marker([item.latitude, item.longitude])
          .addTo(map)
          .bindPopup(
            `<b>${item.kecamatan}</b><br>Luas: ${item.luas} km²<br>Penduduk: ${item.jumlah_penduduk}`
          );
      }
    });
  </script>

</body>
</html>
