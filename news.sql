-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Sep 17, 2015 at 11:52 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `News`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts_table`
--

CREATE TABLE `posts_table` (
  `ID` int(255) NOT NULL,
  `Title` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `URL` varchar(2084) CHARACTER SET ucs2 DEFAULT NULL,
  `up_votes` int(11) NOT NULL DEFAULT '0',
  `time_stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `by_user_id` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_table`
--

INSERT INTO `posts_table` (`ID`, `Title`, `URL`, `up_votes`, `time_stamp`, `by_user_id`) VALUES
(1, 'mysql - Query works in phpmyadmin but not in PHP script - Stack Overflow', 'http://stackoverflow.com/questions/19304351/query-works-in-phpmyadmin-but-not-in-php-script', 10, NULL, 12),
(2, 'How to Create a Secure Login Script in PHP and MySQL - wikiHow', 'http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL', 19, NULL, 13),
(3, 'regex - How to get a website&#39;s favicon with PHP? - Stack Overflow', 'http://stackoverflow.com/questions/5701593/how-to-get-a-websites-favicon-with-php', 10, '2015-09-10 13:25:20', 14),
(4, 'reddit: the front page of the internet', 'https://www.reddit.com/', 3, '2015-09-12 21:40:07', 15),
(5, 'PHP - AJAX and PHP', 'http://www.w3schools.com/php/php_ajax_php.asp', 1, '2015-09-12 21:48:36', 15);

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `ID` int(255) NOT NULL,
  `user_name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_pass` varchar(40) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`ID`, `user_name`, `user_pass`) VALUES
(12, 'juhi', '920e3e1ffd0aa54c60a84af197f40c5b'),
(13, 'sarthak', 'd0199f51d2728db6011945145a1b607a'),
(14, 'abc', '900150983cd24fb0d6963f7d28e17f72'),
(15, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229'),
(16, 'aman', 'ccda1683d8c97f8f2dff2ea7d649b42c'),
(17, 'deadmau5', 'd27105e8e5870d76b0e38199aec1ba81');

-- --------------------------------------------------------

--
-- Table structure for table `votes_table`
--

CREATE TABLE `votes_table` (
  `user_id` int(255) NOT NULL DEFAULT '0',
  `post_id` int(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes_table`
--

INSERT INTO `votes_table` (`user_id`, `post_id`) VALUES
(12, 1),
(12, 2),
(12, 3),
(14, 3),
(14, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts_table`
--
ALTER TABLE `posts_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `votes_table`
--
ALTER TABLE `votes_table`
  ADD PRIMARY KEY (`user_id`,`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts_table`
--
ALTER TABLE `posts_table`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;