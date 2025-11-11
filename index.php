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

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adzkia English Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/about.css">

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
                    <li class="nav-item"><a class="nav-link text-light px-3" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link text-light px-3" href="#">Kelas</a></li>
                    <li class="nav-item"><a class="nav-link text-light px-3" href="about.php">Tentang</a></li>
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
                <p class="lead mb-4">Tingkatkan kemampuan speaking, listening, dan grammar kamu bersama mentor
                    profesional.
                    Nikmati pengalaman belajar online interaktif dari mana saja.</p>
                <a href="#" class="btn btn-orange rounded-pill px-4 py-2">Mulai Belajar</a>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/201/201818.png" class="img-fluid" width="350"
                    alt="Online Class">
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

    <!-- Visi & Misi -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Visi & Misi</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card card-animated p-4 shadow-sm h-100">
                        <h4 class="fw-bold mb-3">Visi</h4>
                        <p>Menciptakan generasi muda yang mahir berbahasa Inggris, percaya diri, dan siap menghadapi
                            tantangan global.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-animated p-4 shadow-sm h-100">
                        <h4 class="fw-bold mb-3">Misi</h4>
                        <ul class="list-unstyled">
                            <li>• Metode belajar interaktif dan menyenangkan</li>
                            <li>• Mentor profesional dan berpengalaman</li>
                            <li>• Fokus pada kemampuan praktis bahasa Inggris</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan -->
    <section class="py-5" style="background: #e6f2ff;">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Keunggulan Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card card-animated h-100 text-center">
                        <i class="bi bi-person-badge"></i>
                        <h5 class="fw-bold mb-2 mt-2">Mentor Profesional</h5>
                        <p>Mentor berpengalaman yang membimbing peserta dengan metode terbaik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card-animated h-100 text-center">
                        <i class="bi bi-laptop"></i>
                        <h5 class="fw-bold mb-2 mt-2">Belajar Online Interaktif</h5>
                        <p>Kelas interaktif dapat diakses dari mana saja sesuai jadwal peserta.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card card-animated h-100 text-center">
                        <i class="bi bi-award"></i>
                        <h5 class="fw-bold mb-2 mt-2">Sertifikat Resmi</h5>
                        <p>Peserta mendapatkan sertifikat resmi sebagai bukti pencapaian.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline / Sejarah -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Sejarah Singkat</h2>
            <div class="timeline">
                <div class="timeline-item timeline-item-left card-animated">
                    <h5>2015</h5>
                    <p>Didirikan sebagai lembaga kursus kecil untuk anak-anak dan remaja.</p>
                </div>
                <div class="timeline-item timeline-item-right card-animated">
                    <h5>2018</h5>
                    <p>Mulai membuka kelas online dan memperluas jangkauan peserta di seluruh Indonesia.</p>
                </div>
                <div class="timeline-item timeline-item-left card-animated">
                    <h5>2022</h5>
                    <p>Menjadi salah satu akademi bahasa Inggris terkemuka dengan mentor profesional.</p>
                </div>
            </div>
        </div>
    </section>

    <script>
    // Animasi scroll untuk card
    function reveal() {
        const cards = document.querySelectorAll('.card-animated');
        for (let i = 0; i < cards.length; i++) {
            let windowHeight = window.innerHeight;
            let elementTop = cards[i].getBoundingClientRect().top;
            let elementVisible = 150;
            if (elementTop < windowHeight - elementVisible) {
                cards[i].classList.add('show');
            }
        }
    }
    window.addEventListener('scroll', reveal);
    window.addEventListener('load', reveal);
    </script>


    <footer class="text-center">
        <p class="mb-0">&copy; 2025 Adzkia English Academy</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>