<?php
include '../../config/database.php';
$db = new Database();
$conn = $db->conn;

// Ambil data ringkas
$courses = $conn->query("SELECT * FROM courses ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
$users = $conn->query("SELECT * FROM users WHERE role='user' ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
$teachers = $conn->query("SELECT * FROM teachers ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

// Hitung total
$totalCourses = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()['total'];
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='user'")->fetch_assoc()['total'];
$totalTeachers = $conn->query("SELECT COUNT(*) AS total FROM teachers")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Adzkia English Academy</title>
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
      font-size: 1.3rem; font-weight: bold; text-align: center;
      padding: 1.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar .nav-link {
      color: #fff; font-weight: 500; padding: 12px 20px;
      border-radius: 8px; margin: 4px 12px;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active { background-color: #ffb703; color: #0f4db7; }
    main { margin-left: 250px; padding: 30px; }
    .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
    .info-card { background-color: #fff; border-radius: 12px; padding: 20px;
      text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .info-card h3 { color: #0f4db7; font-weight: bold; }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <div class="brand">Adzkia Admin</div>
      <nav class="nav flex-column px-2">
        <a href="dashboard.php" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        <a href="course.php" class="nav-link"><i class="bi bi-book me-2"></i>Course</a>
        <a href="users.php" class="nav-link"><i class="bi bi-people me-2"></i>Users</a>
        <a href="teachers.php" class="nav-link"><i class="bi bi-person-video3 me-2"></i>Teachers</a>
        </nav>
    </div>
    <div class="text-center mb-3">
      <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
    </div>
  </div>

  <!-- Konten -->
  <main>
    <h2 class="fw-bold text-primary mb-4">Dashboard Admin</h2>

    <!-- Statistik -->
    <div class="row g-4 mb-4 text-center">
      <div class="col-md-4">
        <div class="info-card">
          <i class="bi bi-book text-warning fs-2 mb-2"></i>
          <h3><?= $totalCourses ?></h3>
          <p>Total Kursus</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-card">
          <i class="bi bi-people text-success fs-2 mb-2"></i>
          <h3><?= $totalUsers ?></h3>
          <p>Total Peserta</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-card">
          <i class="bi bi-person-video3 text-info fs-2 mb-2"></i>
          <h3><?= $totalTeachers ?></h3>
          <p>Total Tutor</p>
        </div>
      </div>
    </div>

    <!-- Tabel Kursus -->
    <div class="card p-4 mb-4">
      <h5 class="fw-bold text-primary mb-3"><i class="bi bi-book me-2"></i>5 Kursus Terbaru</h5>
      <table class="table table-hover align-middle mb-0">
        <thead class="table-primary"><tr><th>#</th><th>Nama Kursus</th><th>Durasi</th></tr></thead>
        <tbody>
          <?php if($courses): foreach($courses as $i => $c): ?>
          <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($c['title']) ?></td><td><?= htmlspecialchars($c['duration']) ?> Bulan</td></tr>
          <?php endforeach; else: ?>
          <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Tabel Peserta -->
    <div class="card p-4 mb-4">
      <h5 class="fw-bold text-success mb-3"><i class="bi bi-people me-2"></i>5 Peserta Terbaru</h5>
      <table class="table table-hover align-middle mb-0">
        <thead class="table-success"><tr><th>#</th><th>Nama</th><th>Email</th></tr></thead>
        <tbody>
          <?php if($users): foreach($users as $i => $u): ?>
          <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($u['name']) ?></td><td><?= htmlspecialchars($u['email']) ?></td></tr>
          <?php endforeach; else: ?>
          <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Tabel Tutor -->
    <div class="card p-4">
      <h5 class="fw-bold text-info mb-3"><i class="bi bi-person-video3 me-2"></i>5 Tutor Terbaru</h5>
      <table class="table table-hover align-middle mb-0">
        <thead class="table-info"><tr><th>#</th><th>Nama Tutor</th><th>Pengalaman</th></tr></thead>
        <tbody>
          <?php if($teachers): foreach($teachers as $i => $t): ?>
          <tr><td><?= $i+1 ?></td><td><?= htmlspecialchars($t['name']) ?></td><td><?= htmlspecialchars($t['experience']) ?></td></tr>
          <?php endforeach; else: ?>
          <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>
</body>
</html>
