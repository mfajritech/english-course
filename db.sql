-- --------------------------------------------------------
-- Table structure for table `teachers`
-- --------------------------------------------------------

CREATE TABLE `teachers` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `education` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
-- Dumping data for table `teachers`
-- --------------------------------------------------------

INSERT INTO `teachers` (`id`, `name`, `title`, `experience`, `education`) VALUES
(1, 'James Pratama', 'English Language Instructor', '6+ Tahun Mengajar', 'Lulusan Universitas Melbourne'),
(2, 'Sarah Wijaya', 'TOEFL & IELTS Specialist', '8 Tahun Mengajar', 'Lulusan Universitas Indonesia'),
(3, 'Michael Santoso', 'Academic Writing Coach', '5 Tahun Mengajar', 'Lulusan Universitas Gadjah Mada'),
(4, 'Lina Rahmah', 'Conversational English Tutor', '7 Tahun Mengajar', 'Lulusan Universitas Negeri Malang');

-- --------------------------------------------------------
-- Indexes for table `teachers`
-- --------------------------------------------------------

ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------
-- AUTO_INCREMENT for table `teachers`
-- --------------------------------------------------------

ALTER TABLE `teachers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
