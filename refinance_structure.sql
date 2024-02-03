/*
SQLyog Community v12.09 (32 bit)
MySQL - 10.4.27-MariaDB : Database - refinance
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`refinance` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `refinance`;

/*Table structure for table `closed_records` */

DROP TABLE IF EXISTS `closed_records`;

CREATE TABLE `closed_records` (
  `RefId` int(5) NOT NULL,
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(20) DEFAULT NULL,
  `Refi_date` date DEFAULT NULL,
  `Interest` decimal(20,2) DEFAULT NULL,
  `Amount` decimal(20,2) DEFAULT 0.00,
  `First_installment` date DEFAULT NULL,
  `Payment_cycle` varchar(20) DEFAULT NULL,
  `No_installments` int(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=59;

/*Table structure for table `closedinstallmentrecords` */

DROP TABLE IF EXISTS `closedinstallmentrecords`;

CREATE TABLE `closedinstallmentrecords` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(30) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Amount_Sanctioned` decimal(20,2) DEFAULT NULL,
  `Interest` decimal(20,2) NOT NULL,
  `Inst_date` date DEFAULT NULL,
  `Inst_amt` decimal(20,2) DEFAULT NULL,
  `Installment_NO` int(11) DEFAULT NULL,
  `outStanding` decimal(20,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=67;

/*Table structure for table `inst_table` */

DROP TABLE IF EXISTS `inst_table`;

CREATE TABLE `inst_table` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(30) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Amount_Sanctioned` decimal(20,2) DEFAULT NULL,
  `Interest` decimal(20,2) NOT NULL,
  `Inst_date` date DEFAULT NULL,
  `Inst_amt` decimal(20,2) DEFAULT NULL,
  `Installment_NO` int(11) DEFAULT NULL,
  `outStanding` decimal(20,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=67;

/*Table structure for table `interest_payment_history` */

DROP TABLE IF EXISTS `interest_payment_history`;

CREATE TABLE `interest_payment_history` (
  `RefId` int(5) NOT NULL,
  `Paid_Date` date NOT NULL,
  `Amount_Paid` decimal(10,0) NOT NULL,
  `Refinance_agency` varchar(100) NOT NULL,
  `Scheme` varchar(100) NOT NULL,
  `UTR_No` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `interest_testing` */

DROP TABLE IF EXISTS `interest_testing`;

CREATE TABLE `interest_testing` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Interest` decimal(20,2) NOT NULL,
  `dailydate` date DEFAULT NULL,
  `outstanding` decimal(20,2) DEFAULT NULL,
  `Intrest_Amount` decimal(20,2) DEFAULT NULL,
  `Installment_No` int(20) DEFAULT NULL,
  `IntrestPeriod` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `intprovtable` */

DROP TABLE IF EXISTS `intprovtable`;

CREATE TABLE `intprovtable` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Interest` decimal(20,2) NOT NULL,
  `Intrest_Amount` decimal(20,2) DEFAULT NULL,
  `IntrestPeriod` int(20) NOT NULL,
  `last_paid_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `intprovtwodates` */

DROP TABLE IF EXISTS `intprovtwodates`;

CREATE TABLE `intprovtwodates` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Interest` decimal(20,2) NOT NULL,
  `Intrest_Amount` decimal(20,2) DEFAULT NULL,
  `IntrestPeriod` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `intrestpayhistory` */

DROP TABLE IF EXISTS `intrestpayhistory`;

CREATE TABLE `intrestpayhistory` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(20) NOT NULL,
  `Intrest_Paid_Amt` decimal(20,2) NOT NULL,
  `Intrest_Paid_Date` date NOT NULL,
  `scheme` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=32;

/*Table structure for table `refinance_interest_daywise` */

DROP TABLE IF EXISTS `refinance_interest_daywise`;

CREATE TABLE `refinance_interest_daywise` (
  `RefID` int(20) NOT NULL,
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Interest` decimal(20,2) NOT NULL,
  `dailydate` date DEFAULT NULL,
  `outstanding` decimal(20,2) DEFAULT NULL,
  `Intrest_Amount` decimal(20,2) DEFAULT NULL,
  `Installment_No` int(20) DEFAULT NULL,
  `IntrestPeriod` int(20) NOT NULL,
  KEY `REFDAYWISE_IDX` (`RefID`,`dailydate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `refinance_master` */

DROP TABLE IF EXISTS `refinance_master`;

CREATE TABLE `refinance_master` (
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(20) DEFAULT NULL,
  `Refi_date` varchar(12) DEFAULT NULL,
  `Interest` decimal(20,2) DEFAULT NULL,
  `Amount` varchar(20) DEFAULT NULL,
  `First_installment` varchar(12) DEFAULT NULL,
  `Payment_cycle` varchar(20) DEFAULT NULL,
  `No_installments` int(20) DEFAULT NULL,
  `INS1` decimal(20,2) DEFAULT NULL,
  `INS2` decimal(20,2) DEFAULT NULL,
  `INS3` decimal(20,2) DEFAULT NULL,
  `INS4` decimal(20,2) DEFAULT NULL,
  `INS5` decimal(20,2) DEFAULT NULL,
  `INS6` decimal(20,2) DEFAULT NULL,
  `INS7` decimal(20,2) DEFAULT NULL,
  `INS8` decimal(20,2) DEFAULT NULL,
  `INS9` decimal(20,2) DEFAULT NULL,
  `INS10` decimal(20,2) DEFAULT NULL,
  `INS11` decimal(20,2) DEFAULT NULL,
  `INS12` decimal(20,2) DEFAULT NULL,
  `INS13` decimal(20,2) DEFAULT NULL,
  `INS14` decimal(20,2) DEFAULT NULL,
  `INS15` decimal(20,2) DEFAULT NULL,
  `INS16` decimal(20,2) DEFAULT NULL,
  `INS17` decimal(20,2) DEFAULT NULL,
  `INS18` decimal(20,2) DEFAULT NULL,
  `INS19` decimal(20,2) DEFAULT NULL,
  `INS20` decimal(20,2) DEFAULT NULL,
  `INS21` decimal(20,2) DEFAULT NULL,
  `INS22` decimal(20,2) DEFAULT NULL,
  `INS23` decimal(20,2) DEFAULT NULL,
  `INS24` decimal(20,2) DEFAULT NULL,
  `INS25` decimal(20,2) DEFAULT NULL,
  `INS26` decimal(20,2) DEFAULT NULL,
  `INS27` decimal(20,2) DEFAULT NULL,
  `INS28` decimal(20,2) DEFAULT NULL,
  `INS29` decimal(20,2) DEFAULT NULL,
  `INS30` decimal(20,2) DEFAULT NULL,
  `DATE1` varchar(12) DEFAULT NULL,
  `DATE2` varchar(12) DEFAULT NULL,
  `DATE3` varchar(12) DEFAULT NULL,
  `DATE4` varchar(12) DEFAULT NULL,
  `DATE5` varchar(12) DEFAULT NULL,
  `DATE6` varchar(12) DEFAULT NULL,
  `DATE7` varchar(12) DEFAULT NULL,
  `DATE8` varchar(12) DEFAULT NULL,
  `DATE9` varchar(12) DEFAULT NULL,
  `DATE10` varchar(12) DEFAULT NULL,
  `DATE11` varchar(12) DEFAULT NULL,
  `DATE12` varchar(12) DEFAULT NULL,
  `DATE13` varchar(12) DEFAULT NULL,
  `DATE14` varchar(12) DEFAULT NULL,
  `DATE15` varchar(12) DEFAULT NULL,
  `DATE16` varchar(12) DEFAULT NULL,
  `DATE17` varchar(12) DEFAULT NULL,
  `DATE18` varchar(12) DEFAULT NULL,
  `DATE19` varchar(12) DEFAULT NULL,
  `DATE20` varchar(12) DEFAULT NULL,
  `DATE21` varchar(12) DEFAULT NULL,
  `DATE22` varchar(12) DEFAULT NULL,
  `DATE23` varchar(12) DEFAULT NULL,
  `DATE24` varchar(12) DEFAULT NULL,
  `DATE25` varchar(12) DEFAULT NULL,
  `DATE26` varchar(12) DEFAULT NULL,
  `DATE27` varchar(12) DEFAULT NULL,
  `DATE28` varchar(12) DEFAULT NULL,
  `DATE29` varchar(12) DEFAULT NULL,
  `DATE30` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=547;

/*Table structure for table `refinance_test` */

DROP TABLE IF EXISTS `refinance_test`;

CREATE TABLE `refinance_test` (
  `RefID` int(20) NOT NULL AUTO_INCREMENT,
  `Refinance_agency` varchar(20) DEFAULT NULL,
  `Scheme` varchar(30) DEFAULT NULL,
  `Refi_date` date DEFAULT NULL,
  `Interest` decimal(20,2) DEFAULT NULL,
  `Amount` decimal(20,2) DEFAULT 0.00,
  `First_installment` date DEFAULT NULL,
  `Payment_cycle` varchar(20) DEFAULT NULL,
  `No_installments` int(20) DEFAULT NULL,
  PRIMARY KEY (`RefID`)
) ENGINE=MyISAM AUTO_INCREMENT=548 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci AVG_ROW_LENGTH=64;

/*Table structure for table `temp_flag3_dates` */

DROP TABLE IF EXISTS `temp_flag3_dates`;

CREATE TABLE `temp_flag3_dates` (
  `REFID` varchar(10) DEFAULT NULL,
  `INST_DATE` date DEFAULT NULL,
  `INST_AMT` decimal(20,2) DEFAULT NULL,
  `NET_OS` decimal(20,2) DEFAULT NULL,
  `INST_NUM` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `temp_generate_dates` */

DROP TABLE IF EXISTS `temp_generate_dates`;

CREATE TABLE `temp_generate_dates` (
  `REFID` varchar(10) DEFAULT NULL,
  `INST_DATE` date DEFAULT NULL,
  `INST_AMT` decimal(20,2) DEFAULT NULL,
  `NET_OS` decimal(20,2) DEFAULT NULL,
  `INST_NUM` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Table structure for table `tempforoutstanding` */

DROP TABLE IF EXISTS `tempforoutstanding`;

CREATE TABLE `tempforoutstanding` (
  `Refinance_agency` varchar(100) NOT NULL,
  `Scheme` varchar(100) NOT NULL,
  `Interest` decimal(5,0) NOT NULL,
  `RefID` int(5) NOT NULL,
  `TotalDue` decimal(50,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/* Procedure structure for procedure `CALCULATE_INTRST_INSERT` */

/*!50003 DROP PROCEDURE IF EXISTS  `CALCULATE_INTRST_INSERT` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `CALCULATE_INTRST_INSERT`(IN REFINANCE_ID int(5))
PROC_LABEL:
  BEGIN

    DECLARE I int;
    DECLARE DONE int;
    DECLARE CREF_AGENCY varchar(100);
    DECLARE CSCHEME varchar(100);
    DECLARE CREFI_DATE date;
    DECLARE CINTEREST decimal(20, 2);
    DECLARE CAMOUNT decimal(20, 2);
    DECLARE CFIRST_INSTALLMENT date;
    DECLARE CPAYMENT_CYCLE int(5);
    DECLARE CNO_INSTALLMENTS int(5);
    DECLARE LASTPRINCIPLEPAYDATE date;
    DECLARE CDIFFDAYS int(5);
    DECLARE CDAILYDATES date;
    DECLARE CINST_AMT decimal(20, 2);
    DECLARE COUTSTANDING decimal(20, 2);
    DECLARE PREV_DATE date;
    DECLARE PREV_INSTAMT decimal(20, 2);
    DECLARE PREV_OUTSTANDING decimal(20, 2);
    DECLARE CURR_DATE date;
    DECLARE CURR_INSTAMT decimal(20, 2);
    DECLARE CURR_OUTSTANDING decimal(20, 2);

    DECLARE CLOSING_DATE date;

    DECLARE FIRST_INSTALLMENT date;

    DECLARE LAST_DATE date;

    DECLARE FIRST_DATE date;

    DECLARE CGRAND_INT_AMT decimal(20, 2);

    DECLARE TEMPCOUNT int(5);
    DECLARE TEMPINTERESTCOUNT int(5);
    DECLARE LOOPCOUNT int(5);
    DECLARE WHILELOOPCOUNT int(5);

    DECLARE TEMPREFIDATE date;

    DECLARE TEMPOUTSTANDING decimal(20, 2);

    DECLARE UPDATE_CURSOR CURSOR FOR
    SELECT
      DAILYDATE,
      outstanding
    FROM interest_testing
    WHERE RefID = REFINANCE_ID
    ORDER BY dailydate;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET DONE = 1;

    SELECT
      REFINANCE_AGENCY,
      SCHEME,
      REFI_DATE,
      INTEREST,
      AMOUNT,
      FIRST_INSTALLMENT,
      PAYMENT_CYCLE,
      NO_INSTALLMENTS INTO CREF_AGENCY,
    CSCHEME,
    CREFI_DATE,
    CINTEREST,
    CAMOUNT,
    CFIRST_INSTALLMENT,
    CPAYMENT_CYCLE,
    CNO_INSTALLMENTS
    FROM REFINANCE_TEST
    WHERE REFID = REFINANCE_ID;


    SELECT
      MAX(Inst_date) INTO LAST_DATE
    FROM inst_table
    WHERE REFID = REFINANCE_ID;

    SELECT
      MAX(inst_date) INTO FIRST_DATE
    FROM inst_table
    WHERE REFID = REFINANCE_ID;

    SET FIRST_INSTALLMENT = FIRST_DATE;

    SET TEMPREFIDATE = CREFI_DATE;

    SET CLOSING_DATE = LAST_DATE;

    DROP TABLE IF EXISTS interest_testing;

    CREATE TABLE interest_testing (
      RefID int(20) NOT NULL,
      Refinance_agency varchar(20) DEFAULT NULL,
      Scheme varchar(30) DEFAULT NULL,
      Interest decimal(20, 2) NOT NULL,
      dailydate date DEFAULT NULL,
      outstanding decimal(20, 2) DEFAULT NULL,
      Intrest_Amount decimal(20, 2) DEFAULT NULL,
      Installment_No int(20) DEFAULT NULL,
      IntrestPeriod int(20) NOT NULL
    );

    -- TRUNCATE TABLE interest_testing;

    WHILE TEMPREFIDATE <= CLOSING_DATE DO

      INSERT INTO interest_testing (RefID, Refinance_agency, Scheme, Interest, dailydate)
        SELECT
          REFINANCE_ID,
          CREF_AGENCY,
          CSCHEME,
          CINTEREST,
          TEMPREFIDATE;

      SET TEMPREFIDATE = DATE_ADD(TEMPREFIDATE, INTERVAL 1 DAY);
    END WHILE;

    -- UPDATES OUTSTANDING BEFORE FIRST INSTALLMENT DATE

    UPDATE interest_testing test, refinance_test rt
    SET test.outstanding = rt.Amount
    WHERE test.RefID = rt.RefID
    AND test.dailydate <= rt.First_installment;

    -- UPDATES OUTSTANDING JOINING INSTALLMENT TABLE

    UPDATE interest_testing it, inst_table it1
    SET it.outstanding = it1.outstanding
    WHERE it.RefID = it1.RefID
    AND it.dailydate = it1.Inst_date;

    -- CURSOR STARTS INSERTS OUTSTANDING
    OPEN UPDATE_CURSOR;
  L1:
    LOOP
      FETCH UPDATE_CURSOR INTO CDAILYDATES, COUTSTANDING;
      IF DONE = 1 THEN
        LEAVE L1;
      END IF;
      IF (COUTSTANDING IS NOT NULL) THEN

        SET TEMPOUTSTANDING = COUTSTANDING;

      END IF;

      IF COUTSTANDING IS NULL THEN

        UPDATE interest_testing test
        SET test.outstanding = TEMPOUTSTANDING
        WHERE test.dailydate = CDAILYDATES;

      END IF;

    END LOOP L1;
    CLOSE UPDATE_CURSOR;

    UPDATE interest_testing
    SET INTREST_AMOUNT = (INTEREST * OUTSTANDING / 36500);

    INSERT INTO refinance_interest_daywise
      SELECT
        *
      FROM interest_testing;

  END */$$
DELIMITER ;

/* Procedure structure for procedure `GENERATE_DATES` */

/*!50003 DROP PROCEDURE IF EXISTS  `GENERATE_DATES` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `GENERATE_DATES`(IN REFINANCE_ID int(5), IN FLAG int(5))
PROC_LABEL:
  BEGIN

    DECLARE I int;
    DECLARE DONE int;
    DECLARE CREF_AGENCY varchar(100);
    DECLARE CSCHEME varchar(100);
    DECLARE CREFI_DATE date;
    DECLARE CINTEREST decimal(20, 2);
    DECLARE CAMOUNT decimal(20, 2);
    DECLARE CFIRST_INSTALLMENT date;
    DECLARE CPAYMENT_CYCLE int(5);
    DECLARE CNO_INSTALLMENTS int(5);

    DECLARE GINST_DATE date;
    DECLARE GINST_NUM int(5);
    DECLARE GINST_AMT decimal(20, 2);
    DECLARE GNET_OS decimal(20, 2);

    DECLARE TEMPREFIDATE date;

    DECLARE TEMPOUTSTANDING decimal(20, 2);

    DECLARE UPDATE_CURSOR CURSOR FOR
    SELECT
      INST_DATE,
      INST_AMT,
      NET_OS
    FROM temp_generate_dates
    ORDER BY INST_DATE;

    DECLARE UPDATE_CURSOR1 CURSOR FOR
    SELECT
      INST_DATE,
      INST_AMT,
      NET_OS,
      INST_NUM
    FROM temp_FLAG3_dates
    ORDER BY INST_DATE;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET DONE = 1;

    SELECT
      REFINANCE_AGENCY,
      SCHEME,
      REFI_DATE,
      INTEREST,
      AMOUNT,
      FIRST_INSTALLMENT,
      PAYMENT_CYCLE,
      NO_INSTALLMENTS INTO CREF_AGENCY,
    CSCHEME,
    CREFI_DATE,
    CINTEREST,
    CAMOUNT,
    CFIRST_INSTALLMENT,
    CPAYMENT_CYCLE,
    CNO_INSTALLMENTS
    FROM REFINANCE_TEST
    WHERE REFID = REFINANCE_ID;

    SET I = 1;

    SET TEMPREFIDATE = CFIRST_INSTALLMENT;

    SET TEMPOUTSTANDING = CAMOUNT;

    IF FLAG = 1 THEN

      --         DROP TABLE IF EXISTS temp_generate_dates;
      --             
      --         CREATE TABLE temp_generate_dates(
      --             REFID varchar(10) DEFAULT NULL,
      --             INST_DATE date DEFAULT NULL,
      --             INST_AMT decimal(20, 2) DEFAULT NULL,
      --             NET_OS decimal(20, 2) DEFAULT NULL,
      --             INST_NUM int(5) DEFAULT NULL
      --         );

      DROP TABLE IF EXISTS TEMP_GENERATE_DATES;

      CREATE TABLE TEMP_GENERATE_DATES (
        REFID varchar(10),
        INST_DATE date,
        INST_AMT decimal(20, 2),
        NET_OS decimal(20, 2),
        INST_NUM int(5)
      );

      WHILE I <= CNO_INSTALLMENTS DO

        SET TEMPOUTSTANDING = TEMPOUTSTANDING - (CAMOUNT / CNO_INSTALLMENTS);

        INSERT INTO TEMP_GENERATE_DATES (REFID, INST_DATE, INST_AMT, NET_OS, INST_NUM)
          SELECT
            REFINANCE_ID,
            TEMPREFIDATE,
            (CAMOUNT / CNO_INSTALLMENTS),
            TEMPOUTSTANDING,
            I;

        SET TEMPREFIDATE = DATE_ADD(TEMPREFIDATE, INTERVAL CPAYMENT_CYCLE MONTH);
        SET I = I + 1;

      END WHILE;

    ELSEIF FLAG = 2 THEN

      -- CURSOR STARTS INSERTS OUTSTANDING
      OPEN UPDATE_CURSOR;
    L1:
      LOOP
        FETCH UPDATE_CURSOR INTO GINST_DATE, GINST_AMT, GNET_OS;
        IF DONE = 1 THEN
          LEAVE L1;
        END IF;

        SET TEMPOUTSTANDING = TEMPOUTSTANDING - GINST_AMT;

        UPDATE temp_generate_dates
        SET NET_OS = TEMPOUTSTANDING
        WHERE INST_DATE = GINST_DATE;

      END LOOP L1;
      CLOSE UPDATE_CURSOR;

      INSERT INTO INST_TABLE
        SELECT
          REFID,
          CREF_AGENCY,
          CSCHEME,
          CAMOUNT,
          CINTEREST,
          INST_DATE,
          INST_AMT,
          INST_NUM,
          NET_OS
        FROM TEMP_GENERATE_DATES
        ORDER BY INST_DATE;
      COMMIT;

      CALL CALCULATE_INTRST_INSERT(REFINANCE_ID);

    ELSEIF FLAG = 3 THEN

      DELETE
        FROM INST_TABLE
      WHERE REFID = REFINANCE_ID;

      -- CURSOR STARTS INSERTS OUTSTANDING
      OPEN UPDATE_CURSOR1;
    L1:
      LOOP
        FETCH UPDATE_CURSOR1 INTO GINST_DATE, GINST_AMT, GNET_OS, GINST_NUM;
        IF DONE = 1 THEN
          LEAVE L1;
        END IF;

        SET TEMPOUTSTANDING = TEMPOUTSTANDING - GINST_AMT;

        UPDATE temp_flag3_dates
        SET NET_OS = TEMPOUTSTANDING
        WHERE REFID = REFINANCE_ID
        AND INST_NUM = GINST_NUM;

      END LOOP L1;
      CLOSE UPDATE_CURSOR1;

      INSERT INTO INST_TABLE
        SELECT
          REFID,
          CREF_AGENCY,
          CSCHEME,
          CAMOUNT,
          CINTEREST,
          INST_DATE,
          INST_AMT,
          INST_NUM,
          NET_OS
        FROM temp_flag3_dates
        ORDER BY INST_DATE;
      COMMIT;

      DELETE
        FROM REFINANCE_INTEREST_DAYWISE
      WHERE REFID = REFINANCE_ID;

      CALL CALCULATE_INTRST_INSERT(REFINANCE_ID);

    END IF;

  END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
