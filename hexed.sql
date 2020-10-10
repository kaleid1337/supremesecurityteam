-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2019 at 03:58 AM
-- Server version: 10.1.37-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suprvlhn_critical`
--

-- --------------------------------------------------------

--
-- Table structure for table `2step_logs`
--

CREATE TABLE `2step_logs` (
  `ID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adminlogs`
--

CREATE TABLE `adminlogs` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `page` varchar(200) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `ID` int(11) NOT NULL,
  `IP` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fe`
--

CREATE TABLE `fe` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `type` varchar(1) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `note` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_logs`
--

CREATE TABLE `forgot_logs` (
  `ID` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `IP` varchar(20) NOT NULL,
  `date` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ipbanned`
--

CREATE TABLE `ipbanned` (
  `ID` int(11) NOT NULL,
  `IP` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `loginlogss`
--

CREATE TABLE `loginlogss` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `date` int(11) NOT NULL,
  `results` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(500) NOT NULL,
  `hostname` varchar(500) NOT NULL,
  `http` varchar(800) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logins_failed`
--

CREATE TABLE `logins_failed` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `ip` varchar(15) CHARACTER SET latin1 NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `ip` varchar(70) NOT NULL,
  `senderip` varchar(70) NOT NULL,
  `port` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `otime` int(11) NOT NULL,
  `method` varchar(10) NOT NULL,
  `date` int(11) NOT NULL,
  `servers` varchar(500) NOT NULL,
  `stopped` int(1) NOT NULL,
  `tocountry` varchar(50) NOT NULL,
  `day` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `sender` varchar(30) NOT NULL,
  `messagefloat` varchar(20) NOT NULL DEFAULT 'plane plane-',
  `time` int(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `methods`
--

CREATE TABLE `methods` (
  `ID` int(11) NOT NULL,
  `name` varchar(900) NOT NULL,
  `tag` varchar(900) NOT NULL,
  `type` varchar(50) NOT NULL,
  `adminonly` enum('Y','N') DEFAULT NULL,
  `viponly` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `methods`
--

INSERT INTO `methods` (`ID`, `name`, `tag`, `type`, `adminonly`, `viponly`) VALUES
(1, 'Test', 'Test', 'UDP', 'N', 'N'),
(2, 'Test2', 'Test2', 'UDP', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `detail` text NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `title`, `detail`, `date`) VALUES
(1, 'Testing', 'Testing...', 1551588065);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `mbt` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `length` int(11) NOT NULL,
  `price` float NOT NULL,
  `concurrent` int(11) NOT NULL,
  `apiaccess` enum('Y','N') NOT NULL,
  `vip` enum('Y','N') NOT NULL,
  `hidden` enum('Y','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`ID`, `name`, `mbt`, `unit`, `length`, `price`, `concurrent`, `apiaccess`, `vip`, `hidden`) VALUES
(1, 'Test', 300, 'Days', 1, 5, 1, 'N', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `registerlogs`
--

CREATE TABLE `registerlogs` (
  `id` int(11) NOT NULL,
  `username` varchar(15) CHARACTER SET latin1 NOT NULL,
  `ip` varchar(15) CHARACTER SET latin1 NOT NULL,
  `date` int(11) NOT NULL,
  `country` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `registerlogs`
--

INSERT INTO `registerlogs` (`id`, `username`, `ip`, `date`, `country`) VALUES
(1, 'TestingTheShit', '2605:6001:f207:', 1549176335, 'XX');

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `url` varchar(128) NOT NULL,
  `lastUsed` int(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `slots` int(11) NOT NULL,
  `methods` varchar(300) CHARACTER SET latin1 NOT NULL,
  `lastip` varchar(15) NOT NULL,
  `vip` enum('Y','N') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `siteconfig`
--

CREATE TABLE `siteconfig` (
  `id` int(11) NOT NULL,
  `merchant` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `ipnsecret` varchar(5000) CHARACTER SET latin1 NOT NULL DEFAULT '7BN86S9K8AOMB',
  `stresser` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `skype` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `http` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `cloudflare` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `iplogger` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `phonegeo` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `fe` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `geolocation` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `support` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `apimanager` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `servers` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `website` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `cloudflare_set` int(1) NOT NULL,
  `bootername_1` varchar(800) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Booter',
  `bootername_2` varchar(800) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Name',
  `rotation` int(1) NOT NULL DEFAULT '0',
  `preloader` int(1) NOT NULL DEFAULT '0',
  `tos` varchar(10000) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'T.O.S.',
  `site_forgot` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://localhost.com',
  `email_forgot` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin@localhost.com',
  `paypal` int(1) NOT NULL DEFAULT '0',
  `coinpayments` int(1) NOT NULL DEFAULT '0',
  `redirect` int(1) NOT NULL DEFAULT '0',
  `redirect_site` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://localhost.com/',
  `paypal_email` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `skypeapi` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `slider` int(1) NOT NULL DEFAULT '0',
  `subject_forgot` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `bitcoin` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `bitcoin_set` int(1) NOT NULL,
  `logo` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `cash_url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `cash` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `siteconfig`
--

INSERT INTO `siteconfig` (`id`, `merchant`, `ipnsecret`, `stresser`, `skype`, `http`, `cloudflare`, `iplogger`, `phonegeo`, `fe`, `geolocation`, `support`, `apimanager`, `servers`, `website`, `cloudflare_set`, `bootername_1`, `bootername_2`, `rotation`, `preloader`, `tos`, `site_forgot`, `email_forgot`, `paypal`, `coinpayments`, `redirect`, `redirect_site`, `paypal_email`, `skypeapi`, `slider`, `subject_forgot`, `key`, `bitcoin`, `bitcoin_set`, `logo`, `cash_url`, `cash`) VALUES
(1, '', '7BN86S9K8AOMB', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 0, 'BooterTest.Com', 'Name', 0, 0, 'T.O.S.', 'https://bootertest.com', 'admin@localhost.com', 0, 0, 0, 'http://localhost.com/', '', '', 0, '', '', '', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `skypeblacklist`
--

CREATE TABLE `skypeblacklist` (
  `ID` int(11) NOT NULL,
  `skype` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `subject` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `priority` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `lastreply` varchar(10) NOT NULL,
  `read` int(1) NOT NULL DEFAULT '0',
  `time` int(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `subject`, `content`, `priority`, `department`, `status`, `username`, `lastreply`, `read`, `time`) VALUES
(1, 'test', 'Test', 'Low', 'Billing', 'Waiting for admin response', 'TestingTheShit', 'user', 1, 1551158866);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `membership` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `status` varchar(1000) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `apikey` varchar(128) NOT NULL,
  `lastip` varchar(20) NOT NULL,
  `lastlogin` int(11) NOT NULL,
  `lastact` int(11) NOT NULL,
  `security_question` varchar(500) NOT NULL DEFAULT '0',
  `answer_question` varchar(500) NOT NULL DEFAULT '0',
  `ip_address` varchar(35) NOT NULL,
  `ip_address_api` varchar(25) NOT NULL,
  `log_redirect` varchar(60) NOT NULL DEFAULT 'http://google.com',
  `code_account` varchar(5) NOT NULL DEFAULT '0',
  `code` varchar(15) NOT NULL DEFAULT '0',
  `reset` varchar(15) NOT NULL DEFAULT '0',
  `key` varchar(30) NOT NULL,
  `whiteliston` enum('Y','N') NOT NULL,
  `api_ips` varchar(50) NOT NULL,
  `account_balance` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`, `rank`, `membership`, `expire`, `status`, `apikey`, `lastip`, `lastlogin`, `lastact`, `security_question`, `answer_question`, `ip_address`, `ip_address_api`, `log_redirect`, `code_account`, `code`, `reset`, `key`, `whiteliston`, `api_ips`, `account_balance`) VALUES
(1, 'TestingTheShit', 'ce6e647882b918659ee67a9698ebb4ad95544fb41923eaa9db0ec8e0f93f3b427148eb19b6c2701a68e3d5022ec4a41281016ee6ff686ae7cbda65b7051337', '1337@fbi.gov', 2, 1, 1551600155, '0', 'boombox92', '1.3.3.7', 1551590548, 1551590914, 'In what city were you born?', '91da4589b012c2fe1ceac1fb2363dbc6', '0', 'OFF', 'OFF', '54321', '0', '0', '0', 'Y', '0', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2step_logs`
--
ALTER TABLE `2step_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `adminlogs`
--
ALTER TABLE `adminlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `fe`
--
ALTER TABLE `fe`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `forgot_logs`
--
ALTER TABLE `forgot_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ipbanned`
--
ALTER TABLE `ipbanned`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `loginlogss`
--
ALTER TABLE `loginlogss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logins_failed`
--
ALTER TABLE `logins_failed`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`);

--
-- Indexes for table `methods`
--
ALTER TABLE `methods`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `registerlogs`
--
ALTER TABLE `registerlogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siteconfig`
--
ALTER TABLE `siteconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fe`
--
ALTER TABLE `fe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loginlogss`
--
ALTER TABLE `loginlogss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logins_failed`
--
ALTER TABLE `logins_failed`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `methods`
--
ALTER TABLE `methods`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registerlogs`
--
ALTER TABLE `registerlogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `siteconfig`
--
ALTER TABLE `siteconfig`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
