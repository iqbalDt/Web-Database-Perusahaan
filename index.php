<?php
include 'config.php'; // koneksi database

// =======================
// QUERY Q1 - Q8
// =======================
$queries = [
    "Q1. Total Biaya Perpesanan & Kelompok" => 
        "SELECT NomorPesanan, Kelompok, SUM(Jumlah) AS TotalBiaya 
         FROM rincianbiaya 
         GROUP BY NomorPesanan, Kelompok",

    "Q2. Total biaya perbulan & kelompok" => 
        "SELECT MONTH(Tanggal) AS Bulan, Kelompok, SUM(Jumlah) AS TotalBiaya 
         FROM rincianbiaya 
         GROUP BY MONTH(Tanggal), Kelompok",

    "Q3. Total biaya perjenis produk & kelompok" => 
        "SELECT kp.JenisProduk, rb.Kelompok, SUM(rb.Jumlah) AS TotalBiaya
         FROM rincianbiaya rb 
         JOIN kartupesanan kp ON rb.NomorPesanan = kp.NomorPesanan
         GROUP BY kp.JenisProduk, rb.Kelompok",

    "Q4. Analisis biaya produk per unit" => 
        "SELECT kp.JenisProduk, SUM(rb.Jumlah)/SUM(kp.JmlPesanan) AS BiayaPerUnit
         FROM rincianbiaya rb 
         JOIN kartupesanan kp ON rb.NomorPesanan = kp.NomorPesanan
         GROUP BY kp.JenisProduk",

    "Q5. Statistik biaya per sub kelompok" => 
        "SELECT SubKelompok, COUNT(*) AS JumlahData, SUM(Jumlah) AS TotalBiaya
         FROM rincianbiaya 
         GROUP BY SubKelompok",

    "Q6. Biaya pesanan khusus 'sepatu'" => 
        "SELECT kp.NomorPesanan, kp.JenisProduk, SUM(rb.Jumlah) AS TotalBiaya
         FROM rincianbiaya rb 
         JOIN kartupesanan kp ON rb.NomorPesanan = kp.NomorPesanan
         WHERE kp.JenisProduk = 'Sepatu'
         GROUP BY kp.NomorPesanan, kp.JenisProduk",

    "Q7. Pesanan dengan total biaya > 20 juta (HAVING)" => 
        "SELECT kp.NomorPesanan, SUM(rb.Jumlah) AS TotalBiaya
         FROM rincianbiaya rb 
         JOIN kartupesanan kp ON rb.NomorPesanan = kp.NomorPesanan
         GROUP BY kp.NomorPesanan
         HAVING SUM(rb.Jumlah) > 20000000",

    "Q8. Pesanan Biaya tertinggi (LIMIT)" => 
        "SELECT kp.NomorPesanan, SUM(rb.Jumlah) AS TotalBiaya
         FROM rincianbiaya rb 
         JOIN kartupesanan kp ON rb.NomorPesanan = kp.NomorPesanan
         GROUP BY kp.NomorPesanan
         ORDER BY TotalBiaya DESC
         LIMIT 1"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Data Perusahaan (Q1 - Q8)</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; background: #f9f9f9; }
    h1 { text-align: center; }
    h2 { background: #333; color: #fff; padding: 10px; border-radius: 5px; }
    table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #eee; }
    .action-btn { background: #008CBA; color: white; padding: 5px 8px; text-decoration: none; border-radius: 4px; }
    .action-btn:hover { background: #005f73; }
  </style>
</head>
<body>
  <h1>📊 Laporan Data Perusahaan (Q1 - Q8)</h1>

  <?php
  foreach ($queries as $judul => $sql) {
      echo "<h2>$judul</h2>";
      $result = mysqli_query($conn, $sql);

      if (!$result) {
          echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
          continue;
      }

      if (mysqli_num_rows($result) > 0) {
          echo "<table>";
          // Header otomatis
          echo "<tr>";
          while ($fieldinfo = mysqli_fetch_field($result)) {
              echo "<th>" . htmlspecialchars($fieldinfo->name) . "</th>";
          }
          echo "<th>Action</th>";
          echo "</tr>";

          // Isi tabel
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              foreach ($row as $val) {
                  echo "<td>" . htmlspecialchars($val) . "</td>";
              }
              // Action
              echo "<td>
                      <a href='edit.php?id=" . $row[array_key_first($row)] . "' class='action-btn'>Edit</a>
                      <a href='delete.php?id=" . $row[array_key_first($row)] . "' class='action-btn' style='background:#e74c3c;'>Delete</a>
                      <a href='detail.php?id=" . $row[array_key_first($row)] . "' class='action-btn' style='background:#2ecc71;'>Detail</a>
                    </td>";
              echo "</tr>";
          }
          echo "</table>";
      } else {
          echo "<p>Tidak ada data untuk $judul</p>";
      }
  }
  ?>

</body>
</html>
