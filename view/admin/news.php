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

// Ambil semua news dari database
$sql = "SELECT * FROM news ORDER BY id ASC";
$result = $conn->query($sql);

$news = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
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
    .clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
      <a href="teachers.php" class="nav-link"><i class="bi bi-person-video3 me-2"></i>Teachers</a>
      <a href="enrollment.php" class="nav-link"><i class="bi bi-card-checklist me-2"></i>Enrollment</a>
      <a href="news.php" class="nav-link active"><i class="bi bi-card-checklist me-2"></i>News</a>
    </nav>
    </div>
    <div class="text-center mb-3">
      <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
    </div>
  </div>

<!-- Konten -->
<main>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-primary">Berita</h3>
    <a href="add_news.php" class="btn btn-custom"><i class="bi bi-plus-circle me-2"></i>Tambah Berita</a>
  </div>

  <div class="row g-4">
    <?php if (count($news) > 0): ?>
      <?php foreach ($news as $t): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <a href="news_detail.php?id=<?= $t['id'] ?>" class="text-decoration-none text-dark">
                    <h5 class="fw-bold"><?= htmlspecialchars($t['title']) ?></h5>
                    <p class="text-muted mb-1 text-secondary"><?= htmlspecialchars($t['date']) ?></p>
                    <p class="small mb-1 clamp-2 text-secondary"></i><?= htmlspecialchars($t['content']) ?></p>
                </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">Belum ada berita</p>
    <?php endif; ?>
  </div>
</main>

</body>
</html>
