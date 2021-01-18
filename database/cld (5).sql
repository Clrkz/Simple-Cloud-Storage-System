-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2019 at 12:29 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cld`
--

-- --------------------------------------------------------

--
-- Table structure for table `box_admins`
--

CREATE TABLE `box_admins` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `pass` text NOT NULL,
  `private` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `box_admins`
--

INSERT INTO `box_admins` (`id`, `user`, `pass`, `private`) VALUES
(1, 'admin', '8e1c62b9fa0bf878e26cc7f98ecf2970', 1),
(27, 'user', '4b886358416e4e86b603c3e08317f0ff', 2),
(28, 'user1', '7014a30f14f52f3188d1da57a93745f1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `box_files`
--

CREATE TABLE `box_files` (
  `id` int(11) NOT NULL,
  `filename` text CHARACTER SET utf8 NOT NULL,
  `real_filename` text CHARACTER SET utf8 NOT NULL,
  `password` text NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `date` int(11) NOT NULL,
  `removeHash` text CHARACTER SET utf8 NOT NULL,
  `ip` text CHARACTER SET utf8 NOT NULL,
  `owner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `box_files`
--

INSERT INTO `box_files` (`id`, `filename`, `real_filename`, `password`, `message`, `date`, `removeHash`, `ip`, `owner`) VALUES
(64, '2704275596', '7DSUNTU50.1-rv (2).hnh', '', '', 1552784489, '8b2d7ef1f0a67fe9032ffdac8abae0f2', '1.1.1.1', 'user'),
(69, '2779747124', 'u2 f1 - Copy.rar', '', '', 1552814944, 'a8815569a2063dc5e7665c4363bf6263', '1.2.0.0', ''),
(70, '2821404400', 'u2 f1 - Copy.rar', '', '', 1552814953, '0e849065a91412ec47ccc8bd9f64f78c', '::1', ''),
(71, '2851237795', 'u2 f1 - Copy.rar', '', '', 1552814957, 'dd1a4f4258dcd89c115892d6036f839f', '::1', ''),
(73, '2748132323', '139396.jpg', '', '', 1554117230, '9870db240ae8033cbebe9ba08bf86db3', '::1', 'user1');

-- --------------------------------------------------------

--
-- Table structure for table `box_options`
--

CREATE TABLE `box_options` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `box_options`
--

INSERT INTO `box_options` (`id`, `name`, `value`) VALUES
(1, 'big_title', '<label style=\"color: #ffb2b2;\">CL</label>OU<label style=\"color: #ffb2b2;\">D</label> FILE STORAGE'),
(2, 'website_title', 'CLD  Cloud Storage'),
(3, 'upload_captcha', '2'),
(4, 'max_upload_kb', '10000'),
(5, 'error_large_file', 'SORRY, YOUR FILE IS TOO LARGE!'),
(6, 'upload_success', 'UPLOADED SUCCESFULLY: <a href=\" {link}\" target=\"_blank\"> {filename}</a>'),
(7, 'email_msg', 'Hello,\r\nFilename: {filename}\r\nLink: {link}'),
(8, 'error_upload', 'ERROR UPLOADING FILE'),
(9, 'error_captcha', 'INVALID CAPTCHA'),
(10, 'file_not_select', 'NO FILE SELECTED'),
(11, 'error_extension', 'THIS EXTENSION IS NOT ALLOWED ({ext})'),
(12, 'extension_reject', 'php'),
(13, 'send_emails', '1'),
(14, 'max_emails', '0'),
(15, 'domain', '/cld');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `box_admins`
--
ALTER TABLE `box_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_files`
--
ALTER TABLE `box_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `box_options`
--
ALTER TABLE `box_options`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `box_admins`
--
ALTER TABLE `box_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `box_files`
--
ALTER TABLE `box_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `box_options`
--
ALTER TABLE `box_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
