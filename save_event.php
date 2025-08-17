<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require 'config/config.php';

// Ambil input dari form
$id   = trim($_POST['id'] ?? '');
$title = trim($_POST['title'] ?? '');
$date  = trim($_POST['date'] ?? '');
$desc  = trim($_POST['description'] ?? '');
$image_url = trim($_POST['image_url'] ?? '');

if ($title === '' || $date === '') {
    header('Location: dashboard.php');
    exit;
}

// Proses upload gambar jika ada
$imagePath = $image_url; // default dari URL input
if (!empty($_FILES['image_file']['name'])) {
    $targetDir = __DIR__ . "/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["image_file"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $targetFile)) {
            $imagePath = "uploads/" . $fileName; // path relatif
        }
    }
}

// Jika ada ID → Update
if ($id !== '') {
    $stmt = $conn->prepare("UPDATE events SET title=?, date=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $title, $date, $desc, $imagePath, $id);
    $stmt->execute();
    $stmt->close();
} else {
    // Insert baru
    $stmt = $conn->prepare("INSERT INTO events (title, date, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $date, $desc, $imagePath);
    $stmt->execute();
    $stmt->close();
}

header('Location: dashboard.php');
exit;
?>