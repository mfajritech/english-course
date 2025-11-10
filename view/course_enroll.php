<?php
include '../config/database.php';
session_start();

$db = new Database();
$conn = $db->conn;

$user_id = $_SESSION['user_id'];

// Ambil ID course dari URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data course
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();

// Ambil data course
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Kamu harus login dulu!'); window.location='../auth/login.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id, status) VALUES (?, ?, 'menunggu konfirmasi')");
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();

    echo "<script>alert('Pendaftaran berhasil dikirim! Menunggu konfirmasi admin.'); window.location='my_courses.php';</script>";
     
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <title>Daftar Kelas</title>
  <style>
    body { background-color: #f9fbff; }
    .enroll-card {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .course-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .info-label {
      font-weight: 600;
      color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <?php if ($course): ?>
  <div class="enroll-card p-4">
    <div class="row g-4 align-items-start">
      
      <!-- KIRI: Detail Course -->
      <div class="col-md-6 border-end">
        <h3 class="text-primary mb-2"><?php echo htmlspecialchars($course['title']); ?></h3>
        <p class="text-muted mb-2"><?php echo htmlspecialchars($course['slogan']); ?></p>
        <p style="font-size: 15px;"><?php echo nl2br(htmlspecialchars($course['description'] ?? 'Tidak ada deskripsi.')); ?></p>

        <hr>
        <div>
          <p><span class="info-label">Durasi:</span> <?php echo htmlspecialchars($course['duration']); ?> bulan</p>
          <p><span class="info-label">Kapasitas:</span> <?php echo htmlspecialchars($course['capacity']); ?> peserta</p>
          <p><span class="info-label">Mode:</span> <?php echo htmlspecialchars($course['mode']); ?></p>
          <p><span class="info-label">Jadwal:</span> <?php echo htmlspecialchars($course['schedule']); ?></p>
        </div>
      </div>

      <!-- KANAN: Form Pembayaran -->
      <div class="col-md-6">
        <h4 class="text-primary mb-3">Form Pendaftaran</h4>
        <div class="alert alert-info py-2 mb-4">
          <strong>Informasi:</strong><br>
          Anda akan dihubungi oleh tim <b>Adzkia English Academy</b><br>
          melalui email <?=$user['email']?>
        </div>

        <form method="POST" enctype="multipart/form-data">

        <p class="mb-0 fw-bold">Kelas  : <span class="text-info"><?= $course['title'] ?></span></p>
        <p class="fw-bold">Harga : Rp<?= $course['price'] ?></p>

          <button type="submit" class="btn w-100 text-white fw-semibold" style="background-color:#007bff;">
            Kirim Pendaftaran
          </button>
        </form>
      </div>

    </div>
  </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">Course tidak ditemukan.</div>
  <?php endif; ?>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
