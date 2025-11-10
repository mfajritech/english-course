-- --------------------------------------------------------
-- Table structure for table `enrollments`
-- --------------------------------------------------------

CREATE TABLE `enrollments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `status` enum('menunggu konfirmasi','aktif','selesai','ditolak') DEFAULT 'menunggu konfirmasi',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Indexes
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

-- Auto increment
ALTER TABLE `enrollments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- Foreign keys (optional, bisa diaktifkan nanti)
-- ALTER TABLE `enrollments`
--   ADD CONSTRAINT fk_enroll_user FOREIGN KEY (user_id) REFERENCES users(id),
--   ADD CONSTRAINT fk_enroll_course FOREIGN KEY (course_id) REFERENCES courses(id);
