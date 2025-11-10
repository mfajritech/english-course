<?php
session_start();
include '../config/database.php';

$db = new Database();
$conn = $db->conn;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ambil data user berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // cek password
        if (password_verify($password, $user['password'])) {
            // simpan session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // redirect ke dashboard
            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
            exit;
        } else {
            $message = "Password salah.";
        }
    } else {
        $message = "Email tidak ditemukan.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <title>Login</title>
</head>
<body style="background-color: rgb(239, 250, 255); min-height: 100vh;">
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow border-0" style="width: 100%; max-width: 380px; border-radius: 15px; background-color: white;">
      <h2 class="fw-bold text-center mb-3">Login</h2>
      <p class="text-center text-muted mb-4" style="font-size: 14px;">Silakan masuk untuk melanjutkan</p>

      <form action="" method="POST">
        <div class="form-floating mb-3">
          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
          <label for="floatingInput">Alamat Email</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
          <label for="floatingPassword">Kata Sandi</label>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberMe">
            <label class="form-check-label small" for="rememberMe">Ingat saya</label>
          </div>
          <a href="#" class="text-decoration-none small text-primary">Lupa password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Masuk</button>

        <p class="text-center mt-3 mb-0" style="font-size: 14px;">
          Belum punya akun?
          <a href="register.php" class="text-decoration-none fw-bold text-primary">Daftar</a>
        </p>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
