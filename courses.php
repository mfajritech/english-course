<?php
include 'config/database.php';

$db = new Database();
$conn = $db->conn;

$courseQuery = $conn->query("SELECT * FROM courses");
$courses = $courseQuery->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adzkia English Academy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/index.css">

</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">
        Adzkia <span>English Academy</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center">
          <li class="nav-item"><a class="nav-link text-light px-3" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link text-light px-3" href="courses.php">Kelas</a></li>
          <li class="nav-item"><a class="nav-link text-light px-3" href="#">Tentang</a></li>
          <li class="nav-item ms-lg-3">
            <a href="/auth/login.php" class="btn btn-orange rounded-pill px-3">Masuk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div style="min-height: 75vh;">
    <div class="row g-4 my-5 mx-0">
        <?php foreach ($courses as $course): ?>
            <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4762/4762316.png" class="mx-auto mb-3" width="100" alt="Beginner">
                <h5 class="fw-bold"><?php echo $course["title"] ?></h5>
                <p class="course-slogan"><?php echo $course["slogan"] ?></p>
                <a href="/view/course_detail.php?id=<?php echo $course['id'] ?>" class="text-decoration-none text-dark py-1 px-3 fw-bold rounded-2" style="background-color: orange !important;">Daftar Sekarang</a>
                </div>
            </div>
            </div>
        <?php endforeach; ?>
    </div>
  </div>

  <footer class="text-center">
    <p class="mb-0">&copy; 2025 Adzkia English Academy</p>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
