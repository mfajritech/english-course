<?php
include 'config/database.php';

$db = new Database();
$conn = $db->conn;

// Query untuk ambil semua data course
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

// Inisialisasi array kosong
$courses = [];

// Jika ada hasil
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'slogan' => $row['slogan'],
            'description' => $row['description'],
            'duration' => $row['duration'],
            'capacity' => $row['capacity'],
            'mode' => $row['mode'],
            'schedule' => $row['schedule'],
            'teacher_id' => $row['teacher_id'],
            'lesson' => $row['lesson']
        ];
    }
} else {
    $courses = [];
}
$teacherQuery = $conn->query("SELECT * FROM teachers LIMIT 4");
$teachers = $teacherQuery->fetch_all(MYSQLI_ASSOC);


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
      <a class="navbar-brand fw-bold" href="index.php">
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

  <!-- Hero Section -->
  <section class="hero text-center text-lg-start">
    <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-between">
      <div class="col-lg-6">
        <h1 class="fw-bold display-5 mb-3">Belajar Bahasa Inggris dengan Cara yang Seru dan Efektif</h1>
        <p class="lead mb-4">Tingkatkan kemampuan speaking, listening, dan grammar kamu bersama mentor profesional. 
        Nikmati pengalaman belajar online interaktif dari mana saja.</p>
        <a href="/auth/login.php" class="btn btn-orange rounded-pill px-4 py-2">Mulai Belajar</a>
      </div>
      <div class="col-lg-5 mt-5 mt-lg-0 text-center">
        <img src="https://cdn-icons-png.flaticon.com/512/201/201818.png" class="img-fluid" width="350" alt="Online Class">
      </div>
    </div>
  </section>

    <!-- Course Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Kelas Terpopuler</h2>
            <div class="row g-4">

                <?php for($i = 0; $i <3; $i ++){ ?>

                <div class="col-md-4">
                    <div class="card p-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/4762/4762316.png" class="mx-auto mb-3"
                            width="100" alt="Beginner">
                        <h5 class="fw-bold"><?php echo $courses[$i]["title"] ?></h5>
                        <p class="course-slogan"><?php echo $courses[$i]["slogan"] ?></p>
                        <a href="view/course_detail.php?id=<?php echo $i + 1 ?>" class="btn btn-orange w-100">Daftar
                            Sekarang</a>
                    </div>
                </div>

                <?php } ?>

      </div>
    </div>
  </section>
  
   <div class=" py-4" style="background-color: lightgray;">
    <h3 class="text-center fw-bold" style="color: black;">Diajar Langsung Oleh Profesional</h3>
    <div class="row m-0 p-3">

    <?php foreach($teachers as $teacher):?>
      <div class="col-3">
        <div class="card p-2 bg-dark">
          <p class="fw-bold fs-5 mb-0" style="color: orange;"><?=$teacher['name']?></p>
          <p class="mb-0 text-light"><?=$teacher['title']?></p>
          <p class="text-secondary mb-0"><?=$teacher['education']?></p>
        </div>
      </div>
    <?php endforeach?>

    </div>
  </div>

  <div class="row m-0 py-5">
    <div class="col-4 d-flex justify-content-center align-items-center">
        <h1 class="d-inline-block fw-bold">Adzkia<span class="fs-6 fw-normal">english academy</span>
        </h1>
    </div>
    <div class="col-lg-8">
      <h3 class="fw-bold mb-3">Apa keunggulan Adzkia English Academy?</h3>
      <div class="card p-3 mb-3">
        <ul class="list-group list-group-flush">

              <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i>Berpengalaman lebih dari 10 tahun</li>
              <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i>Harga murah mulai dari 499k</li>
              <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i>Dibimbing oleh guru profesional</li>
              <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i>Pembelajaran interaktif dan menyenangkan</li>
              <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i>Terdapat kelas luring dan daring</li>

        </ul>
      </div>
    </div>
  </div>

    <div class="row m-0" style="background-color: lightgray;">
      <div class="col-3 d-flex justify-content-center align-items-center">
        <img src="/assets/images/teacher.png" alt="" width="300px">
      </div>
      <div class="col-9 d-flex justify-content-center align-items-center">
        <div>
          <h1 class="fw-bold pb-3">Ayo Tingkatkan Skill Berbahasa Inggris Kamu Bersama Adzkia English Academy</h1>
          <a href="/auth/register.php" class="text-decoration-none fw-bold py-2 px-3 rounded-pill bg-warning text-dark">Daftar Sekarang!</a>
        </div>
      </div>
    </div>

    <footer class="text-center">
        <p class="mb-0">&copy; 2025 Adzkia English Academy</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>