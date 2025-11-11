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

// Ambil daftar guru dari tabel teachers
$teachers = [];
$tResult = $conn->query("SELECT id, name, title FROM teachers ORDER BY name ASC");
if ($tResult && $tResult->num_rows > 0) {
  while ($row = $tResult->fetch_assoc()) {
    $teachers[] = $row;
  }
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $slogan = $_POST['slogan'];
  $description = $_POST['description'];
  $duration = $_POST['duration'];
  $capacity = $_POST['capacity'];
  $mode = $_POST['mode'];
  $schedule = $_POST['schedule'];
  $teacherId = $_POST['teacherId'];
  $lesson = $_POST['lesson'];
  $price = $_POST['price'];

  $stmt = $conn->prepare("INSERT INTO courses (title, slogan, description, duration, capacity, mode, schedule, teacher_id, lesson, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssisssssi",  $title, $slogan, $description, $duration, $capacity, $mode, $schedule, $teacherId, $lesson, $price);

  if ($stmt->execute()) {
    header("Location: course.php?success=1");
    exit;
  } else {
    $error = "Gagal menyimpan data kursus.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kursus | Adzkia Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f7faff; font-family: 'Poppins', sans-serif; }
    .sidebar {
      height: 100vh; background-color: #0f4db7; color: #fff;
      position: fixed; top: 0; left: 0; width: 250px;
      display: flex; flex-direction: column; justify-content: space-between;
    }
    .sidebar .brand {
      font-size: 1.3rem; font-weight: bold;
      text-align: center; padding: 1.5rem 0;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar .nav-link {
      color: #fff; font-weight: 500; padding: 12px 20px;
      border-radius: 8px; margin: 4px 12px;
    }
    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background-color: #ffb703; color: #0f4db7;
    }
    main { margin-left: 260px; padding: 30px; }
    .btn-custom { background-color: #ffb703; color: white; border: none; }
    .btn-custom:hover { background-color: #f48c06; }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div>
    <div class="brand">Adzkia Admin</div>
    <nav class="nav flex-column px-2">
      <a href="dashboard.php" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
      <a href="course.php" class="nav-link active"><i class="bi bi-book me-2"></i>Course</a>
      <a href="users.php" class="nav-link"><i class="bi bi-people me-2"></i>Users</a>
      <a href="teachers.php" class="nav-link"><i class="bi bi-person-video3 me-2"></i>Teachers</a>
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
    <h3 class="fw-bold text-primary">Tambah Kursus</h3>
    <a href="course.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
  </div>

  <div class="card shadow-sm p-4">
    <h5 class="fw-bold text-primary mb-3">Form Tambah Kursus</h5>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">

      <!-- Judul Kursus -->
      <div class="mb-3">
        <label for="title" class="form-label">Judul Kursus</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan Judul Kursus" required>
      </div>

      <!-- Slogan -->
      <div class="mb-3">
        <label for="slogan" class="form-label">Slogan</label>
        <input type="text" name="slogan" class="form-control" id="slogan" placeholder="Masukkan Slogan">
      </div>

      <!-- Deskripsi -->
      <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" id="description" rows="3" placeholder="Deskripsi Kursus"></textarea>
      </div>

      <!-- Durasi -->
      <div class="mb-3">
        <label for="duration" class="form-label">Durasi (jam/minggu)</label>
        <input type="number" name="duration" class="form-control" id="duration" placeholder="Contoh: 20 jam">
      </div>

      <!-- Kapasitas -->
      <div class="mb-3">
        <label for="capacity" class="form-label">Kapasitas</label>
        <input type="number" name="capacity" class="form-control" id="capacity" placeholder="Jumlah maksimal peserta">
      </div>

      <!-- Mode -->
      <div class="mb-3">
        <label for="mode" class="form-label">Mode</label>
        <select name="mode" class="form-select" id="mode">
          <option selected disabled>Pilih Mode</option>
          <option value="offline">Offline</option>
          <option value="online">Online</option>
          <option value="hybrid">Hybrid</option>
        </select>
      </div>

      <!-- Jadwal -->
      <div class="mb-3">
        <label for="schedule" class="form-label">Jadwal</label>
        <input type="text" name="schedule" class="form-control" id="schedule" placeholder="Contoh: Senin & Rabu 14:00-16:00">
      </div>

      <!-- Pengajar -->
      <div class="mb-3">
        <label for="teacherId" class="form-label">Pilih Pengajar</label>
        <select name="teacherId" id="teacherId" class="form-select" required>
          <option value="" disabled selected>Pilih Pengajar</option>
          <?php foreach ($teachers as $t): ?>
            <option value="<?= htmlspecialchars($t['id']) ?>">
              <?= htmlspecialchars($t['name']) ?> <?= $t['title'] ? '('.htmlspecialchars($t['title']).')' : '' ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Lesson -->
      <div class="mb-3">
        <label for="lesson" class="form-label">Materi / Lesson</label>
        <textarea name="lesson" class="form-control" id="lesson" rows="3" placeholder="Masukkan Materi / Lesson"></textarea>
      </div>

      <!-- Harga -->
      <div class="mb-3">
        <label for="price" class="form-label">Harga (Rp)</label>
        <input type="number" name="price" class="form-control" id="price" placeholder="Masukkan Harga Kursus">
      </div>

      <button type="submit" class="btn btn-custom w-100">Simpan</button>
    </form>
  </div>
</main>

</body>
</html>
