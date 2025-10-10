<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) die("Nomor pesanan tidak ditemukan.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE kartupesanan SET JenisProduk=?, JmlPesanan=?, TglPesanan=?, TglSelesai=?, DipesanOleh=? WHERE NomorPesanan=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['JenisProduk'],
        $_POST['JmlPesanan'],
        $_POST['TglPesanan'],
        $_POST['TglSelesai'],
        $_POST['DipesanOleh'],
        $id
    ]);
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM kartupesanan WHERE NomorPesanan=?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Pesanan #<?= htmlspecialchars($data['NomorPesanan']) ?></h3>
    <form method="POST">
        <div class="mb-3">
            <label>Jenis Produk</label>
            <input type="text" name="JenisProduk" class="form-control" value="<?= htmlspecialchars($data['JenisProduk']) ?>">
        </div>
        <div class="mb-3">
            <label>Jumlah Pesanan</label>
            <input type="number" name="JmlPesanan" class="form-control" value="<?= htmlspecialchars($data['JmlPesanan']) ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Pesanan</label>
            <input type="date" name="TglPesanan" class="form-control" value="<?= htmlspecialchars($data['TglPesanan']) ?>">
        </div>
        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="date" name="TglSelesai" class="form-control" value="<?= htmlspecialchars($data['TglSelesai']) ?>">
        </div>
        <div class="mb-3">
            <label>Dipesan Oleh</label>
            <input type="text" name="DipesanOleh" class="form-control" value="<?= htmlspecialchars($data['DipesanOleh']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
