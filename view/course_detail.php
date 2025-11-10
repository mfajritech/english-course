<?php
include '../config/database.php';

$db = new Database();
$conn = $db->conn;

// Ambil ID dari URL (dan pastikan aman)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Siapkan query (pakai prepared statement biar aman)
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$course = $result->fetch_assoc();

// Jika tidak ditemukan
if (!$course) {
    echo "Course not found!";
    exit;
}
else{
    $lessons = explode(',', $course['lesson']);
    $lessons = array_map('trim', $lessons);

    // Siapkan query (pakai prepared statement biar aman)
    $stmt = $conn->prepare("SELECT * FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $course['teacher_id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>English for Beginner | Adzkia English Academy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7faff;
      font-family: 'Poppins', sans-serif;
    }

    /* Hero section */
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
        url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1200&q=80') center/cover;
      color: #fff;
      padding: 120px 0;
      border-bottom-left-radius: 40px;
      border-bottom-right-radius: 40px;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    /* Card & button */
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .btn-enroll {
      background-color: #ffb703;
      border: none;
      color: white;
      font-weight: 600;
    }

    .btn-enroll:hover {
      background-color: #f48c06;
    }

    /* Divider */
    hr {
      border: none;
      height: 2px;
      background: linear-gradient(to right, transparent, #0d6efd, transparent);
      margin: 3rem 0;
    }
  </style>
</head>

<body>

  <!-- Hero -->
  <section class="hero text-center">
    <div class="container">
      <h1><?=$course['title']?></h1>
      <p class="lead mt-3"><?=$course['slogan']?></p>
    </div>
  </section>

  <!-- Detail Kursus -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <img src="https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=900&q=80"
            alt="English for Beginner" class="img-fluid rounded-4 shadow-sm">
        </div>

        <div class="col-lg-6">
          <h2 class="fw-bold mb-3 text-primary">Deskripsi Kursus</h2>
          <p class="text-muted"><?=$course['description']?></p>

          <ul class="list-unstyled mt-4">
            <li><i class="bi bi-clock text-primary me-2"></i> Durasi: <?=$course['duration']?> Bulan</li>
            <li><i class="bi bi-people text-primary me-2"></i> Kapasitas: <?=$course['capacity']?> Peserta</li>
            <li><i class="bi bi-laptop text-primary me-2"></i> Mode: <?=$course['mode']?></li>
            <li><i class="bi bi-calendar-check text-primary me-2"></i> Jadwal: <?=$course['schedule']?></li>
          </ul>

          <div class="mt-4">
            <h4 class="fw-bold text-primary mb-3">Rp <?=$course['price']?></h4>
            <a href="#" class="btn btn-enroll btn-lg px-4"><i class="bi bi-cart-check me-2"></i>Daftar Sekarang</a>
          </div>
        </div>
      </div>

      <hr>

      <!-- Materi dan Tutor -->
      <div class="row mt-5">
        <!-- Materi -->
        <div class="col-lg-8">
          <h3 class="fw-bold mb-3">Apa yang Akan Kamu Pelajari?</h3>
          <div class="card p-3 mb-3">
            <ul class="list-group list-group-flush">

                <?php foreach($lessons as $lesson){ ?>

                     <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i><?=$lesson?></li>

                <?php } ?>

            </ul>
          </div>
        </div>

        <!-- Tutor -->
        <div class="col-lg-4">
          <div class="card p-4 text-center">
            <img src="https://randomuser.me/api/portraits/men/35.jpg" alt="Tutor" class="rounded-circle mx-auto mb-3"
              width="90" height="90">
            <h5 class="fw-bold mb-1"><?=$teacher['name']?></h5>
            <p class="text-muted small mb-3"><?=$teacher['title']?></p>
            <p class="text-muted mb-2"><i class="bi bi-translate text-primary me-2"></i><?=$teacher['experience']?>/p>
            <p class="text-muted"><i class="bi bi-mortarboard text-primary me-2"></i><?=$teacher['education']?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-primary text-light text-center py-3">
    <p class="mb-0">© 2025 Adzkia English Academy | All Rights Reserved</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>