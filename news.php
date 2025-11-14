<?php
include 'config/database.php';

$db = new Database();
$conn = $db->conn;

$sql = "SELECT * FROM news ORDER BY id ASC LIMIT 4";
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
          <li class="nav-item"><a class="nav-link text-light px-3" href="news.php">Berita</a></li>
          <li class="nav-item"><a class="nav-link text-light px-3" href="#">Tentang</a></li>
          <li class="nav-item ms-lg-3">
            <a href="/auth/login.php" class="btn btn-orange rounded-pill px-3">Masuk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div style="min-height: 80vh;" class="py-4">
<h3 class="fw-bold text-primary text-center">- Berita -</h3>
  <div class="row m-0 p-3">
    <?php foreach($news as $n):?>
      <div class="col-6">
        <a href="/view/news.php?id= <?=$n['id'] ?>" class="card p-3 m-1 text-decoration-none">
          <h5 class="" style="color: orange;"><?=$n['title']?></h5>
          <p class="text-secondary mb-0" style="font-size: .8em;"><?=$n['date']?></p>
          <p class="course-slogan mb-0"><?=$n['content']?></p>
        </a>
      </div>
    <?php endforeach?>
  </div>
  </div>

  <footer class="text-center">
    <p class="mb-0">&copy; 2025 Adzkia English Academy</p>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
