-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2020 at 02:32 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytesting`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_golongan`
--

CREATE TABLE `tb_golongan` (
  `id_golongan` int(11) NOT NULL,
  `n_golongan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_golongan`
--

INSERT INTO `tb_golongan` (`id_golongan`, `n_golongan`) VALUES
(1, 'Golongan III');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `n_jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`id_jabatan`, `n_jabatan`) VALUES
(1, 'BUPATI'),
(3, 'WAKIL BUPATI'),
(4, 'SEKRETARIS DAERAH'),
(5, 'STAF AHLI'),
(6, 'ASISTEN DAERAH'),
(7, 'SEKRETARIS DINAS/BADAN'),
(8, 'KETUA DPRD KABUPATEN TAPANULI SELATAN'),
(9, 'STAF'),
(10, 'KEPALA SUBBIDANG/SUBBAGIAN/SEKSI'),
(11, 'KEPALA DINAS/BADAN'),
(12, 'KEPALA BIDANG/BAGIAN');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nip` bigint(50) NOT NULL,
  `pegawai_skpd` int(11) DEFAULT NULL,
  `pegawai_unitkerja` int(11) NOT NULL,
  `pegawai_jabatan` int(11) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `foto` text NOT NULL,
  `create_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`id_pegawai`, `nip`, `pegawai_skpd`, `pegawai_unitkerja`, `pegawai_jabatan`, `nama`, `pangkat`, `no_hp`, `foto`, `create_on`) VALUES
(1, 12345, 1, 5, 9, 'Arie Dalimunthe', 'Golongan III', '081260721476', '', '2020-04-28 09:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

CREATE TABLE `tb_role` (
  `id_role` int(11) NOT NULL,
  `role_pegawai` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_skpd`
--

CREATE TABLE `tb_skpd` (
  `id_skpd` int(11) NOT NULL,
  `n_skpd` varchar(100) NOT NULL,
  `inisial_skpd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_skpd`
--

INSERT INTO `tb_skpd` (`id_skpd`, `n_skpd`, `inisial_skpd`) VALUES
(1, 'SEKRETARIAT DAERAH', 'SEKRETARIAT DAERAH'),
(2, 'DINAS SOSIAL', 'DINSOS'),
(3, 'DINAS PERIKANAN', 'DINAS PERIKANAN');

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit_kerja`
--

CREATE TABLE `tb_unit_kerja` (
  `id_unitkerja` int(11) NOT NULL,
  `unitkerja_skpd` int(11) NOT NULL,
  `n_unitkerja` varchar(100) NOT NULL,
  `initial_unitkerja` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_unit_kerja`
--

INSERT INTO `tb_unit_kerja` (`id_unitkerja`, `unitkerja_skpd`, `n_unitkerja`, `initial_unitkerja`) VALUES
(1, 1, 'UMUM SEKRETARIAT DAERAH', ''),
(4, 1, 'KABAG HUKUM', ''),
(5, 1, 'KABAG PEMBANGUNAN', ''),
(6, 1, 'KABAG UMUM DAN PERLENGKAPAN', ''),
(7, 1, 'KABAG PEREKONOMIAN DAN SDA', ''),
(8, 1, 'KABAG UNIT LAYANAN PENGADAAN', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `pegawai_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `pegawai_user`, `username`, `password`, `role_id`, `is_active`) VALUES
(1, 1, 'admin', '$2y$10$rzbtCJ0uKICj.GWtG8wtyOmNp/SpjYfNFL9af6Foc17', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_access_menu`
--

CREATE TABLE `tb_user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_access_menu`
--

INSERT INTO `tb_user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 1, 3),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_menu`
--

CREATE TABLE `tb_user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `isParent` enum('0','1') NOT NULL,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_menu`
--

INSERT INTO `tb_user_menu` (`id`, `menu`, `url`, `icon`, `isParent`, `parent`) VALUES
(1, 'Users', '', '', '0', NULL),
(2, 'Dashboard', '', 'fa fa-edit', '0', NULL),
(3, 'DATA MASTER', '#', 'fa fa-home', '0', NULL),
(4, 'MASTER PEGAWAI', 'pegawai', '', '0', NULL),
(5, 'REKAPITULASI SURAT', '#', '', '0', NULL),
(6, 'Test', '#', 'fa fa-edit', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_role`
--

CREATE TABLE `tb_user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_role`
--

INSERT INTO `tb_user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_sub_menu`
--

CREATE TABLE `tb_user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_sub_menu`
--

INSERT INTO `tb_user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 3, 'Jabatan', 'jabatan', 'fa fa-user', 1),
(2, 3, 'Golongan', 'golongan', 'fa fa-user', 1),
(3, 3, 'SKPD', 'skpd', 'fa fa-book', 1),
(4, 3, 'Unit Kerja', 'unit_kerja', 'fa fa-book', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_golongan`
--
ALTER TABLE `tb_golongan`
  ADD PRIMARY KEY (`id_golongan`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `tb_skpd`
--
ALTER TABLE `tb_skpd`
  ADD PRIMARY KEY (`id_skpd`);

--
-- Indexes for table `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  ADD PRIMARY KEY (`id_unitkerja`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tb_user_access_menu`
--
ALTER TABLE `tb_user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_role`
--
ALTER TABLE `tb_user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_golongan`
--
ALTER TABLE `tb_golongan`
  MODIFY `id_golongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_role`
--
ALTER TABLE `tb_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_skpd`
--
ALTER TABLE `tb_skpd`
  MODIFY `id_skpd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_unit_kerja`
--
ALTER TABLE `tb_unit_kerja`
  MODIFY `id_unitkerja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_user_access_menu`
--
ALTER TABLE `tb_user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_user_menu`
--
ALTER TABLE `tb_user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_user_role`
--
ALTER TABLE `tb_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user_sub_menu`
--
ALTER TABLE `tb_user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
