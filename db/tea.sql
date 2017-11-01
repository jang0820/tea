-- MySQL dump 10.16  Distrib 10.1.22-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: tea
-- ------------------------------------------------------
-- Server version	10.1.22-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `cls_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cls_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `acc` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam` (
  `exam_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cls_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `exam_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exam_choice`
--

DROP TABLE IF EXISTS `exam_choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_choice` (
  `exam_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `exam_sn` int(11) NOT NULL,
  `exam_qu` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `exam_op1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_op2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_op3` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_op4` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_ans` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exam_result`
--

DROP TABLE IF EXISTS `exam_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_result` (
  `acc` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `exam_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `exam_s1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_s2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_s3` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `exam_s4` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  `stime` datetime NOT NULL,
  `etime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `exe`
--

DROP TABLE IF EXISTS `exe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exe` (
  `cls_id` varchar(20) NOT NULL,
  `exe_id` varchar(20) NOT NULL,
  `exe_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stu_class`
--

DROP TABLE IF EXISTS `stu_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stu_class` (
  `acc` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `cls_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stu_exam_choice`
--

DROP TABLE IF EXISTS `stu_exam_choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stu_exam_choice` (
  `acc` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `exam_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `exam_score` int(11) NOT NULL,
  `stime` datetime NOT NULL,
  `etime` datetime NOT NULL,
  `ans1` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ans2` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ans3` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ans4` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stu_exe`
--

DROP TABLE IF EXISTS `stu_exe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stu_exe` (
  `acc` varchar(30) NOT NULL,
  `cls_id` varchar(20) NOT NULL,
  `exe_id` varchar(20) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `f_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `acc` varchar(30) CHARACTER SET ascii NOT NULL,
  `pass` varchar(30) CHARACTER SET armscii8 NOT NULL,
  `name` varchar(30) NOT NULL,
  `prio` tinyint(4) NOT NULL,
  `class` varchar(10) NOT NULL,
  `seat` varchar(10) NOT NULL,
  `email` varchar(30) CHARACTER SET ascii NOT NULL,
  `tel` varchar(20) CHARACTER SET ascii NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-01  9:38:11
