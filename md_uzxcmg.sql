-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2026 at 10:08 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `md_uzxcmg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(500) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `phone`, `role_id`, `status`, `created`, `updated`) VALUES
(1, 'Adminbek', 'admin', '$2y$13$u0QV0cVlVIya1TbQ9ncHS.8lnq4ApCBuMqDPQiQB6BXWCVOF0D5xO', '+998901234567', 1, 1, '2026-02-10 22:16:25', '2026-02-14 19:39:08'),
(2, 'Adminbek', 'adminbek', '$2y$13$2spzrrmqDIuUsVzSTR.YZeN5tfkwkX3rIL5HoOxlgvobPjMDyrgse', '+998901234567', 1, 1, '2026-02-12 18:49:01', '2026-02-12 18:49:01'),
(3, 'Adminbek', 'adminjon', '$2y$13$4RTT0.gdmOzSYogXIRurbOp7ez.yo7SYPl6sOX3GRY/FQpVWfin3K', '+998901234567', 1, 0, '2026-03-09 12:43:24', '2026-03-09 12:44:01');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`id`, `name`, `status`, `created`, `updated`) VALUES
(1, 'admin', 1, '2026-02-10 22:12:15', '2026-02-17 16:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `navigation_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `detail` longtext DEFAULT NULL,
  `show_counter` int(11) DEFAULT 0,
  `publish_date` datetime DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `language_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `slug`, `name`, `navigation_id`, `description`, `detail`, `show_counter`, `publish_date`, `status`, `created`, `updated`, `language_id`, `image_id`) VALUES
(1, 'maqola-nomi-222', 'Maqola nomi 222', 1, 'Qisqacha tavsif o\'zbek tilida', '<p>Batafsil ma\'lumot o\'zbek tilida</p>', 0, '2026-03-02 10:00:00', 0, '2026-03-02 22:45:40', '2026-03-09 12:49:14', 1, NULL),
(2, 'maqola-nomi', 'Maqola nomi', 1, 'Qisqacha tavsif o\'zbek tilida', '<p>Batafsil ma\'lumot o\'zbek tilida</p>', 0, '2026-03-02 10:00:00', 1, '2026-03-08 00:06:19', '2026-03-08 00:06:19', NULL, NULL),
(3, 'maqola-nomi-2', 'Maqola nomi', 1, 'Qisqacha tavsif o\'zbek tilida', '<p>Batafsil ma\'lumot o\'zbek tilida</p>', 0, '2026-03-02 10:00:00', 1, '2026-03-08 00:07:44', '2026-03-08 00:07:44', 1, NULL),
(4, 'maqola-nomi-3', 'Maqola nomi', 1, 'Qisqacha tavsif o\'zbek tilida', '<p>Batafsil ma\'lumot o\'zbek tilida</p>', 0, '2026-03-02 10:00:00', 1, '2026-03-09 12:48:31', '2026-03-09 12:48:31', 1, NULL),
(5, 'maqola-nomi-4', 'Maqola nomi', 1, 'Qisqacha tavsif o\'zbek tilida', '<p>dfhfgh</p>', 0, '2026-03-02 10:00:00', 1, '2026-03-09 16:14:37', '2026-03-13 22:58:43', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `button` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`button`)),
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `spec_template` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`spec_template`)),
  `sort_order` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `language_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `parent_id`, `name`, `slug`, `icon`, `image_id`, `spec_template`, `sort_order`, `status`, `created`, `updated`, `language_id`) VALUES
