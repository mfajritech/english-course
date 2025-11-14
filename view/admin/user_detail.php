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

// Ambil ID user dari parameter GET
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// --- Ambil data user ---
$user_sql = "SELECT * FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user = $user_stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User tidak ditemukan.");
}

// --- Ambil data enrollment user ---
$sql = "SELECT e.id AS enroll_id, e.status, e.created_at,
               c.title AS course_title
        FROM enrollments e
        JOIN courses c ON e.course_id = c.id
        WHERE e.user_id = ?
        ORDER BY e.id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$enrollments = [];
while ($row = $result->fetch_assoc()) {
    $enrollments[] = $row;
}

// --- Proses konfirmasi / tolak ---
if (isset($_GET['enroll_id']) && isset($_GET['action'])) {
    $enroll_id = intval($_GET['enroll_id']);
    $action = $_GET['action'];

    if ($action === 'confirm') {
        $status = 'aktif';
    } elseif ($action === 'reject') {
        $status = 'ditolak';
    } else {
        $status = 'menunggu konfirmasi';
    }

    $stmt = $conn->prepare("UPDATE enrollments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $enroll_id);
    $stmt->execute();

    header("Location: user_detail.php?id=" . $user_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail User | Adzkia Admin</title>
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
      <a href="users.php" class="nav-link active"><i class="bi bi-people me-2"></i>Users</a>
      <a href="teachers.php" class="nav-link"><i class="bi bi-person-video3 me-2"></i>Teachers</a>
      <a href="enrollment.php" class="nav-link"><i class="bi bi-card-checklist me-2"></i>Enrollment</a>
      <a href="news.php" class="nav-link"><i class="bi bi-card-checklist me-2"></i>News</a>
    </nav>
  </div>
  <div class="text-center mb-3">
    <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
  </div>
</div>

<!-- Konten -->
<main>
  <div class="mb-4 d-flex justify-content-between align-items-center">
    <h3 class="fw-bold text-primary">Detail User</h3>
    <a href="users.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
  </div>

  <!-- Info User -->
  <div class="card p-3 shadow-sm mb-4">
    <h5 class="fw-bold mb-3 text-primary">Informasi Pengguna</h5>
    <div class="row">
      <div class="col-md-6">
        <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>No. HP:</strong> <?= htmlspecialchars($user['phone']) ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Alamat:</strong> <?= htmlspecialchars($user['address']) ?></p>
        <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($user['birth']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
      </div>
    </div>
  </div>

  <!-- Daftar Enrollment -->
  <div class="card p-3 shadow-sm">
    <h5 class="fw-bold mb-3 text-primary">Daftar Kelas yang Didaftarkan</h5>
    <table class="table table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Nama Kelas</th>
          <th>Tanggal Daftar</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($enrollments) > 0): ?>
          <?php foreach ($enrollments as $i => $e): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($e['course_title']) ?></td>
              <td><?= date('d M Y, H:i', strtotime($e['created_at'])) ?></td>
              <td>
                <?php
                  $badgeClass = match($e['status']) {
                    'aktif' => 'bg-success',
                    'ditolak' => 'bg-danger',
                    'pending', 'menunggu konfirmasi' => 'bg-warning text-dark',
                    default => 'bg-secondary'
                  };
                ?>
                <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($e['status']) ?></span>
              </td>
              <td>
                <?php if($e['status'] == 'menunggu konfirmasi' || $e['status'] == 'pending'){ ?>
                  <a href="user_detail.php?id=<?= $user_id ?>&enroll_id=<?= $e['enroll_id'] ?>&action=confirm" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i></a>
                  <a href="user_detail.php?id=<?= $user_id ?>&enroll_id=<?= $e['enroll_id'] ?>&action=reject" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i></a>
                <?php } else { ?>
                  <span class="text-muted">-</span>
                <?php } ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5" class="text-center text-muted">Belum ada pendaftaran kelas</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
