<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Biaya Perusahaan (Latihan 4)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <h1 class="text-center mb-4">Laporan Analisis Biaya Perusahaan</h1>
    <p class="text-center text-muted mb-5">Database: <b>db_perusahaan</b></p>

    <?php
    require_once 'db.php';

    // Daftar view dan judul tampilannya
    $queries = [
        'v_laporbiayaperpesanan' => 'Q1. Total Biaya Per Pesanan & Kelompok',
        'v_laporbiayaperbulan' => 'Q2. Total Biaya Per Bulan & Kelompok',
        'v_biayaperproduk' => 'Q3. Total Biaya Per Jenis Produk & Kelompok',
        'v_biayaprodukperpesanan' => 'Q4. Analisis Biaya Produk Per Unit',
        'v_rekapbiayapersubkelompok' => 'Q5. Statistik Biaya Per Sub Kelompok',
        'v_biayaproduksepatu' => 'Q6. Biaya Pesanan Khusus "Sepatu"',
        'v_biayalebih20juta' => 'Q7. Pesanan dengan Total Biaya > 20 Juta (HAVING)',
        'v_top3kelompokbiayaterbesar' => 'Q8. Pesanan Biaya Tertinggi (LIMIT)'
    ];

    foreach ($queries as $view => $title) {
        echo "<div class='card mb-5 shadow-sm'>";
        echo "<div class='card-header bg-dark text-white fw-bold'>{$title}</div>";
        echo "<div class='card-body'>";

        try {
            $stmt = $pdo->query("SELECT * FROM $view");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($rows) > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-hover">';
                echo '<thead class="table-dark"><tr>';
                foreach (array_keys($rows[0]) as $col) {
                    echo '<th>' . htmlspecialchars($col) . '</th>';
                }
                echo '</tr></thead><tbody>';
                foreach ($rows as $row) {
                    echo '<tr>';
                    foreach ($row as $val) {
                        echo '<td>' . htmlspecialchars($val) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-info">Tidak ada data pada view ini.</div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }

        echo "</div></div>";
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