(1, NULL, 'Test', 'test', 'icon', 5, NULL, 1, 1, '2026-02-14 00:11:44', '2026-03-07 23:47:56', 1),
(2, NULL, 'testnasmeasa', 'testnasmeasa', '', 1, '\"{\\\"a\\\":\\\"b\\\"}\"', 1, 0, '2026-02-14 00:12:14', '2026-03-09 12:47:24', 2),
(3, NULL, 'testnasme', NULL, '', 1, '\"{\\\"a\\\":\\\"b\\\"}\"', 1, 1, '2026-02-14 20:58:56', '2026-03-07 23:47:58', 1),
(4, NULL, 'testnasme', 'testnasme', 'icon', 2, '\"{\\\"a\\\":\\\"b\\\"}\"', 1, 1, '2026-02-15 22:14:20', '2026-03-07 23:47:59', 1),
(5, NULL, 'Protsessor111', 'protsessor111', 'Icon Name', 15, '\"{\\\"fields\\\":[{\\\"key\\\":\\\"key\\\",\\\"label_uz\\\":\\\"Yadro\\\",\\\"label_ru\\\":\\\"Yadro\\\",\\\"type\\\":\\\"number\\\"}]}\"', 1, 1, '2026-02-17 11:54:02', '2026-03-07 23:47:28', 1),
(6, 1, 'Extiyot Qismlar', 'extiyot-qismlar', 'icon', 16, '\"{\\\"fields\\\":[]}\"', 1, 1, '2026-02-17 11:54:47', '2026-03-07 23:47:31', 1),
(7, 1, 'Extiyot Qismlar', 'extiyot-qismlar-2', 'icon', 16, '\"{\\\"fields\\\":[]}\"', 0, 1, '2026-02-17 11:54:55', '2026-03-07 23:47:32', 1),
(8, NULL, 'new', 'new', 'new', 17, '\"{\\\"fields\\\":[]}\"', 0, 1, '2026-02-17 12:56:22', '2026-03-07 23:47:33', 1),
(9, 5, 'new', 'new-2', 'new', NULL, '\"{\\\"fields\\\":[]}\"', 0, 1, '2026-02-17 13:12:13', '2026-03-07 23:47:34', 1),
(10, NULL, 'testnasme', 'testnasme-2', 'icon', 3, '\"{\\\"a\\\":\\\"b\\\"}\"', 1, 1, '2026-03-07 23:43:15', '2026-03-07 23:47:02', 1),
(11, NULL, 'testnasme', 'testnasme-3', 'icon', 3, '\"{\\\"a\\\":\\\"b\\\"}\"', 1, 1, '2026-03-07 23:45:10', '2026-03-07 23:45:10', 1),
(12, NULL, 'testnasme', 'testnasme-4', 'icon', 3, '\"{\\\"a\\\":\\\"b\\\"}\"', 1, 1, '2026-03-09 12:46:46', '2026-03-09 12:46:46', 1),
(13, NULL, 'Ruskiy Categories', 'ruskiy-categories', NULL, NULL, '\"{\\\"fields\\\":[]}\"', 1, 1, '2026-03-12 21:46:28', '2026-03-12 21:46:28', 2);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `exts` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `slug`, `exts`, `url`, `status`, `created`, `updated`) VALUES
(1, 'ilovepdf_pages-to-jpg (7)', '1a', 'zip', '{\"original\":\"/upload/files/1771070188_jKOCE-qN.zip\"}', 1, '2026-02-14 16:56:28', '2026-02-14 16:56:28'),
(2, 'Insomnia.Core-12.0.0', '2a', 'exe', '{\"original\":\"/upload/files/1771070536_z3hE11vS.exe\"}', 1, '2026-02-14 17:02:22', '2026-02-14 17:02:22'),
(3, 'test-file', 'test-file', 'png', '{\"original\":\"/upload/files/1771234416_Yk2SywnN.png\",\"small\":\"/upload/files/1771234416_Yk2SywnN_small.png\",\"medium\":\"/upload/files/1771234416_Yk2SywnN_medium.png\"}', 1, '2026-02-16 14:33:37', '2026-02-16 14:33:37'),
(4, 'test-file', 'test-file-2', 'png', '{\"original\":\"/upload/files/1771234519_96CqNkZE.png\",\"small\":\"/upload/files/1771234519_96CqNkZE_small.png\",\"medium\":\"/upload/files/1771234519_96CqNkZE_medium.png\"}', 1, '2026-02-16 14:35:19', '2026-02-16 14:35:19'),
(5, 'test-file', 'test-file-3', 'png', '{\"original\":\"/upload/files/1771247300_PnEiRvJH.png\",\"small\":\"/upload/files/1771247300_PnEiRvJH_small.png\",\"medium\":\"/upload/files/1771247300_PnEiRvJH_medium.png\"}', 1, '2026-02-16 18:08:20', '2026-02-16 18:08:20'),
(6, 'test-file', 'test-file-4', 'png', '{\"original\":\"/upload/files/1771307724_7kdzm7OM.png\",\"small\":\"/upload/files/1771307724_7kdzm7OM_small.png\",\"medium\":\"/upload/files/1771307724_7kdzm7OM_medium.png\"}', 1, '2026-02-17 10:55:25', '2026-02-17 10:55:25'),
(7, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743', 'png', '{\"original\":\"/upload/files/1771308537_ZuBums92.png\",\"small\":\"/upload/files/1771308537_ZuBums92_small.png\",\"medium\":\"/upload/files/1771308537_ZuBums92_medium.png\"}', 1, '2026-02-17 11:08:58', '2026-02-17 11:08:58'),
(8, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743-2', 'png', '{\"original\":\"/upload/files/1771308970_6dtoU8a5.png\",\"small\":\"/upload/files/1771308970_6dtoU8a5_small.png\",\"medium\":\"/upload/files/1771308970_6dtoU8a5_medium.png\"}', 1, '2026-02-17 11:16:11', '2026-02-17 11:16:11'),
(9, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743-3', 'png', '{\"original\":\"/upload/files/1771309111_GT0WaYT9.png\",\"small\":\"/upload/files/1771309111_GT0WaYT9_small.png\",\"medium\":\"/upload/files/1771309111_GT0WaYT9_medium.png\"}', 1, '2026-02-17 11:18:32', '2026-02-17 11:18:32'),
(10, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743-4', 'png', '{\"original\":\"/upload/files/1771309983_wlHGN9RI.png\",\"small\":\"/upload/files/1771309983_wlHGN9RI_small.png\",\"medium\":\"/upload/files/1771309983_wlHGN9RI_medium.png\"}', 1, '2026-02-17 11:33:04', '2026-02-17 11:33:04'),
(11, 'ChatGPT Image 21 окт. 2025 г., 15_45_33', 'chatgpt-image-21-2025-154533', 'png', '{\"original\":\"/upload/files/1771309993_koF7A18O.png\",\"small\":\"/upload/files/1771309993_koF7A18O_small.png\",\"medium\":\"/upload/files/1771309993_koF7A18O_medium.png\"}', 1, '2026-02-17 11:33:14', '2026-02-17 11:33:14'),
(12, 'ChatGPT Image 21 окт. 2025 г., 15_45_33', 'chatgpt-image-21-2025-154533-2', 'png', '{\"original\":\"/upload/files/1771310205_9Cn6Uf8i.png\",\"small\":\"/upload/files/1771310205_9Cn6Uf8i_small.png\",\"medium\":\"/upload/files/1771310205_9Cn6Uf8i_medium.png\"}', 1, '2026-02-17 11:36:45', '2026-02-17 11:36:45'),
(13, 'Dentify_Texnik_Kontseptsiya', 'dentifytexnikkontseptsiya', 'pdf', '{\"original\":\"/upload/files/1771310254_mIpL4WA5.pdf\"}', 1, '2026-02-17 11:37:34', '2026-02-17 11:37:34'),
(14, 'departments', 'departments', 'pdf', '{\"original\":\"/upload/files/1771310419_8sRRSRv0.pdf\"}', 1, '2026-02-17 11:40:19', '2026-02-17 11:40:19'),
(15, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743-5', 'png', '{\"original\":\"/upload/files/1771311239_JOEgtlZg.png\",\"small\":\"/upload/files/1771311239_JOEgtlZg_small.png\",\"medium\":\"/upload/files/1771311239_JOEgtlZg_medium.png\"}', 1, '2026-02-17 11:54:00', '2026-02-17 11:54:00'),
(16, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743-6', 'png', '{\"original\":\"/upload/files/1771311285_qD_cB_uk.png\",\"small\":\"/upload/files/1771311285_qD_cB_uk_small.png\",\"medium\":\"/upload/files/1771311285_qD_cB_uk_medium.png\"}', 1, '2026-02-17 11:54:46', '2026-02-17 11:54:46'),
(17, 'ChatGPT Image 21 окт. 2025 г., 15_37_43', 'chatgpt-image-21-2025-153743-7', 'png', '{\"original\":\"/upload/files/1771314972_TE8qPqy9.png\",\"small\":\"/upload/files/1771314972_TE8qPqy9_small.png\",\"medium\":\"/upload/files/1771314972_TE8qPqy9_medium.png\"}', 1, '2026-02-17 12:56:13', '2026-02-17 12:56:13'),
(18, 'ghost-modern-2560x1440-10953', 'ghost-modern-2560x1440-10953', 'jpg', '{\"original\":\"/upload/files/1771326296_WaJFArPf.jpg\",\"small\":\"/upload/files/1771326296_WaJFArPf_small.jpg\",\"medium\":\"/upload/files/1771326296_WaJFArPf_medium.jpg\"}', 1, '2026-02-17 16:04:56', '2026-02-17 16:04:56'),
(19, 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'jpg', '{\"original\":\"/upload/files/1771326314_ElY32Uu7.jpg\",\"small\":\"/upload/files/1771326314_ElY32Uu7_small.jpg\",\"medium\":\"/upload/files/1771326314_ElY32Uu7_medium.jpg\"}', 1, '2026-02-17 16:05:14', '2026-02-17 16:05:14'),
(20, 'ChatGPT Image 21 окт. 2025 г., 18_31_43', 'chatgpt-image-21-2025-183143', 'png', '{\"original\":\"/upload/files/1773415941_zZ_APoxx.png\",\"small\":\"/upload/files/1773415941_zZ_APoxx_small.png\",\"medium\":\"/upload/files/1773415941_zZ_APoxx_medium.png\"}', 1, '2026-03-13 20:32:22', '2026-03-13 20:32:22'),
(21, 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058-2', 'jpg', '{\"original\":\"/upload/files/1773416247_6tqmu6oZ.jpg\",\"small\":\"/upload/files/1773416247_6tqmu6oZ_small.jpg\",\"medium\":\"/upload/files/1773416247_6tqmu6oZ_medium.jpg\"}', 1, '2026-03-13 20:37:28', '2026-03-13 20:37:28'),
(22, 'ghost-modern-2560x1440-10953', 'ghost-modern-2560x1440-10953-2', 'jpg', '{\"original\":\"/upload/files/1773416454_VniMc2rR.jpg\",\"small\":\"/upload/files/1773416454_VniMc2rR_small.jpg\",\"medium\":\"/upload/files/1773416454_VniMc2rR_medium.jpg\"}', 1, '2026-03-13 20:40:54', '2026-03-13 20:40:54'),
(23, 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058-3', 'jpg', '{\"original\":\"/upload/files/1773416551_KUCursOx.jpg\",\"small\":\"/upload/files/1773416551_KUCursOx_small.jpg\",\"medium\":\"/upload/files/1773416551_KUCursOx_medium.jpg\"}', 1, '2026-03-13 20:42:31', '2026-03-13 20:42:31'),
(24, 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058-4', 'jpg', '{\"original\":\"/upload/files/1773416668_KZSnyROn.jpg\",\"small\":\"/upload/files/1773416668_KZSnyROn_small.jpg\",\"medium\":\"/upload/files/1773416668_KZSnyROn_medium.jpg\"}', 1, '2026-03-13 20:44:28', '2026-03-13 20:44:28'),
(25, 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058-5', 'jpg', '{\"original\":\"/upload/files/1773417623_sHxtultw.jpg\",\"small\":\"/upload/files/1773417623_sHxtultw_small.jpg\",\"medium\":\"/upload/files/1773417623_sHxtultw_medium.jpg\"}', 1, '2026-03-13 21:00:23', '2026-03-13 21:00:23'),
(26, 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058', 'windows-11-stock-red-abstract-black-background-amoled-2560x1440-9058-6', 'jpg', '{\"original\":\"/upload/files/1773417879_0EMQfTar.jpg\",\"small\":\"/upload/files/1773417879_0EMQfTar_small.jpg\",\"medium\":\"/upload/files/1773417879_0EMQfTar_medium.jpg\"}', 1, '2026-03-13 21:04:39', '2026-03-13 21:04:39'),
(27, 'Screenshot_2026-03-13_19-56-10', 'screenshot2026-03-1319-56-10', 'jpg', '{\"original\":\"/upload/files/1773420436_7HL0zAu8.jpg\",\"small\":\"/upload/files/1773420436_7HL0zAu8_small.jpg\",\"medium\":\"/upload/files/1773420436_7HL0zAu8_medium.jpg\"}', 1, '2026-03-13 21:47:16', '2026-03-13 21:47:16'),
(28, 'Screenshot_2026-03-12_22-14-45', 'screenshot2026-03-1222-14-45', 'jpg', '{\"original\":\"/upload/files/1773420441_mVqgFMev.jpg\",\"small\":\"/upload/files/1773420441_mVqgFMev_small.jpg\",\"medium\":\"/upload/files/1773420441_mVqgFMev_medium.jpg\"}', 1, '2026-03-13 21:47:21', '2026-03-13 21:47:21'),
(29, 'tron-le-aAn-_iTks4E-unsplash', 'tron-le-aan-itks4e-unsplash', 'jpg', '{\"original\":\"/upload/files/1773420836_Bx22Fd6M.jpg\",\"small\":\"/upload/files/1773420836_Bx22Fd6M_small.jpg\",\"medium\":\"/upload/files/1773420836_Bx22Fd6M_medium.jpg\"}', 1, '2026-03-13 21:53:56', '2026-03-13 21:53:56'),
(30, 'Screenshot_2026-03-12_22-14-45', 'screenshot2026-03-1222-14-45-2', 'jpg', '{\"original\":\"/upload/files/1773420839_82PUM9rh.jpg\",\"small\":\"/upload/files/1773420839_82PUM9rh_small.jpg\",\"medium\":\"/upload/files/1773420839_82PUM9rh_medium.jpg\"}', 1, '2026-03-13 21:53:59', '2026-03-13 21:53:59'),
(31, 'tron-le-aAn-_iTks4E-unsplash', 'tron-le-aan-itks4e-unsplash-2', 'jpg', '{\"original\":\"/upload/files/1773420884_HmIFSFvr.jpg\",\"small\":\"/upload/files/1773420884_HmIFSFvr_small.jpg\",\"medium\":\"/upload/files/1773420884_HmIFSFvr_medium.jpg\"}', 1, '2026-03-13 21:54:44', '2026-03-13 21:54:44'),
(32, 'tron-le-aAn-_iTks4E-unsplash', 'tron-le-aan-itks4e-unsplash-3', 'jpg', '{\"original\":\"/upload/files/1773420887_Ap1FHJt-.jpg\",\"small\":\"/upload/files/1773420887_Ap1FHJt-_small.jpg\",\"medium\":\"/upload/files/1773420887_Ap1FHJt-_medium.jpg\"}', 1, '2026-03-13 21:54:47', '2026-03-13 21:54:47');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '',
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `icon_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `name`, `code`, `status`, `created`, `updated`, `icon_id`) VALUES
(1, 'O\'zbek', 'uz', 1, '2026-03-07 23:28:03', '2026-03-07 23:28:03', NULL),
(2, 'Русскый', 'ru', 1, '2026-03-07 23:29:16', '2026-03-07 23:29:16', NULL),
(3, 'English', 'en', 1, '2026-03-09 21:31:53', '2026-03-09 21:32:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `template` enum('SINGLE','LIST','CATEGORY','EXTRA') NOT NULL DEFAULT 'SINGLE',
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `language_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `extra_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `name`, `slug`, `icon`, `image_id`, `template`, `parent_id`, `sort_order`, `status`, `created`, `updated`, `language_id`, `category_id`, `extra_url`) VALUES
(1, 'testnasmeasa', 'testnasmeasa', '', 1, 'LIST', NULL, 1, 1, '2026-03-02 22:33:34', '2026-03-13 22:58:43', 1, NULL, NULL),
(2, 'testnasmeasa', 'testnasmeasa-2', '', 1, 'SINGLE', 1, 1, 1, '2026-03-02 22:34:30', '2026-03-09 15:56:47', 2, NULL, NULL),
(3, 'Uzbekcha nimadir', 'uzbekcha-nimadir', 'icon', 3, 'SINGLE', NULL, 1, 1, '2026-03-07 23:33:37', '2026-03-09 15:56:44', 1, NULL, NULL),
(4, 'testnasmeasa', 'testnasmeasa-3', '', 1, 'SINGLE', 1, 1, 0, '2026-03-09 12:44:57', '2026-03-09 12:45:31', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE `partner` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `image_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` longtext DEFAULT NULL,
  `sku` varchar(255) NOT NULL DEFAULT '',
  `price` int(11) NOT NULL,
  `discount_price` int(11) DEFAULT 0,
  `discount_expires` datetime DEFAULT NULL,
  `specifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specifications`)),
  `stock_quantity` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1,
  `featured` int(11) DEFAULT 1,
  `seo_title` varchar(255) NOT NULL DEFAULT '',
  `seo_description` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT 5,
  `language_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `description`, `sku`, `price`, `discount_price`, `discount_expires`, `specifications`, `stock_quantity`, `status`, `featured`, `seo_title`, `seo_description`, `created`, `updated`, `image_id`, `rating`, `language_id`) VALUES
(5, 1, '', 'iphone-15-pro-max-yangilangan', NULL, 'IPHONE-15-PRO-MAX-256', 14000000, 13500000, '2025-06-30 23:59:59', '\"{\\\"display\\\":\\\"6.7 inch OLED\\\",\\\"memory\\\":\\\"256GB\\\",\\\"ram\\\":\\\"8GB\\\",\\\"color\\\":\\\"Natural Titanium\\\"}\"', 100, 1, 1, 'iPhone 15 Pro Max arzon narxda', 'iPhone 15 Pro Max eng yaxshi narxda sotib oling', '2026-02-17 16:04:51', '2026-02-17 16:08:30', 17, 5, NULL),
(6, 1, '', 'iphone-18-pro-max-yangilangan', NULL, 'IPHONE-18-PRO-MAX-256', 14000000, 13500000, '2025-06-30 23:59:59', '\"{\\\"display\\\":\\\"6.7 inch OLED\\\",\\\"memory\\\":\\\"256GB\\\",\\\"ram\\\":\\\"8GB\\\",\\\"color\\\":\\\"Natural Titanium\\\"}\"', 100, 1, 1, 'iPhone 18 Pro Max arzon narxda', 'iPhone 18 Pro Max eng yaxshi narxda sotib oling', '2026-02-21 20:36:05', '2026-02-21 20:38:02', 17, 5, NULL),
(7, 1, '', 'iphone-16-pro-max', NULL, '7374717637', 15000000, 14500000, '2024-12-31 23:59:59', '\"{\\\"fields\\\":[{\\\"display\\\":\\\"6.7 inch\\\",\\\"memory\\\":\\\"256GB\\\",\\\"ram\\\":\\\"8GB\\\",\\\"color\\\":\\\"Titanium Black\\\"}]}\"', 50, 1, 1, 'iPhone 15 Pro Max sotib olish', 'iPhone 15 Pro Max eng arzon narxda', '2026-02-21 21:01:01', '2026-02-21 21:01:01', 17, 5, NULL),
(8, 1, '', 'iphone-16-pro-max-2', NULL, '5068771413', 15000000, 14500000, '2024-12-31 23:59:59', NULL, 50, 1, 1, 'iPhone 15 Pro Max sotib olish', 'iPhone 15 Pro Max eng arzon narxda', '2026-02-24 23:44:06', '2026-02-24 23:44:06', 17, 5, NULL),
(9, 1, '', 'iphone-16-pro-max-3', NULL, '5151898237', 15000000, 14500000, '2024-12-31 23:59:59', NULL, 50, 1, 1, 'iPhone 15 Pro Max sotib olish', 'iPhone 15 Pro Max eng arzon narxda', '2026-02-25 22:29:11', '2026-02-25 22:29:11', 17, 5, NULL),
(10, 1, 'iPhone 16 Pro Max', 'iphone-16-pro-max-4', 'Apple kompaniyasining eng so\'nggi smartfoni', 'UZ-IPHON-N7TILXE', 15000000, 14500000, '2024-12-31 23:59:59', NULL, 50, 1, 1, 'iPhone 15 Pro Max sotib olish', 'iPhone 15 Pro Max eng arzon narxda', '2026-03-08 00:02:43', '2026-03-08 00:02:43', 17, 5, 1),
(11, 1, 'iPhone 16 Pro Max', 'iphone-16-pro-max-5', 'Apple kompaniyasining eng so\'nggi smartfoni', 'UZ-IPHON-C7CLGJO', 15000000, 14500000, '2024-12-31 23:59:59', NULL, 50, 1, 1, 'iPhone 15 Pro Max sotib olish', 'iPhone 15 Pro Max eng arzon narxda', '2026-03-08 00:04:57', '2026-03-08 00:04:57', 17, 5, 1),
(12, 12, 'iPhone 16 Pro Max', 'iphone-16-pro-max-6', 'Apple kompaniyasining eng so\'nggi smartfoni', 'UZ-IPHON-LTS9G50', 15000000, 14500000, '2024-12-31 23:59:59', NULL, 50, 1, 1, 'iPhone 15 Pro Max sotib olish', 'iPhone 15 Pro Max eng arzon narxda', '2026-03-09 12:50:04', '2026-03-13 20:18:52', 17, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_guides`
--

CREATE TABLE `product_guides` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `has_video` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated` datetime DEFAULT current_timestamp(),
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_guides`
--

INSERT INTO `product_guides` (`id`, `product_id`, `has_video`, `title`, `content`, `video_id`, `sort_order`, `status`, `created`, `updated`, `slug`) VALUES
(1, 5, 1, 'Qutidan chiqarish (yangilangan)', NULL, 1, 1, 1, '2026-02-21 20:41:22', '2026-02-17 16:08:30', 'qutidan-chiqarish-yangilangan'),
(2, 5, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-02-21 20:41:23', '2026-02-17 16:04:51', 'dastlabki-sozlash'),
(3, 5, 1, 'Qutidan chiqarish', NULL, 1, 1, 1, '2026-02-21 20:41:25', '2026-02-17 16:07:05', 'qutidan-chiqarish-2'),
(4, 5, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-02-21 20:41:26', '2026-02-17 16:07:05', 'dastlabki-sozlash-2'),
(5, 5, 1, 'Qutidan chiqarish', NULL, 1, 1, 1, '2026-02-21 20:41:28', '2026-02-17 16:07:16', 'qutidan-chiqarish-3'),
(6, 5, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-02-21 20:41:29', '2026-02-17 16:07:16', 'dastlabki-sozlash-3'),
(7, 5, 0, 'Yangi qo\'llanma', NULL, NULL, 3, 1, '2026-02-17 16:08:30', '2026-02-17 16:08:30', 'yangi-qollanma'),
(8, 6, 1, 'Qutidan chiqarisasdasdasdah', NULL, 1, 1, 1, '2026-02-21 20:41:20', '2026-02-21 20:41:14', 'qutidan-chiqarisasdasdasdah'),
(9, 7, 1, 'Qutidan chiqarish', NULL, 1, 1, 1, '2026-02-21 21:01:01', '2026-02-21 21:01:01', 'qutidan-chiqarish'),
(10, 7, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-02-21 21:01:01', '2026-02-21 21:01:01', 'dastlabki-sozlash-4'),
(11, 8, 1, 'Qutidan chiqarish', NULL, 1, 1, 1, '2026-02-24 23:44:06', '2026-02-24 23:44:06', 'qutidan-chiqarish-4'),
(12, 8, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-02-24 23:44:06', '2026-02-24 23:44:06', 'dastlabki-sozlash-5'),
(13, 9, 1, 'Qutidan chiqarish', NULL, 1, 1, 1, '2026-02-25 22:29:11', '2026-02-25 22:29:11', 'qutidan-chiqarish-5'),
(14, 9, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-02-25 22:29:11', '2026-02-25 22:29:11', 'dastlabki-sozlash-6'),
(15, 10, 1, 'Qutidan chiqarish', NULL, 1, 1, 1, '2026-03-08 00:02:43', '2026-03-08 00:02:43', 'qutidan-chiqarish-6'),
(16, 10, 0, 'Dastlabki sozlash', NULL, NULL, 2, 1, '2026-03-08 00:02:43', '2026-03-08 00:02:43', 'dastlabki-sozlash-7'),
(17, 11, 1, 'Qutidan chiqarish', 'Telefonni qutidan ehtiyotkorlik bilan chiqaring', 1, 1, 1, '2026-03-08 00:04:57', '2026-03-08 00:04:57', 'qutidan-chiqarish-7'),
(18, 11, 0, 'Dastlabki sozlash', 'Telefonni yoqing va Apple ID bilan kiring', NULL, 2, 1, '2026-03-08 00:04:57', '2026-03-08 00:04:57', 'dastlabki-sozlash-8'),
(19, 12, 1, 'Qutidan chiqarish', 'Telefonni qutidan ehtiyotkorlik bilan chiqaring', 1, 1, 1, '2026-03-09 12:50:04', '2026-03-09 12:50:04', 'qutidan-chiqarish-8'),
(20, 12, 0, 'Dastlabki sozlash', 'Telefonni yoqing va Apple ID bilan kiring', NULL, 2, 1, '2026-03-09 12:50:04', '2026-03-09 12:50:04', 'dastlabki-sozlash-9');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_primary` int(11) DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image_id`, `alt_text`, `sort_order`, `is_primary`, `created`, `updated`, `status`) VALUES
(1, 5, 17, 'iPhone 15 Pro Max old tomoni (yangilangan)', 1, 1, '2026-02-17 16:04:51', '2026-02-21 20:45:52', 1),
(2, 5, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-02-17 16:04:51', '2026-02-21 20:45:53', 1),
(3, 5, 17, 'iPhone 15 Pro Max old tomoni', 1, 0, '2026-02-17 16:07:05', '2026-02-21 20:45:54', 1),
(4, 5, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-02-17 16:07:05', '2026-02-21 20:45:55', 1),
(5, 5, 17, 'iPhone 15 Pro Max old tomoni', 1, 0, '2026-02-17 16:07:16', '2026-02-21 20:45:56', 1),
(6, 5, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-02-17 16:07:16', '2026-02-21 20:45:58', 1),
(7, 5, 18, 'Yangi rasm', 3, 0, '2026-02-17 16:08:30', '2026-02-17 16:08:30', 1),
(8, 6, 17, 'iPhone 15 Pro Max yangi tomoni', 1, 1, '2026-02-21 20:42:41', '2026-02-21 20:46:04', 1),
(9, 7, 17, 'iPhone 15 Pro Max old tomoni', 1, 1, '2026-02-21 21:01:01', '2026-02-21 21:01:01', 1),
(10, 7, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-02-21 21:01:01', '2026-02-21 21:01:01', 1),
(11, 8, 17, 'iPhone 15 Pro Max old tomoni', 1, 1, '2026-02-24 23:44:06', '2026-02-24 23:44:06', 1),
(12, 8, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-02-24 23:44:06', '2026-02-24 23:44:06', 1),
(13, 9, 17, 'iPhone 15 Pro Max old tomoni', 1, 1, '2026-02-25 22:29:11', '2026-02-25 22:29:11', 1),
(14, 9, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-02-25 22:29:11', '2026-02-25 22:29:11', 1),
(15, 10, 17, 'iPhone 15 Pro Max old tomoni', 1, 1, '2026-03-08 00:02:43', '2026-03-08 00:02:43', 1),
(16, 10, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-03-08 00:02:43', '2026-03-08 00:02:43', 1),
(17, 11, 17, 'iPhone 15 Pro Max old tomoni', 1, 1, '2026-03-08 00:04:57', '2026-03-08 00:04:57', 1),
(18, 11, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-03-08 00:04:57', '2026-03-08 00:04:57', 1),
(19, 12, 17, 'iPhone 15 Pro Max old tomoni', 1, 1, '2026-03-09 12:50:04', '2026-03-09 12:50:04', 1),
(20, 12, 16, 'iPhone 15 Pro Max orqa tomoni', 2, 0, '2026-03-09 12:50:04', '2026-03-09 12:50:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_soft`
--

CREATE TABLE `product_soft` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_soft`
--

INSERT INTO `product_soft` (`id`, `file_id`, `product_id`, `name`, `status`, `created`, `updated`) VALUES
(1, 2, 5, 'iPhone Driver v2.0', 1, '2026-02-17 16:04:51', '2026-03-13 20:34:54'),
(2, 1, 5, 'iTunes Setup', 1, '2026-02-17 16:04:51', '2026-03-13 20:34:57'),
(3, 2, 5, 'iPhone Driver v1.0', 1, '2026-02-17 16:07:05', '2026-03-13 20:34:58'),
(4, 1, 5, 'iTunes Setup', 1, '2026-02-17 16:07:05', '2026-03-13 20:34:59'),
(5, 2, 5, 'iPhone Driver v1.0', 1, '2026-02-17 16:07:16', '2026-03-13 20:35:00'),
(6, 1, 5, 'iTunes Setup', 1, '2026-02-17 16:07:16', '2026-03-13 20:35:01'),
(7, 3, 5, 'Yangi dastur', 1, '2026-02-17 16:08:30', '2026-02-17 16:08:30'),
(8, 2, 5, 'iPhone Driver v1.0', 1, '2026-02-21 20:46:59', '2026-02-21 20:47:40'),
(9, 2, 7, 'iPhone Driver v1.0', 1, '2026-02-21 21:01:01', '2026-02-21 21:01:01'),
(10, 1, 7, 'iTunes Setup', 1, '2026-02-21 21:01:01', '2026-02-21 21:01:01'),
(11, 2, 8, 'iPhone Driver v1.0', 1, '2026-02-24 23:44:06', '2026-02-24 23:44:06'),
(12, 1, 8, 'iTunes Setup', 1, '2026-02-24 23:44:06', '2026-02-24 23:44:06'),
(13, 2, 9, 'iPhone Driver v1.0', 1, '2026-02-25 22:29:11', '2026-02-25 22:29:11'),
(14, 1, 9, 'iTunes Setup', 1, '2026-02-25 22:29:11', '2026-02-25 22:29:11'),
(15, 2, 10, 'iPhone Driver v1.0', 1, '2026-03-08 00:02:43', '2026-03-08 00:02:43'),
(16, 1, 10, 'iTunes Setup', 1, '2026-03-08 00:02:43', '2026-03-08 00:02:43'),
(17, 2, 11, 'iPhone Driver v1.0', 1, '2026-03-08 00:04:57', '2026-03-08 00:04:57'),
(18, 1, 11, 'iTunes Setup', 1, '2026-03-08 00:04:57', '2026-03-08 00:04:57'),
(19, 2, 12, 'iPhone Driver v1.0', 1, '2026-03-09 12:50:04', '2026-03-09 12:50:04'),
(20, 1, 12, 'iTunes Setup', 1, '2026-03-09 12:50:04', '2026-03-09 12:50:04');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL DEFAULT 5,
  `order_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `logo_orginal_id` int(11) DEFAULT NULL,
  `logo_white_id` int(11) DEFAULT NULL,
  `url_instagram` varchar(255) DEFAULT NULL,
  `url_telegram` varchar(255) DEFAULT NULL,
  `url_facebook` varchar(255) DEFAULT NULL,
  `url_linkedIn` varchar(255) DEFAULT NULL,
  `url_threads` varchar(255) DEFAULT NULL,
  `url_discord` varchar(255) DEFAULT NULL,
  `url_youtube` varchar(255) DEFAULT NULL,
  `url_whatsapp` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `count_employee` int(11) DEFAULT NULL,
  `count_delivered` int(11) DEFAULT NULL,
  `count_product_types` int(11) DEFAULT NULL,
  `count_international_clients` int(11) DEFAULT NULL,
  `about_name` varchar(255) DEFAULT NULL,
  `about_description` text DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `other_phones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`other_phones`)),
  `emails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`emails`)),
  `address` text DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `questions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `logo_orginal_id`, `logo_white_id`, `url_instagram`, `url_telegram`, `url_facebook`, `url_linkedIn`, `url_threads`, `url_discord`, `url_youtube`, `url_whatsapp`, `phone`, `count_employee`, `count_delivered`, `count_product_types`, `count_international_clients`, `about_name`, `about_description`, `name`, `other_phones`, `emails`, `address`, `language_id`, `company_name`, `questions`) VALUES
(1, 17, 2, 'https://instagram.com/uzxcmg', 'https://t.me/uzxcmg', 'https://facebook.com/uzxcmg', 'https://linkedin.com/company/uzxcmg', 'string', 'string', 'https://youtube.com/@uzxcmg', 'https://wa.me/998901234567', 'asdasd', 50, 1000, 100, 25, 'Biz haqimizda', 'Kompaniya haqida batafsil ma\'lumot', 'asda22', '\"[\\\"+998 90 111 22 33\\\",\\\"+998 90 444 55 66\\\"]\"', '\"[\\\"info@uzxcmg.uz\\\",\\\"sales@uzxcmg.uz\\\"]\"', 'asdas', 1, 'UZXCMG LLC', '\"[{\\\"question\\\":\\\"Yetkazib berish qancha vaqt oladi?\\\",\\\"answer\\\":\\\"1-3 ish kuni ichida\\\"},{\\\"question\\\":\\\"To\'lov qanday amalga oshiriladi?\\\",\\\"answer\\\":\\\"Naqd, karta yoki bank o\'tkazmasi orqali\\\"}]\"');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `FK_admin_role_id` (`role_id`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_article_navigation_id` (`navigation_id`),
  ADD KEY `FK_article_language_id` (`language_id`),
  ADD KEY `FK_article_image_id` (`image_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_banner_language_id` (`language_id`),
  ADD KEY `FK_banner_image_id` (`image_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `FK_category_image_id` (`image_id`),
  ADD KEY `FK_category_language_id` (`language_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_language_icon_id` (`icon_id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_navigation_image_id` (`image_id`),
  ADD KEY `FK_navigation_parent_id` (`parent_id`),
  ADD KEY `FK_navigation_language_id` (`language_id`),
  ADD KEY `FK_navigation_category_id` (`category_id`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_partner_language_id` (`language_id`),
  ADD KEY `FK_partner_image_id` (`image_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `FK_product_category_id` (`category_id`),
  ADD KEY `FK_product_image_id` (`image_id`),
  ADD KEY `FK_product_language_id` (`language_id`);

--
-- Indexes for table `product_guides`
--
ALTER TABLE `product_guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product_guides_product_id` (`product_id`),
  ADD KEY `FK_product_guides_video_id` (`video_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product_image_product_id` (`product_id`),
  ADD KEY `FK_product_image_image_id` (`image_id`);

--
-- Indexes for table `product_soft`
--
ALTER TABLE `product_soft`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product_soft_file_id` (`file_id`),
  ADD KEY `FK_product_soft_product_id` (`product_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_rating_user_id` (`user_id`),
  ADD KEY `FK_rating_product_id` (`product_id`),
  ADD KEY `FK_rating_order_id` (`order_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_setting_logo_orginal_id` (`logo_orginal_id`),
  ADD KEY `FK_setting_logo_white_id` (`logo_white_id`),
  ADD KEY `FK_setting_language_id` (`language_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_guides`
--
ALTER TABLE `product_guides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_soft`
--
ALTER TABLE `product_soft`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FK_admin_role_id` FOREIGN KEY (`role_id`) REFERENCES `admin_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_article_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_article_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_article_navigation_id` FOREIGN KEY (`navigation_id`) REFERENCES `navigation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `banner`
--
ALTER TABLE `banner`
  ADD CONSTRAINT `FK_banner_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_banner_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_category_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_category_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `language`
--
ALTER TABLE `language`
  ADD CONSTRAINT `FK_language_icon_id` FOREIGN KEY (`icon_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `navigation`
--
ALTER TABLE `navigation`
  ADD CONSTRAINT `FK_navigation_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_navigation_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_navigation_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_navigation_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `navigation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `partner`
--
ALTER TABLE `partner`
  ADD CONSTRAINT `FK_partner_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_partner_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_product_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_guides`
--
ALTER TABLE `product_guides`
  ADD CONSTRAINT `FK_product_guides_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_guides_video_id` FOREIGN KEY (`video_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `FK_product_image_image_id` FOREIGN KEY (`image_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_image_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_soft`
--
ALTER TABLE `product_soft`
  ADD CONSTRAINT `FK_product_soft_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_product_soft_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_rating_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_rating_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_rating_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `setting`
--
ALTER TABLE `setting`
  ADD CONSTRAINT `FK_setting_language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_setting_logo_orginal_id` FOREIGN KEY (`logo_orginal_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_setting_logo_white_id` FOREIGN KEY (`logo_white_id`) REFERENCES `files` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
