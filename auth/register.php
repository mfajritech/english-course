<?php
include '../config/database.php';

$db = new Database();
$conn = $db->conn;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_ver = trim($_POST['password_ver']);
    $phone = trim($_POST['phone']);
    $name = trim($_POST['name']);
    $birth = trim($_POST['birth']);
    $address = trim($_POST['address']);

    if ($password !== $password_ver) {
        $message = "Password yang dimasukkan tidak sesuai!";
    } else {
        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "email telah terdaftar!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (phone, email, address, name, birth, password, role) VALUES (?, ?, ?, ?, ?, ?, 'user')");
            $stmt->bind_param("ssssss",$phone, $email, $address, $name, $birth, $hashed);
            if ($stmt->execute()) {
                header("Location: login.php?register=success");
                exit;
            } else {
                $message = "Gagal mendaftar. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <title>Register</title>
</head>
<body style="background-color: rgb(239, 250, 255); min-height: 100vh;">
  <div class="container d-flex justify-content-center align-items-center py-5" style="min-height: 100vh;">
    <div class="card p-4  shadow border-0" style="width: 100%; max-width: 420px; border-radius: 15px; background-color: white;">
      <h2 class="fw-bold text-center mb-3">Daftar Akun</h2>
      <p class="text-center text-muted mb-4" style="font-size: 14px;">Silakan isi data Anda untuk membuat akun baru</p>
        <?php if($message != '') {?>
            <p class="text-danger">*<?=$message?></p>
        <?php }?>
      <form action="" method="POST">
        <div class="form-floating mb-3">
          <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nama Lengkap" required>
          <label for="floatingName">Nama Lengkap</label>
        </div>

        <div class="form-floating mb-3">
          <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
          <label for="floatingEmail">Alamat Email</label>
        </div>

        <div class="form-floating mb-3">
          <input type="tel" name="phone" class="form-control" id="floatingPhone" placeholder="081234567890" required>
          <label for="floatingPhone">Nomor HP</label>
        </div>

        <div class="form-floating mb-3">
          <input type="date" name="birth" class="form-control" id="floatingBirth" required>
          <label for="floatingBirth">Tanggal Lahir</label>
        </div>

        <div class="form-floating mb-3">
          <textarea class="form-control" name="address" placeholder="Alamat Lengkap" id="floatingAddress" style="height: 80px;" required></textarea>
          <label for="floatingAddress">Alamat Lengkap</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
          <label for="floatingPassword">Kata Sandi</label>
        </div>

        <div class="form-floating mb-4">
          <input type="password" name="password_ver" class="form-control" id="floatingConfirm" placeholder="Konfirmasi Password" required>
          <label for="floatingConfirm">Konfirmasi Kata Sandi</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Daftar Sekarang</button>

        <p class="text-center mt-3 mb-0" style="font-size: 14px;">
          Sudah punya akun?
          <a href="login.php" class="text-decoration-none fw-bold text-primary">Login</a>
        </p>
      </form>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
