-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2025 at 11:10 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adzkia_english_course`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `slogan` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `duration` int NOT NULL,
  `capacity` int NOT NULL,
  `mode` varchar(30) NOT NULL,
  `schedule` varchar(50) NOT NULL,
  `teacher_id` int NOT NULL,
  `lesson` text NOT NULL,
  `price` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `slogan`, `description`, `duration`, `capacity`, `mode`, `schedule`, `teacher_id`, `lesson`, `price`) VALUES
(1, 'English for Beginner', 'Langkah awal untuk berbicara bahasa Inggris dengan percaya diri dan menyenangkan.', 'Kelas “English for Beginner” Kelas percakapan ini dirancang untuk kamu yang sudah memahami dasar Bahasa Inggris dan ingin berbicara dengan lancar serta percaya diri. Fokus pada praktik berbicara, listening, dan ekspresi alami yang digunakan oleh native speaker.', 2, 25, 'Online via Zoom', 'Selasa & Kamis', 1, 'Meningkatkan kelancaran berbicara (fluency) dan pelafalan (pronunciation), Struktur kalimat sederhana (Simple Present Tense), Latihan mendengarkan percakapan dasar, Praktek berbicara tentang diri sendiri dan aktivitas harian, Kuis interaktif di setiap akhir sesi', '599.000'),
(2, 'Intermediate Conversation', 'Tingkatkan kemampuan berbicara alami dengan ekspresi sehari-hari.', 'Kelas ini dirancang untuk kamu yang sudah memiliki dasar percakapan dan ingin memperluas kosa kata serta kefasihan berbicara. Materi berfokus pada topik kehidupan nyata dan percakapan spontan.', 3, 20, 'Offline di Kelas', 'Senin & Rabu', 2, 'Percakapan tentang pekerjaan dan studi, Ekspresi idiomatik, Diskusi kelompok, Latihan mendengarkan audio native speaker, Roleplay interaktif', '600.000'),
(3, 'TOEFL Preparation', 'Persiapan intensif menghadapi ujian TOEFL dengan strategi efektif.', 'Kelas persiapan TOEFL ini membantu peserta memahami format ujian, memperkuat grammar, listening, reading, dan writing sesuai standar TOEFL.', 4, 30, 'Online via Zoom', 'Selasa, Kamis & Sabtu', 3, 'Latihan Reading Comprehension, Structure and Written Expression, Listening Practice, Simulasi ujian TOEFL setiap minggu, Pembahasan strategi menjawab soal', '1.200.000'),
(4, 'English for Kids', 'Belajar Bahasa Inggris sambil bermain dan bernyanyi!', 'Kelas ini khusus untuk anak-anak usia 7–12 tahun dengan pendekatan interaktif, menyenangkan, dan penuh aktivitas kreatif.', 2, 15, 'Offline di Lembaga', 'Sabtu & Minggu', 4, 'Mengenal kosakata dasar, Lagu-lagu bahasa Inggris, Cerita interaktif, Permainan edukatif, Aktivitas menggambar dan bercerita sederhana', '786.000');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `education` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `title`, `experience`, `education`) VALUES
(1, 'James Pratama', 'English Language Instructor', '6+ Tahun Mengajar', 'Lulusan Universitas Melbourne'),
(2, 'Sarah Wijaya', 'TOEFL & IELTS Specialist', '8 Tahun Mengajar', 'Lulusan Universitas Indonesia'),
(3, 'Michael Santoso', 'Academic Writing Coach', '5 Tahun Mengajar', 'Lulusan Universitas Gadjah Mada'),
(4, 'Lina Rahmah', 'Conversational English Tutor', '7 Tahun Mengajar', 'Lulusan Universitas Negeri Malang');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(30) NOT NULL,
  `birth` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `phone`, `password`, `name`, `birth`, `address`, `role`) VALUES
(1, 'fajriaja110505@gmail.com', '082268993085', '$2y$10$AOMdApS/8xeysCvsFqRosuCdmp4oYaiQhsaXCoE5wg65Qp95YUNVi', 'Muhammad Fajri', '2025-11-10', 'Jorong Alamanda Raya, Nagari Bunuik, Kec. Kinali, Kab. Pasaman Barat, Sumatera Barat', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
