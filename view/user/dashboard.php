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

$userQuery = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $userQuery->fetch_assoc();

$courseQuery = $conn->query("SELECT * FROM courses");
$courses = $courseQuery->fetch_all(MYSQLI_ASSOC);

$teacherQuery = $conn->query("SELECT * FROM teachers");
$teachers = $teacherQuery->fetch_all(MYSQLI_ASSOC);

$enrollQuery = $conn->query("SELECT * FROM enrollments WHERE user_id=$user_id");
$enrollments = $enrollQuery->fetch_all(MYSQLI_ASSOC);

$myCourses = [];
$myTeachers = [];

foreach($enrollments as $e){
    array_filter($courses, function($a) use ($user_id, $e, &$myCourses, $teachers, &$myTeachers) {
        if($e['course_id'] == $a['id']){
            $myCourses[] = $a;
            array_filter($teachers, function($b) use ($a, &$myTeachers) {
                if($a['teacher_id'] == $b['id']){
                    $myTeachers[] = $b;
                }
                return true;
            });
        }
        return true;
    });
}
$myCourses = array_values($myCourses);
if(count($myTeachers) != 0){
    $myTeachers = array_values($myTeachers);
}


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

/* Sidebar */
.sidebar {
    height: 100vh;
    background: #0f4db7;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    width: 220px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: width 0.3s;
}
.sidebar .brand {
    font-size: 1.4rem;
    font-weight: 700;
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.sidebar .nav-link {
    color: #fff;
    font-weight: 500;
    padding: 12px 20px;
    border-radius: 10px;
    margin: 5px 10px;
    transition: 0.3s;
    display: flex;
    align-items: center;
}
.sidebar .nav-link:hover,
.sidebar .nav-link.active {
    background: #ffb703;
    color: #0f4db7;
}
.sidebar .nav-link i { margin-right: 8px; }

/* Main content */
main {
    margin-left: 220px;
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

/* Responsive */
@media(max-width:768px) {
    .sidebar { width: 70px; }
    main { margin-left: 70px; padding: 20px; }
    .header { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div>
        <div class="brand">Adzkia</div>
        <nav class="nav flex-column px-2">
            <a href="dashboard.php" class="nav-link active"><i class="bi bi-speedometer2"></i>Dashboard</a>
            <a href="course.php" class="nav-link"><i class="bi bi-book"></i>Kursus</a>
            <a href="profil.php" class="nav-link"><i class="bi bi-person-circle"></i>Profil</a>
        </nav>
    </div>
    <div class="text-center mb-3">
      <a href="../auth/logout.php" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
    </div>
</div>

<main id="mainContent">
    <div class="header">
        <h2>Selamat Datang, <?php echo $user['name']; ?>!</h2>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="info-card">
                <i class="bi bi-book text-warning fs-2 mb-2"></i>
                <h3><?php echo count($enrollments); ?></h3>
                <p>Total Kursus</p>
            </div>
        </div>
         <div class="card p-4 mb-4">
            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-book me-2"></i>Kursus Diambil</h5>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama Kursus</th>
                        <th>Nama Guru</th>
                        <th>Jadwal</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($myCourses): foreach($myCourses as $i => $c): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($c['title']) ?></td>
                        <td><?= htmlspecialchars($myTeachers[$i]['name']) ?></td>
                        <td><?= htmlspecialchars($c['schedule']) ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="3" class="text-center text-muted">Belum ada data.</td></tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
