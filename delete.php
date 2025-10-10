<?php
require_once 'db.php';

if (!isset($_GET['id'])) die("Nomor pesanan tidak ditemukan.");

$id = $_GET['id'];

// Hapus rincian terlebih dahulu
$pdo->prepare("DELETE FROM rincianbiaya WHERE NomorPesanan=?")->execute([$id]);

// Hapus pesanan utama
$pdo->prepare("DELETE FROM kartupesanan WHERE NomorPesanan=?")->execute([$id]);

header("Location: index.php");
exit;
?>
