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

// === LOGIC DELETE COURSE ===
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']); // pastikan integer biar aman

    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>
            alert('Kursus berhasil dihapus!');
            window.location.href = 'course.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Gagal menghapus kursus!');
            window.location.href = 'course.php';
        </script>";
        exit;
    }
}

// === AMBIL DATA KURSUS ===
$sql = "SELECT c.*, t.name AS teacher_name 
        FROM courses c 
        LEFT JOIN teachers t ON c.teacher_id = t.id 
        ORDER BY c.id DESC";
$result = $conn->query($sql);

$courses = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Kursus | Adzkia Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7faff;
      font-family: 'Poppins', sans-serif;
    }
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
    <h3 class="fw-bold text-primary">Manajemen Kursus</h3>
    <a href="add_course.php" class="btn btn-custom"><i class="bi bi-plus-circle me-2"></i>Tambah Kursus</a>
  </div>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Kursus berhasil dihapus.</div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-danger">Gagal menghapus kursus.</div>
  <?php endif; ?>

  <div class="card p-3 shadow-sm">
    <table class="table table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Nama Kursus</th>
          <th>Durasi</th>
          <th>Tutor</th>
          <th>Mode</th>
          <th>Jadwal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($courses) > 0): ?>
          <?php foreach ($courses as $i => $c): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($c['title']) ?></td>
              <td><?= htmlspecialchars($c['duration']) ?> Bulan</td>
              <td><?= htmlspecialchars($c['teacher_name'] ?? '-') ?></td>
              <td><?= htmlspecialchars($c['mode']) ?></td>
              <td><?= htmlspecialchars($c['schedule']) ?></td>
              <td>
                <a href="course.php?delete=<?= $c['id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin menghapus kursus ini?')">
                   <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">Belum ada kursus</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
