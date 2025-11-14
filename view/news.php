<?php 
include '../config/database.php';

$db = new Database();
$conn = $db->conn;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM news WHERE id=$id";
$result = $conn->query($sql);
$news = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container py-4">
        <a href="../news.php" class="text-decoration-none px-3 py-1 rounded-pill fw-bold bg-warning text-dark">kembali</a>
        <p class="py-3"></p>
        <h1 class=""><?= $news['title'] ?></h1>
        <p><?= $news['date'] ?></p>
        <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
    </div>
</body>
</html>