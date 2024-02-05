/*
SQLyog Community v12.09 (32 bit)
MySQL - 10.4.27-MariaDB : Database - investments
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`investments` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `investments`;

/*Table structure for table `trmm0403` */

DROP TABLE IF EXISTS `trmm0403`;

CREATE TABLE `trmm0403` (
  `Particulars` text DEFAULT NULL,
  `RM_1D_to_14D` double DEFAULT NULL,
  `RM_15D_to_28D` double DEFAULT NULL,
  `RM_29D_to_3M` double DEFAULT NULL,
  `RM_3M_to_6M` double DEFAULT NULL,
  `RM_6M_to_1Y` double DEFAULT NULL,
  `RM_1Y_to_3Y` double DEFAULT NULL,
  `RM_3Y_to_5Y` double DEFAULT NULL,
  `RM_OVER_5Y` double DEFAULT NULL,
  `RM_TOTAL` double DEFAULT NULL,
  `AsonDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=90;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
