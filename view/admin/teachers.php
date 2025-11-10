<?php
include '../../config/database.php';

$db = new Database();
$conn = $db->conn;

// Ambil semua teacher dari database
$sql = "SELECT * FROM teachers ORDER BY id ASC";
$result = $conn->query($sql);

$teachers = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pengajar | Adzkia Admin</title>
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
        <a href="course.php" class="nav-link"><i class="bi bi-book me-2"></i>Course</a>
        <a href="users.php" class="nav-link"><i class="bi bi-people me-2"></i>Users</a>
        <a href="teachers.php" class="nav-link active"><i class="bi bi-person-video3 me-2"></i>Teachers</a>
        </nav>
    </div>
    <div class="text-center mb-3">
      <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
    </div>
  </div>

<!-- Konten -->
<main>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Data Pengajar</h3>
    <a href="add_teacher.php" class="btn btn-custom"><i class="bi bi-plus-circle me-2"></i>Tambah Pengajar</a>
  </div>

  <div class="row g-4">
    <?php if (count($teachers) > 0): ?>
      <?php foreach ($teachers as $t): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="fw-bold"><?= htmlspecialchars($t['name']) ?></h5>
              <p class="text-muted mb-1"><?= htmlspecialchars($t['title']) ?></p>
              <p class="small mb-1"><i class="bi bi-mortarboard me-1"></i><?= htmlspecialchars($t['education']) ?></p>
              <p class="text-secondary small mb-3"><i class="bi bi-clock-history me-1"></i><?= htmlspecialchars($t['experience']) ?></p>
              <div class="d-flex justify-content-center gap-2">
                <a href="edit_teacher.php?id=<?= $t['id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                <a href="delete_teacher.php?id=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pengajar ini?')"><i class="bi bi-trash"></i></a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">Belum ada data pengajar</p>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
