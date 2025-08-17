<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

if ($id === '') {
    header('Location: dashboard.php');
    exit;
}

include 'config/config.php';

// Hapus event dari tabel
$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conn->close();

// Kembali ke dashboard
header('Location: dashboard.php');
exit;
?>
