<?php
session_start();
include '../../config/database.php';

session_start();

// Jika user belum login, arahkan ke login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;

$user_id = $_SESSION['user_id'];

// --- LOGIC UPDATE PROFIL ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validasi sederhana
    if (empty($name) || empty($phone) || empty($address)) {
        $error = "Semua field wajib diisi!";
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $phone, $address, $user_id);

        if ($stmt->execute()) {
            $success = "Profil berhasil diperbarui!";
        } else {
            $error = "Terjadi kesalahan saat memperbarui data.";
        }

        $stmt->close();
    }
}

// Ambil ulang data user terbaru setelah update
$userQuery = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $userQuery->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil | Adzkia English Academy</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #e0f7ff, #f7faff);
    font-family: 'Poppins', sans-serif;
}
.sidebar {
    height: 100vh;
    background: #0f4db7;
    color: #fff;
    position: fixed;
    top: 0; left: 0;
    width: 220px;
    display: flex; flex-direction: column; justify-content: space-between;
}
.sidebar .brand {
    font-size: 1.4rem; font-weight: 700; text-align: center; padding: 1.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.sidebar .nav-link {
    color: #fff; font-weight: 500; padding: 12px 20px;
    border-radius: 10px; margin: 5px 10px; transition: 0.3s; display: flex; align-items: center;
}
.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    background: #ffb703; color: #0f4db7;
}
.sidebar .nav-link i { margin-right: 8px; }
main { margin-left: 220px; padding: 30px; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div>
        <div class="brand">Adzkia</div>
        <nav class="nav flex-column px-2">
            <a href="dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i>Dashboard</a>
            <a href="course.php" class="nav-link"><i class="bi bi-book"></i>Kursus</a>
            <a href="profil.php" class="nav-link active"><i class="bi bi-person-circle"></i>Profil</a>
        </nav>
    </div>
    <div class="text-center mb-3">
      <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
    </div>
</div>

<!-- Main Content -->
<main id="mainContent">
    <div class="card shadow-sm p-4">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-person-lines-fill me-2"></i>Profil-mu!</h5>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" id="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">No. HP</label>
                <input type="text" name="phone" class="form-control" id="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address" style="height: 80px;" required><?= htmlspecialchars($user['address']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-warning w-100">Simpan</button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
