<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    die("Nomor pesanan tidak ditemukan.");
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM kartupesanan WHERE NomorPesanan = ?");
$stmt->execute([$id]);
$pesanan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}

$rincian = $pdo->prepare("SELECT * FROM rincianbiaya WHERE NomorPesanan = ?");
$rincian->execute([$id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-3">Detail Pesanan #<?= htmlspecialchars($pesanan['NomorPesanan']) ?></h3>
    <p><strong>Jenis Produk:</strong> <?= htmlspecialchars($pesanan['JenisProduk']) ?></p>
    <p><strong>Jumlah Pesanan:</strong> <?= htmlspecialchars($pesanan['JmlPesanan']) ?></p>
    <p><strong>Tanggal Pesan:</strong> <?= htmlspecialchars($pesanan['TglPesanan']) ?></p>
    <p><strong>Tanggal Selesai:</strong> <?= htmlspecialchars($pesanan['TglSelesai']) ?></p>
    <p><strong>Dipesan Oleh:</strong> <?= htmlspecialchars($pesanan['DipesanOleh']) ?></p>

    <h5 class="mt-4">Rincian Biaya:</h5>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID Rincian</th>
                <th>Kelompok</th>
                <th>Sub Kelompok</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $rincian->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['IDRincian']) ?></td>
                    <td><?= htmlspecialchars($row['Kelompok']) ?></td>
                    <td><?= htmlspecialchars($row['SubKelompok']) ?></td>
                    <td><?= htmlspecialchars($row['Jumlah']) ?></td>
                    <td><?= htmlspecialchars($row['Tanggal']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
</div>
</body>
</html>
