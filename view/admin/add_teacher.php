<?php
include '../../config/database.php';

$db = new Database();
$conn = $db->conn;

session_start();

// Jika user belum login, arahkan ke login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $experience = trim($_POST['experience']);
    $education = trim($_POST['education']);

    if (!empty($name) && !empty($title)) {
        $stmt = $conn->prepare("INSERT INTO teachers (name, title, experience, education) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $title, $experience, $education);

        if ($stmt->execute()) {
            header("Location: teachers.php?success=1");
            exit;
        } else {
            $error = "Gagal menyimpan data. Silakan coba lagi.";
        }
    } else {
        $error = "Nama dan title wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Guru | Adzkia Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7faff;
      font-family: 'Poppins', sans-serif;
    }
    .sidebar {
      height: 100vh;
      background-color: #0f4db7;
      color: #fff;
      position: fixed;
      top: 0; left: 0;
      width: 250px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .sidebar .brand {
      font-size: 1.3rem; font-weight: bold;
      text-align: center; padding: 1.5rem 0;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar .nav-link {
      color: #fff; font-weight: 500;
      padding: 12px 20px; border-radius: 8px;
      margin: 4px 12px;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #ffb703;
      color: #0f4db7;
    }
    main {
      margin-left: 260px;
      padding: 30px;
    }
    .btn-custom {
      background-color: #ffb703;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background-color: #f48c06;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div>
    <div class="brand">Adzkia Admin</div>
    <nav class="nav flex-column px-2">
      <a href="dashboard.php" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
      <a href="course.php" class="nav-link"><i class="bi bi-book me-2"></i>Course</a>
      <a href="users.php" class="nav-link"><i class="bi bi-people me-2"></i>Users</a>
      <a href="teachers.php" class="nav-link active"><i class="bi bi-person-video3 me-2"></i>Teachers</a>
      <a href="enrollment.php" class="nav-link"><i class="bi bi-card-checklist me-2"></i>Enrollment</a>
    </nav>
  </div>
  <div class="text-center mb-3">
    <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
  </div>
</div>

<!-- Konten -->
<main>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Tambah Guru</h3>
    <a href="teachers.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
  </div>

  <div class="card shadow-sm p-4">
    <h5 class="fw-bold text-primary mb-3">Form Tambah Guru</h5>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Title</label>
        <input type="text" name="title" class="form-control" placeholder="Contoh: TOEFL & IELTS Specialist" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Pengalaman</label>
        <input type="text" name="experience" class="form-control" rows="3" placeholder="Contoh: 8 Tahun Mengajar " required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Pendidikan</label>
        <input type="text" name="education" class="form-control" rows="2" placeholder="Masukkan riwayat pendidikan terakhir">
      </div>

      <button type="submit" class="btn btn-custom px-4"><i class="bi bi-save me-2"></i>Simpan</button>
    </form>
  </div>
</main>

</body>
</html>
