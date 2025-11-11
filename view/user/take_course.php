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

$courseQuery = $conn->query("SELECT * FROM courses");
$courses = $courseQuery->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Adzkia English Academy</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
<style>
/* Body & Fonts */
body {
    background: linear-gradient(135deg, #e0f7ff, #f7faff);
    font-family: 'Poppins', sans-serif;
}

main {
    padding: 30px;
    transition: margin-left 0.3s;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}
.header h2 { font-weight: 700; color: #0f4db7; }
.profile-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #ccc;
}

/* Info Card */
.info-card {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}
.info-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.12); }
.info-card h3 { color: #0f4db7; font-weight: 700; font-size: 2rem; }
.info-card p { font-weight: 500; color: #555; }

.video-section {
  background: linear-gradient(135deg, #e0f7ff, #f7faff);
}
.video-wrapper {
  max-width: 800px;
  border: 5px solid #fff;
  border-radius: 20px;
  transition: transform 0.3s, box-shadow 0.3s;
}
.video-wrapper:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Responsive */
@media(max-width:768px) {
    .sidebar { width: 70px; }
    main { margin-left: 70px; padding: 20px; }
    .header { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>
</head>
<body>

<main id="mainContent">
    <div class="mb-3">
        <a href="course.php" class="d-inline-block px-3 py-2 text-decoration-none fw-bold text-black bg-warning rounded-pill">Kembali</a>
    </div>
    <div class="header">
        <div>
            <h2>Pilih kelasmu sekarang!</h2>
        </div>
    </div>

    <div class="row g-4">
      <?php foreach ($courses as $course): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
               <img src="https://cdn-icons-png.flaticon.com/512/4762/4762316.png" class="mx-auto mb-3" width="100" alt="Beginner">
            <h5 class="fw-bold"><?php echo $course["title"] ?></h5>
            <p class="course-slogan"><?php echo $course["slogan"] ?></p>
            <a href="../course_detail.php?id=<?php echo $course['id'] ?>" class="text-decoration-none text-dark py-1 px-3 fw-bold rounded-2" style="background-color: orange !important;">Daftar Sekarang</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
  </div>
   

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
