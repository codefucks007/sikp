-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 04:24 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bidang`
--

CREATE TABLE `bidang` (
  `id` int(11) NOT NULL,
  `nama_bidang` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bidang`
--

INSERT INTO `bidang` (`id`, `nama_bidang`) VALUES
(1, 'Teknologi'),
(2, 'Bisnis'),
(3, 'Kreatif'),
(4, 'Keagamaan'),
(5, 'PKKMB'),
(9, 'Seni'),
(10, 'Kreatif 2');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `jabatan`) VALUES
(1, 'PK2M'),
(2, 'Biro Administrasi Kemahasiswaan');

-- --------------------------------------------------------

--
-- Table structure for table `jeniskegiatan`
--

CREATE TABLE `jeniskegiatan` (
  `id` int(11) NOT NULL,
  `jeniskegiatan` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jeniskegiatan`
--

INSERT INTO `jeniskegiatan` (`id`, `jeniskegiatan`) VALUES
(1, 'Seminar'),
(2, 'Workshop'),
(3, 'Pelatihan'),
(9, 'Studi Independen');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jeniskegiatan` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_sifat` int(11) NOT NULL,
  `nama_kegiatan` varchar(256) NOT NULL,
  `waktu_pelaksanaan` date NOT NULL,
  `id_partisipasi` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `bobot` int(11) NOT NULL,
  `filebukti` varchar(128) NOT NULL,
  `id_status` int(11) NOT NULL,
  `catatan` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `id_user`, `id_jeniskegiatan`, `id_bidang`, `id_sifat`, `nama_kegiatan`, `waktu_pelaksanaan`, `id_partisipasi`, `id_level`, `bobot`, `filebukti`, `id_status`, `catatan`) VALUES
(8, 27, 3, 5, 1, 'Harddisk', '2023-09-02', 2, 1, 3, 'aa17.pdf', 2, 'Mantap'),
(10, 28, 3, 4, 1, 'Mentoring', '2023-09-16', 2, 1, 3, 'aa19.pdf', 1, ''),
(11, 27, 3, 4, 1, 'Bible Camp', '2023-09-22', 2, 1, 3, 'aa20.pdf', 1, ''),
(12, 28, 3, 4, 1, 'Bible Camp', '2023-09-22', 1, 1, 5, 'aa21.pdf', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatantambah`
--

CREATE TABLE `kegiatantambah` (
  `id` int(11) NOT NULL,
  `id_sifat` int(11) NOT NULL,
  `id_jeniskegiatan` int(11) NOT NULL,
  `id_bidang` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `nama_kegiatantambah` varchar(256) NOT NULL,
  `waktu` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatantambah`
--

INSERT INTO `kegiatantambah` (`id`, `id_sifat`, `id_jeniskegiatan`, `id_bidang`, `id_level`, `nama_kegiatantambah`, `waktu`) VALUES
(1, 1, 3, 5, 1, 'Harddisk', '2023-09-02'),
(2, 1, 3, 4, 1, 'Mentoring', '2023-09-16'),
(4, 1, 3, 4, 1, 'Bible Camp', '2023-09-22'),
(13, 2, 1, 2, 3, 'Seminar Hidup Sehat', '2024-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `level` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level`) VALUES
(1, 'Lokal'),
(2, 'Regional'),
(3, 'Nasional'),
(4, 'Internasional');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(5, 27, 'Kegiatan Anda \"Harddisk\" telah divalidasi.', 1, '2024-08-05 20:44:00'),
(6, 27, 'Kegiatan Anda \"Harddisk\" tidak valid.', 1, '2024-08-05 20:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `partisipasi`
--

CREATE TABLE `partisipasi` (
  `id` int(11) NOT NULL,
  `partisipasi` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partisipasi`
--

INSERT INTO `partisipasi` (`id`, `partisipasi`) VALUES
(1, 'Panitia'),
(2, 'Peserta');

-- --------------------------------------------------------

--
-- Table structure for table `program_studi`
--

CREATE TABLE `program_studi` (
  `id` int(11) NOT NULL,
  `program_studi` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_studi`
--

INSERT INTO `program_studi` (`id`, `program_studi`) VALUES
(1, 'Teknik Informatika'),
(2, 'Sistem Informasi'),
(3, 'Desain Komunikasi Visual'),
(4, 'Manajemen Informatika');

-- --------------------------------------------------------

--
-- Table structure for table `sifat`
--

CREATE TABLE `sifat` (
  `id` int(11) NOT NULL,
  `sifat` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sifat`
--

INSERT INTO `sifat` (`id`, `sifat`) VALUES
(1, 'Wajib'),
(2, 'Pilihan');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Belum Diperiksa'),
(2, 'Valid'),
(3, 'Tidak Valid');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nrp` varchar(15) NOT NULL,
  `nip` varchar(256) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `no_telepon` varchar(128) NOT NULL,
  `id_program_studi` int(11) DEFAULT NULL,
  `angkatan` varchar(128) NOT NULL,
  `bobot` int(11) NOT NULL,
  `total_poin` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL,
  `is_profile_complete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nrp`, `nip`, `name`, `email`, `no_telepon`, `id_program_studi`, `angkatan`, `bobot`, `total_poin`, `image`, `password`, `role_id`, `is_active`, `date_created`, `is_profile_complete`) VALUES
(12, '99999999', '8888888', 'Rudolph', 'anakmanusia245@gmail.com', '0000000001', 3, '9999', 300, 0, 'default.jpg', '$2y$10$EPBOjtboKHd2SI04JlBODe7CObVtKID1SJUMl5zqfRF.TKKCG8kMi', 1, 1, 1718184972, 1),
(13, '', '595959595', 'Maman Abdurahman', 'dospem@gmail.com', '0000000001', 0, '', 0, 0, 'default.jpg', '$2y$10$Akv896GsxqfiTkrlazsqqO8Iw.HxmEXdJ8sHv7.gm6DsDku86oTxa', 4, 1, 1718206964, 1),
(14, '', '123456', 'Mulyadi', 'bam@gmail.com', '08994989898', 0, '', 0, 0, 'PAS_FOTO.jpg', '$2y$10$3ZMqqSYsZlrZYX60rLmVV.YpQfp1HN6r63pyEEkIknNLlXog.Eq6O', 3, 1, 1718208044, 1),
(22, '99999999', '123456', 'mamat', 'pk2m@gmail.com', '08994989549', 2, '2023', 300, 0, 'default.jpg', '$2y$10$G6GJlbzELQaNwwS7O5pmsOg6ez/FXY2YCRv.ynEiRyiEQqnCMlLDO', 5, 1, 1722198807, 1),
(27, '211221011', '', 'Rudolph Benjamin', '211221011@gmail.com', '08994989549', 4, '2023', 300, 12, 'PAS_FOTO3.jpg', '$2y$10$mItC2IawZDSQguLrow1SS.okxP6MoHGpfPvDW/tgZK3UgBYxJZuh2', 2, 1, 1722908398, 1),
(28, '99999999', '', 'Maman Abdurahman', 'maman@gmail.com', '0000000001', 1, '2022', 300, 0, 'default.jpg', '$2y$10$rDQGr8/gEAy6kMfNT81tuO4dCAg1gJieTkW6Xz.OxP/aSa8EXKDiu', 2, 1, 1722909777, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(7, 1, 3),
(10, 1, 2),
(14, 6, 2),
(15, 6, 5),
(18, 1, 6),
(19, 1, 7),
(22, 1, 8),
(26, 3, 8),
(29, 1, 4),
(30, 2, 4),
(31, 3, 5),
(32, 1, 9),
(34, 1, 5),
(35, 3, 10),
(36, 1, 10),
(39, 4, 5),
(40, 3, 6),
(42, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Data Kegiatan'),
(5, 'Petugas'),
(6, 'Tambah Data');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Mahasiswa'),
(3, 'Biro Administrasi Kemahasiswaan'),
(4, 'Dosen Pembimbing'),
(5, 'PK2M');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard Admin', 'admin', 'fas fa-fw fa-tachometer-alt', 0),
(2, 2, 'Beranda', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(7, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(8, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(10, 4, 'Daftar Kegiatan', 'data_kegiatan', 'fas fa-fw fa-clipboard-list', 1),
(17, 8, 'Data Kegiatan Mahasiswa', 'coba/cobaa', 'fab fa-fw fa-facebook', 1),
(18, 8, 'Jenis Kegiatan', 'coba/cobaa', 'fab fa-fw fa-facebook', 1),
(19, 8, 'Bidang', 'coba/cobaa', 'fab fa-fw fa-facebook', 1),
(24, 9, 'Beranda', 'coba/cobaa', 'fab fa-fw fa-facebook', 1),
(26, 5, 'Dashboard', 'petugas', 'fas fa-fw fa-tachometer-alt', 1),
(27, 5, 'Daftar Kegiatan Mahasiswa', 'petugas/daftarkegiatanmhs', 'fas fa-fw fa-clipboard-check', 1),
(28, 10, 'Isi Jenis Kegiatan', 'petugas/jeniskegiatan', 'fas fa-fw fa-plus', 1),
(29, 10, 'Isi Bidang', 'petugas/bidang', 'fas fa-fw fa-plus', 1),
(30, 10, 'Isi Kegiatan', 'petugas/kegiatantambah', 'fas fa-fw fa-plus', 1),
(31, 6, 'Isi Kegiatan', 'petugas/kegiatantambah', 'fas fa-fw fa-plus', 1),
(32, 6, 'Isi Jenis Kegiatan', 'petugas/jeniskegiatan', 'fas fa-fw fa-plus', 1),
(33, 6, 'Isi Bidang', 'petugas/bidang', 'fas fa-fw fa-plus', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jeniskegiatan`
--
ALTER TABLE `jeniskegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `kegiatantambah`
--
ALTER TABLE `kegiatantambah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partisipasi`
--
ALTER TABLE `partisipasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_studi`
--
ALTER TABLE `program_studi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sifat`
--
ALTER TABLE `sifat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jeniskegiatan`
--
ALTER TABLE `jeniskegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kegiatantambah`
--
ALTER TABLE `kegiatantambah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `partisipasi`
--
ALTER TABLE `partisipasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `program_studi`
--
ALTER TABLE `program_studi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sifat`
--
ALTER TABLE `sifat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
