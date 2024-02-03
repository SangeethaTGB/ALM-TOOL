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

/*Table structure for table `alm_appendix1_maturity_profile_liquidity` */

DROP TABLE IF EXISTS `alm_appendix1_maturity_profile_liquidity`;

CREATE TABLE `alm_appendix1_maturity_profile_liquidity` (
  `OrderNo` double NOT NULL,
  `op_mode` varchar(20) DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `sub_Category` text NOT NULL,
  `AsonDate` date NOT NULL,
  `RM_1D_to_14D` double DEFAULT NULL,
  `RM_15D_to_28D` double DEFAULT NULL,
  `RM_29D_to_3M` double DEFAULT NULL,
  `RM_3M_to_6M` double DEFAULT NULL,
  `RM_6M_to_1Y` double DEFAULT NULL,
  `RM_1Y_to_3Y` double DEFAULT NULL,
  `RM_3Y_to_5Y` double DEFAULT NULL,
  `RM_OVER_5Y` double DEFAULT NULL,
  `RM_TOTAL` double DEFAULT NULL,
  `UpdatedTS` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `DisplayOrder` int(10) NOT NULL,
  UNIQUE KEY `DisplayOrder` (`DisplayOrder`,`AsonDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=99;

/*Table structure for table `alm_appendix1_model` */

DROP TABLE IF EXISTS `alm_appendix1_model`;

CREATE TABLE `alm_appendix1_model` (
  `OrderNo` double NOT NULL,
  `op_mode` varchar(20) DEFAULT NULL,
  `Category` varchar(100) DEFAULT NULL,
  `sub_Category` text NOT NULL,
  `Comments` text NOT NULL,
  `DisplayOrder` int(10) NOT NULL,
  `ar1_mapping` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=92;

/*Table structure for table `alm_bond` */

DROP TABLE IF EXISTS `alm_bond`;

CREATE TABLE `alm_bond` (
  `Entry_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Purchase_Date` date DEFAULT NULL,
  `Invest_Particulars` varchar(255) DEFAULT NULL,
  `Face_Value` double DEFAULT NULL,
  `Book_Value` double DEFAULT NULL,
  `Purchase_Value` double DEFAULT NULL,
  `Maturity_Date` date DEFAULT NULL,
  `Interest_Rate` double DEFAULT NULL,
  `ISIN` varbinary(25) DEFAULT NULL,
  `Frequency_Intr_Rbl` int(10) DEFAULT NULL,
  `Last_Intr_Recd_Date` date DEFAULT NULL,
  PRIMARY KEY (`Entry_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=107;

/*Table structure for table `alm_ca_settlement` */

DROP TABLE IF EXISTS `alm_ca_settlement`;

CREATE TABLE `alm_ca_settlement` (
  `Entry_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Segment_Name` varchar(100) NOT NULL,
  `CA_AccNo` varchar(20) NOT NULL,
  `DailyLimit` double NOT NULL,
  `BGL_AccNo` varchar(20) NOT NULL,
  `AccType` varchar(10) NOT NULL,
  PRIMARY KEY (`Entry_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=60;

/*Table structure for table `alm_data_load` */

DROP TABLE IF EXISTS `alm_data_load`;

CREATE TABLE `alm_data_load` (
  `EntryId` int(10) NOT NULL AUTO_INCREMENT,
  `FilesList` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`EntryId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=24;

/*Table structure for table `alm_data_load_status` */

DROP TABLE IF EXISTS `alm_data_load_status`;

CREATE TABLE `alm_data_load_status` (
  `EntryId` int(10) NOT NULL AUTO_INCREMENT,
  `EntryDate` date DEFAULT NULL,
  `Asondate` varchar(20) DEFAULT NULL,
  `Data_List` varchar(100) DEFAULT NULL,
  `StaffId` int(10) DEFAULT NULL,
  `LoadedTS` datetime NOT NULL,
  `DLEntryId` int(10) DEFAULT NULL,
  PRIMARY KEY (`EntryId`)
) ENGINE=InnoDB AUTO_INCREMENT=606 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=50;

/*Table structure for table `alm_mf` */

DROP TABLE IF EXISTS `alm_mf`;

CREATE TABLE `alm_mf` (
  `Entry_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Purchase_Date` date DEFAULT NULL,
  `Invest_Particulars` varchar(255) DEFAULT NULL,
  `Face_Value` double DEFAULT NULL,
  `Market_Value` double DEFAULT NULL,
  `Purchase_Value` double DEFAULT NULL,
  `Appr_Dep` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Entry_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=80;

/*Table structure for table `alm_slr` */

DROP TABLE IF EXISTS `alm_slr`;

CREATE TABLE `alm_slr` (
  `Entry_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Purchase_Date` date DEFAULT NULL,
  `Maturity_Date` date DEFAULT NULL,
  `Interest_Rate` double DEFAULT NULL,
  `Book_Value` double DEFAULT NULL,
  `ISIN` varchar(15) DEFAULT NULL,
  `HTM_AFS` varchar(15) DEFAULT NULL,
  `Investment_Particulars` varchar(255) DEFAULT NULL,
  `Face_Value` double DEFAULT NULL,
  `Purchase_Value` double DEFAULT NULL,
  `Frequency_Intr_Rbl` int(10) DEFAULT NULL,
  `Last_Intr_Recd_Date` date DEFAULT NULL,
  PRIMARY KEY (`Entry_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=106;

/*Table structure for table `alm_slr_old` */

DROP TABLE IF EXISTS `alm_slr_old`;

CREATE TABLE `alm_slr_old` (
  `Entry_ID` int(11) NOT NULL DEFAULT 0,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Purchase_Date` date DEFAULT NULL,
  `Maturity_Date` date DEFAULT NULL,
  `Interest_Rate` double DEFAULT NULL,
  `Book_Value` double DEFAULT NULL,
  `ISIN` varchar(15) DEFAULT NULL,
  `HTM_AFS` varchar(15) DEFAULT NULL,
  `Investment_Particulars` varchar(255) DEFAULT NULL,
  `Face_Value` double DEFAULT NULL,
  `Purchase_Value` double DEFAULT NULL,
  `Frequency_Intr_Rbl` int(10) DEFAULT NULL,
  `Last_Intr_Recd_Date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=114;

/*Table structure for table `alm_tdr` */

DROP TABLE IF EXISTS `alm_tdr`;

CREATE TABLE `alm_tdr` (
  `Entry_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Purchase_Date` date DEFAULT NULL,
  `Bank_Name` varchar(50) DEFAULT NULL,
  `Account_No` varchar(55) DEFAULT NULL,
  `Amount_Deposited` double DEFAULT NULL,
  `Maturity_Date` date DEFAULT NULL,
  `Interest_Rate` double DEFAULT NULL,
  `ACTIVE` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`Entry_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=72;

/*Table structure for table `alm_tdr_tmp` */

DROP TABLE IF EXISTS `alm_tdr_tmp`;

CREATE TABLE `alm_tdr_tmp` (
  `Entry_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Entry_Date` date DEFAULT NULL,
  `Updated_By` int(11) DEFAULT NULL,
  `Updated_On` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `Purchase_Date` date DEFAULT NULL,
  `Bank_Name` varchar(50) DEFAULT NULL,
  `Account_No` varchar(55) DEFAULT NULL,
  `Amount_Deposited` double DEFAULT NULL,
  `Maturity_Date` date DEFAULT NULL,
  `Interest_Rate` double DEFAULT NULL,
  `DaysCnt` int(11) DEFAULT NULL,
  PRIMARY KEY (`Entry_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=20;

/*Table structure for table `business_dw_tmp` */

DROP TABLE IF EXISTS `business_dw_tmp`;

CREATE TABLE `business_dw_tmp` (
  `RUN_DATE` varchar(15) NOT NULL,
  `BRCODE` varchar(10) NOT NULL,
  `CGL_ACC_NO` varchar(20) NOT NULL,
  `ACC_TYPE` varchar(40) NOT NULL,
  `BALANCE` decimal(20,2) NOT NULL,
  `OPENING_BAL` decimal(20,2) NOT NULL,
  `CLOSING_BAL` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=70;

/*Table structure for table `cgl_add_ded` */

DROP TABLE IF EXISTS `cgl_add_ded`;

CREATE TABLE `cgl_add_ded` (
  `gl_acct` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `manual_bal` double NOT NULL,
  `curmonth` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=28;

/*Table structure for table `cgl_ar1_mapping` */

DROP TABLE IF EXISTS `cgl_ar1_mapping`;

CREATE TABLE `cgl_ar1_mapping` (
  `cgl` varchar(50) NOT NULL DEFAULT '0',
  `level1_classification` varchar(255) DEFAULT '0',
  `ar1_mapping` varchar(255) DEFAULT '0',
  `ar1_sub_mapping` varchar(200) DEFAULT '0',
  PRIMARY KEY (`cgl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=39;

/*Table structure for table `cgl_ar2_mapping` */

DROP TABLE IF EXISTS `cgl_ar2_mapping`;

CREATE TABLE `cgl_ar2_mapping` (
  `cgl` varchar(100) NOT NULL DEFAULT '0',
  `level1_classification` varchar(100) DEFAULT '0',
  `ar2_mapping` varchar(45) DEFAULT '0',
  `ar2_sub_mapping` varchar(45) DEFAULT '0',
  PRIMARY KEY (`cgl`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=33;

/*Table structure for table `cgllist` */

DROP TABLE IF EXISTS `cgllist`;

CREATE TABLE `cgllist` (
  `CGL_ACC_NO` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACC_TYPE` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LEVEL3` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `LEVEL2` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `LEVEL1` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `LEVEL1ID` int(5) NOT NULL,
  `LEVEL2ID` int(5) NOT NULL,
  `LEVEL3ID` int(5) DEFAULT NULL,
  `LEVEL4ID` int(5) DEFAULT NULL,
  `EntryId` int(10) NOT NULL,
  `EntryDate` date NOT NULL,
  `prod_desc_cat1` smallint(6) DEFAULT NULL,
  UNIQUE KEY `CGL_ACC_NO` (`CGL_ACC_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `crystal_mapping` */

DROP TABLE IF EXISTS `crystal_mapping`;

CREATE TABLE `crystal_mapping` (
  `GL_ACCT` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `GL_ACCTNAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `GL_GROUPNAME_ACCT` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `GL_GROUPNAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `GL_GROUPNAME_OUT` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `GL_MAINGROUP` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `GL_NATURE` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=120;

/*Table structure for table `dailyweekly_31012024` */

DROP TABLE IF EXISTS `dailyweekly_31012024`;

CREATE TABLE `dailyweekly_31012024` (
  `RUN_DATE` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `OPENING_BAL` decimal(20,2) NOT NULL,
  `CLOSING_BAL` decimal(20,2) NOT NULL,
  `BALANCE` decimal(20,2) NOT NULL,
  `BRCODE` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CGL_ACC_NO` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ACC_TYPE` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LEVEL3` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `LEVEL2` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `LEVEL1` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Table structure for table `dailyweeklytbl` */

DROP TABLE IF EXISTS `dailyweeklytbl`;

CREATE TABLE `dailyweeklytbl` (
  `RUN_DATE` varchar(15) NOT NULL,
  `OPENING_BAL` decimal(20,2) NOT NULL,
  `CLOSING_BAL` decimal(20,2) NOT NULL,
  `BALANCE` decimal(20,2) NOT NULL,
  `BRCODE` varchar(10) NOT NULL,
  `CGL_ACC_NO` varchar(20) NOT NULL,
  `ACC_TYPE` varchar(40) NOT NULL,
  `LEVEL3` varchar(30) NOT NULL,
  `LEVEL2` varchar(30) NOT NULL,
  `LEVEL1` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=127;

/*Table structure for table `npa` */

DROP TABLE IF EXISTS `npa`;

CREATE TABLE `npa` (
  `RUN_DATE` varchar(15) DEFAULT NULL,
  `BRCODE` varchar(10) NOT NULL,
  `ACCOUNT_NO` varchar(35) NOT NULL,
  `ACCOUNT_TYPE` varchar(35) NOT NULL,
  `CUSTOMER_NAME` varchar(35) NOT NULL,
  `IRATE` varchar(35) NOT NULL,
  `LIMIT` varchar(35) NOT NULL,
  `IRREGULARITY` varchar(35) NOT NULL,
  `IRAC_N` varchar(35) NOT NULL,
  `IRAC_O` varchar(35) NOT NULL,
  `BALANCE` double NOT NULL,
  `SAN_DT` date NOT NULL,
  `CCOD_TLDL` varchar(35) NOT NULL,
  `CRDR` varchar(5) NOT NULL,
  `ExpiryDate` varchar(35) NOT NULL,
  `SancLimit` varchar(35) NOT NULL,
  `CIF` varchar(35) NOT NULL,
  `Product` varchar(35) NOT NULL,
  `Status` varchar(35) NOT NULL,
  `Mobile` varchar(15) NOT NULL,
  `Aadhar` varchar(20) NOT NULL,
  `PAN` varchar(20) NOT NULL,
  `HomeBranch` int(10) NOT NULL,
  `AcctBranch` int(10) NOT NULL,
  `LstCrDate` varchar(20) NOT NULL,
  KEY `ACCOUNT_NO` (`ACCOUNT_NO`),
  KEY `IDX_npa_CIF` (`CIF`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/* Function  structure for function  `calcLastIntrRcdDate` */

/*!50003 DROP FUNCTION IF EXISTS `calcLastIntrRcdDate` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`10.88.1.254` FUNCTION `calcLastIntrRcdDate`(sdate DATE, edate DATE) RETURNS date
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
    declare halfYears DOUBLE;
    declare newDate Date;
	set halfYears=	floor(DATEDIFF(edate,sdate)/180);
	 
	 set newDate = date_add(sdate,interval halfYears*6 MONTH);
	 IF (newDate >edate) then set newDate = DATE_SUB(newDate,INTERVAL 6 MONTH); end if;
	 RETURN newDate;
    END */$$
DELIMITER ;

/* Function  structure for function  `calc_days360` */

/*!50003 DROP FUNCTION IF EXISTS `calc_days360` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `calc_days360`(sdate date, edate date) RETURNS int(11)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
  DECLARE sdate_360 int;
  DECLARE edate_360 int;
  SET sdate_360 = (YEAR(sdate) * 360) + ((MONTH(sdate) - 1) * 30) + DAY(sdate);
  SET edate_360 = (YEAR(edate) * 360) + ((MONTH(edate) - 1) * 30) + DAY(edate);
  RETURN edate_360 - sdate_360 ;
END */$$
DELIMITER ;

/* Function  structure for function  `calc_tdr_interest` */

/*!50003 DROP FUNCTION IF EXISTS `calc_tdr_interest` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `calc_tdr_interest`(roi decimal(20, 8), pdate date, mdate date, adate date, Amt decimal(20, 8)) RETURNS decimal(20,5)
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN
  DECLARE intr_rbl decimal(20, 8);
  DECLARE n int;
  DECLARE pdate1 date;
  DECLARE Amt1 decimal(20, 8);
  DECLARE no_of_days int;
  DECLARE tot_no_of_days int;
  DECLARE qdate date;
  DECLARE cnt int;
  DECLARE lqdate date;
  DECLARE datedif int;
  SET lqdate = pdate;
  SET pdate1 = pdate;
  SET qdate = pdate;
  SET Amt1 = Amt;
  SET datedif = DATEDIFF(adate, qdate);
  SET tot_no_of_days = 0;
  SET cnt = 1;
l1:
  WHILE (datedif >= 0) DO
    SET qdate = DATE_ADD(pdate, INTERVAL (cnt * 3) MONTH) - 1;
    IF qdate < adate THEN
      SET no_of_days = DATEDIFF(qdate, pdate1);
      
      SET cnt = cnt + 1;
      SET lqdate = qdate;
    ELSE
      SET no_of_days = DATEDIFF(adate, lqdate);
    
    END IF;
    SET Amt1 = Amt1 + (Amt1 * roi * no_of_days) / 36500;
    SET pdate1 = qdate;

    SET datedif = DATEDIFF(adate, qdate);
    IF datedif IS NULL THEN
      SET datedif = -1;
    END IF;
    SET tot_no_of_days = tot_no_of_days + no_of_days;
  END WHILE l1;
  SET Amt1 = Amt1 + (Amt1 * roi) / 36500;
  SET intr_rbl = Amt1 - Amt;
  RETURN intr_rbl;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
