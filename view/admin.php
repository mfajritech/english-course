<?php
include '../config/database.php';

$db = new Database();
$conn = $db->conn;

// course
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
$courses = [];
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

// course
$sql = "SELECT * FROM users WHERE role='user'";
$result = $conn->query($sql);
$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'id' => $row['id'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'name' => $row['name'],
            'birth' => $row['birth'],
            'address' => $row['address'],
            'role' => $row['role'],
        ];
    }
} else {
    $users = [];
}

// course
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);
$teachers = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'title' => $row['title'],
            'experience' => $row['experience'],
            'education' => $row['education'],
        ];
    }
} else {
    $teachers = [];
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Adzkia English Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        background-color: #f7faff;
        font-family: 'Poppins', sans-serif;
    }

    .sidebar {
        height: 100vh;
        background-color: #0f4db7;
        color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sidebar .brand {
        font-size: 1.3rem;
        font-weight: bold;
        text-align: center;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .sidebar .nav-link {
        color: #fff;
        font-weight: 500;
        padding: 12px 20px;
        border-radius: 8px;
        margin: 4px 12px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #ffb703;
        color: #0f4db7;
    }

    main {
        margin-left: 250px;
        padding: 30px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .btn-custom {
        background-color: #ffb703;
        color: #fff;
        border: none;
    }

    .btn-custom:hover {
        background-color: #f48c06;
    }

    .info-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .info-card h3 {
        color: #0f4db7;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="brand">Adzkia Admin</div>
            <nav class="nav flex-column px-2">
                <a href="#" class="nav-link active" data-page="dashboard"><i
                        class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a href="#" class="nav-link" data-page="kursus"><i class="bi bi-book me-2"></i>Kursus</a>
                <a href="#" class="nav-link" data-page="peserta"><i class="bi bi-people me-2"></i>Peserta</a>
                <a href="#" class="nav-link" data-page="tutor"><i class="bi bi-person-video3 me-2"></i>Tutor</a>
                <a href="#" class="nav-link" data-page="pengaturan"><i class="bi bi-gear me-2"></i>Pengaturan</a>
            </nav>
        </div>
        <div class="text-center mb-3">
            <a href="#" class="text-light text-decoration-none"><i class="bi bi-box-arrow-right me-1"></i>Keluar</a>
        </div>
    </div>

    <!-- Konten Dinamis -->
    <main>
        <div id="content-area"></div>
    </main>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="modalForm" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="modalTitle">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="modalDataForm"></form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Data awal
    let data = {
        kursus: JSON.parse(localStorage.getItem('kursusList')) || [{
                nama: 'English for Beginner',
                durasi: '2 Bulan',
                tutor: 'James Pratama'
            },
            {
                nama: 'Speaking Class',
                durasi: '1.5 Bulan',
                tutor: 'Sarah Amalia'
            },
            {
                nama: 'Grammar Mastery',
                durasi: '3 Bulan',
                tutor: 'Daniel Putra'
            }
        ],
        peserta: JSON.parse(localStorage.getItem('pesertaList')) || [{
                nama: 'Aulia Rahman',
                kelas: 'English for Beginner'
            },
            {
                nama: 'Budi Santoso',
                kelas: 'Speaking Class'
            }
        ],
        tutor: JSON.parse(localStorage.getItem('tutorList')) || [{
                nama: 'James Pratama',
                pengalaman: '6 Tahun'
            },
            {
                nama: 'Sarah Amalia',
                pengalaman: '4 Tahun'
            }
        ],
        adminName: localStorage.getItem('adminName') || 'Admin Adzkia'
    };

    const content = document.getElementById('content-area');
    const navLinks = document.querySelectorAll('.nav-link');

    // Navigasi antar halaman
    navLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            loadPage(link.dataset.page);
        });
    });

    // Fungsi untuk memuat halaman
    function loadPage(page) {
        if (page === 'dashboard') showDashboard();
        else if (page === 'kursus') showKursus();
        else if (page === 'peserta') showPeserta();
        else if (page === 'tutor') showTutor();
        else if (page === 'pengaturan') showSettings();
    }

    // DASHBOARD
    // DASHBOARD (Tampilan Vertikal)
    function showDashboard() {
        content.innerHTML = `
    <h2 class="fw-bold text-primary mb-4">Dashboard Admin</h2>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-4 text-center">
      <div class="col-md-4">
        <div class="info-card">
          <i class="bi bi-book text-warning fs-2 mb-2"></i>
          <h3><?=count($courses)?></h3>
          <p>Total Kursus</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-card">
          <i class="bi bi-people text-success fs-2 mb-2"></i>
          <h3><?=count($users)?></h3>
          <p>Total Peserta</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-card">
          <i class="bi bi-person-video3 text-primary fs-2 mb-2"></i>
          <h3><?=count(value: $teachers)?></h3>
          <p>Total Tutor</p>
        </div>
      </div>
    </div>

    <!-- Overview Kursus -->
    <div class="card p-4 mb-4 shadow-sm">
      <h5 class="fw-bold text-primary mb-3"><i class="bi bi-book me-2"></i>5 Kursus Terbaru</h5>
      <table class="table table-hover align-middle mb-0">
        <thead class="table-primary">
          <tr><th>#</th><th>Nama Kursus</th><th>Durasi</th></tr>
        </thead>
        <tbody>
          <?php foreach($courses as $i => $course){ ?>
         
            <tr><td><?=$i+1?></td><td><?=$course['title']?></td><td><?=$course['duration']?> Bulan</td></tr>

          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Overview Peserta -->
    <div class="card p-4 mb-4 shadow-sm">
      <h5 class="fw-bold text-success mb-3"><i class="bi bi-people me-2"></i>5 Peserta Terbaru</h5>
      <table class="table table-hover align-middle mb-0">
        <thead class="table-success">
          <tr><th>#</th><th>Nama Peserta</th><th>Email</th></tr>
        </thead>
        <tbody>
         <?php foreach($users as $i => $user){ ?>
         
            <tr><td><?=$i+1?></td><td><?=$user['name']?></td><td><?=$user['email']?></td></tr>

          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Overview Tutor -->
    <div class="card p-4 shadow-sm">
      <h5 class="fw-bold text-info mb-3"><i class="bi bi-person-video3 me-2"></i>5 Tutor Terbaru</h5>
      <table class="table table-hover align-middle mb-0">
        <thead class="table-info">
          <tr><th>#</th><th>Nama Tutor</th><th>Pengalaman</th></tr>
        </thead>
        <tbody>

          <?php foreach($users as $i => $user){ ?>
         
            <tr><td><?=$i+1?></td><td><?=$user['name']?></td><td><?=$user['email']?></td></tr>

          <?php } ?>

          ${data.tutor.slice(-5).map((t, i) => `
            <tr><td>${i + 1}</td><td>${t.nama}</td><td>${t.pengalaman}</td></tr>
          `).join('') || '<tr><td colspan="3" class="text-center text-muted">Belum ada data</td></tr>'}
        </tbody>
      </table>
    </div>
  `;
    }



    // KURSUS CRUD
    function showKursus() {
        content.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold text-primary">Manajemen Kursus</h3>
          <button class="btn btn-custom" onclick="openForm('kursus')"><i class="bi bi-plus-circle me-2"></i>Tambah Kursus</button>
        </div>
        <div class="card p-3">
          <table class="table table-hover align-middle">
            <thead class="table-primary"><tr><th>#</th><th>Nama Kursus</th><th>Durasi</th><th>Tutor</th><th>Aksi</th></tr></thead>
            <tbody>${data.kursus.map((k,i)=>`
              <tr><td>${i+1}</td><td>${k.nama}</td><td>${k.durasi}</td><td>${k.tutor}</td>
              <td><button class='btn btn-warning btn-sm me-1' onclick='editData("kursus",${i})'><i class="bi bi-pencil"></i></button>
              <button class='btn btn-danger btn-sm' onclick='deleteData("kursus",${i})'><i class="bi bi-trash"></i></button></td></tr>`).join('')}
            </tbody>
          </table>
        </div>`;
    }

    // PESERTA CRUD
    function showPeserta() {
        content.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold text-primary">Manajemen Peserta</h3>
          <button class="btn btn-custom" onclick="openForm('peserta')"><i class="bi bi-plus-circle me-2"></i>Tambah Peserta</button>
        </div>
        <div class="card p-3">
          <table class="table table-hover align-middle">
            <thead class="table-primary"><tr><th>#</th><th>Nama Peserta</th><th>Kelas</th><th>Aksi</th></tr></thead>
            <tbody>${data.peserta.map((p,i)=>`
              <tr><td>${i+1}</td><td>${p.nama}</td><td>${p.kelas}</td>
              <td><button class='btn btn-warning btn-sm me-1' onclick='editData("peserta",${i})'><i class="bi bi-pencil"></i></button>
              <button class='btn btn-danger btn-sm' onclick='deleteData("peserta",${i})'><i class="bi bi-trash"></i></button></td></tr>`).join('')}
            </tbody>
          </table>
        </div>`;
    }

    // TUTOR CRUD
    function showTutor() {
        content.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="fw-bold text-primary">Manajemen Tutor</h3>
          <button class="btn btn-custom" onclick="openForm('tutor')"><i class="bi bi-plus-circle me-2"></i>Tambah Tutor</button>
        </div>
        <div class="card p-3">
          <table class="table table-hover align-middle">
            <thead class="table-primary"><tr><th>#</th><th>Nama Tutor</th><th>Pengalaman</th><th>Aksi</th></tr></thead>
            <tbody>${data.tutor.map((t,i)=>`
              <tr><td>${i+1}</td><td>${t.nama}</td><td>${t.pengalaman}</td>
              <td><button class='btn btn-warning btn-sm me-1' onclick='editData("tutor",${i})'><i class="bi bi-pencil"></i></button>
              <button class='btn btn-danger btn-sm' onclick='deleteData("tutor",${i})'><i class="bi bi-trash"></i></button></td></tr>`).join('')}
            </tbody>
          </table>
        </div>`;
    }

    // PENGATURAN
    function showSettings() {
        content.innerHTML = `
        <div class="card p-4" style="max-width:500px;">
          <h3 class="fw-bold text-primary mb-3">⚙️ Pengaturan</h3>
          <label class="form-label">Nama Admin:</label>
          <input type="text" id="adminName" class="form-control mb-3" value="${data.adminName}">
          <button class="btn btn-custom" onclick="saveSettings()">Simpan</button>
        </div>`;
    }

    // Fungsi Form Modal
    function openForm(type, index = null) {
        const modal = new bootstrap.Modal(document.getElementById('modalForm'));
        const form = document.getElementById('modalDataForm');
        document.getElementById('modalTitle').textContent = (index === null ? 'Tambah ' : 'Edit ') + type.charAt(0)
            .toUpperCase() + type.slice(1);

        if (type === 'kursus') {
            form.innerHTML = `
          <label>Nama Kursus</label><input id="nama" class="form-control mb-2" required>
          <label>Durasi</label><input id="durasi" class="form-control mb-2" required>
          <label>Tutor</label><input id="tutor" class="form-control mb-3" required>
          <button type="submit" class="btn btn-custom w-100">Simpan</button>`;
        } else if (type === 'peserta') {
            form.innerHTML = `
          <label>Nama Peserta</label><input id="nama" class="form-control mb-2" required>
          <label>Kelas</label><input id="kelas" class="form-control mb-3" required>
          <button type="submit" class="btn btn-custom w-100">Simpan</button>`;
        } else if (type === 'tutor') {
            form.innerHTML = `
          <label>Nama Tutor</label><input id="nama" class="form-control mb-2" required>
          <label>Pengalaman</label><input id="pengalaman" class="form-control mb-3" required>
          <button type="submit" class="btn btn-custom w-100">Simpan</button>`;
        }

        form.onsubmit = e => {
            e.preventDefault();
            if (type === 'kursus') {
                const item = {
                    nama: nama.value,
                    durasi: durasi.value,
                    tutor: tutor.value
                };
                index === null ? data.kursus.push(item) : data.kursus[index] = item;
                localStorage.setItem('kursusList', JSON.stringify(data.kursus));
                showKursus();
            }
            if (type === 'peserta') {
                const item = {
                    nama: nama.value,
                    kelas: kelas.value
                };
                index === null ? data.peserta.push(item) : data.peserta[index] = item;
                localStorage.setItem('pesertaList', JSON.stringify(data.peserta));
                showPeserta();
            }
            if (type === 'tutor') {
                const item = {
                    nama: nama.value,
                    pengalaman: pengalaman.value
                };
                index === null ? data.tutor.push(item) : data.tutor[index] = item;
                localStorage.setItem('tutorList', JSON.stringify(data.tutor));
                showTutor();
            }
            modal.hide();
        };

        modal.show();
    }

    // Edit dan Hapus Data
    function editData(type, index) {
        openForm(type, index);
    }

    function deleteData(type, index) {
        if (confirm("Yakin ingin menghapus data ini?")) {
            data[type].splice(index, 1);
            localStorage.setItem(type + 'List', JSON.stringify(data[type]));
            loadPage(type);
        }
    }

    // Pengaturan
    function saveSettings() {
        const name = document.getElementById('adminName').value;
        localStorage.setItem('adminName', name);
        data.adminName = name;
        alert('Nama admin disimpan!');
    }

    // Load default
    loadPage('dashboard');
    </script>
</body>

</html>