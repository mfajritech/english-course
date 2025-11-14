<?php
session_start();
include '../../config/database.php';

$db = new Database();
$conn = $db->conn;

// Jika user belum login, arahkan ke login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['id'];

$userQuery = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $userQuery->fetch_assoc();

$courseQuery = $conn->query("SELECT * FROM courses WHERE id=$course_id");
$course = $courseQuery->fetch_assoc();

$enrollQuery = $conn->query("SELECT * FROM enrollments WHERE user_id=$user_id AND course_id=$course_id");
$enroll = $enrollQuery->fetch_assoc();

$teacher_id = $course['teacher_id'];
$teacherQuery = $conn->query("SELECT * FROM teachers WHERE id=$teacher_id");
$teacher = $teacherQuery->fetch_assoc();

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
            <h2><?=$course['title']?></h2>
            <p><?=$teacher['name']?></p>
        </div>
    </div>

    <h4 class="fw-bold text-dark " style="">Deskripsi kelas</h4>
    <table class="table shadow">
        <tr>
            <td>Judul</td>
            <td>:</td>
            <td><?=$course['title']?></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>:</td>
            <td><?=$course['description']?></td>
        </tr>
        <tr>
            <td>Durasi</td>
            <td>:</td>
            <td><?=$course['duration'] . ' Bulan'?></td>
        </tr>
        <tr>
            <td>Metode</td>
            <td>:</td>
            <td><?=$course['mode']?></td>
        </tr>
        <tr>
            <td>Guru</td>
            <td>:</td>
            <td><?=$teacher['name']?></td>
        </tr>
        <tr>
            <td>Materi</td>
            <td>:</td>
            <td><?=$course['lesson']?></td>
        </tr>
    </table>

    <?php if($enroll['status'] == 'menunggu konfirmasi'){?>
        <h4 class="fw-bold text-dark mt-5 text-center">Kursus menunggu konfirmasi Admin!</h4>
    <?php } else{ ?>
        <h4 class="fw-bold text-secondary mt-5">Video pendukung</h4>
        <div class="video-wrapper mx-auto shadow-lg">
        <div class="ratio ratio-16x9 rounded-4 overflow-hidden">
            <iframe 
            src="https://www.youtube.com/embed/0zbPeoZzcPg?si=B8sxlMjAfEHxY1Fl" 
            title="YouTube video player" 
            allowfullscreen
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
        </div>
    <?php }?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
