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

/*Data for the table `alm_appendix1_model` */

insert  into `alm_appendix1_model`(`OrderNo`,`op_mode`,`Category`,`sub_Category`,`Comments`,`DisplayOrder`,`ar1_mapping`) values (1,'Outflows','Capital','Capital\r','As on Year End',1,'\'SHARE_CAPITAL\',\'SHARE_CAPITAL_DEPOSITS\''),(2,'Outflows','Reserves and Surplus','Reserves and Surplus\r','As on Year End',2,'\'STATUTORY_RESERVES\',\'CAPITAL_RESERVES\',\'REVENUE_OTHER_RESERVES\',\'PROFIT_LOSS\',\'PROFIT_LOSS_CURRENT_YEAR\''),(3,'Outflows','Deposits','Deposits\r','Total=3.1+3.2+3.3+3.4',3,NULL),(3.1,'Outflows','Deposits','Current Deposits 1\r','15% - 1 to 14 days\r\n85% - 1 to 3 years\r\n',4,'\'CURRENT_ACCOUNT\',\'CREDIT_BAL_CCOD\''),(3.2,'Outflows','Deposits','Savings Bank 1\r','10% - 1 to 14 days\r\n90% - 1 to 3 years\r\n',5,'\'SAVINGS_BANK\''),(3.3,'Outflows','Deposits','Term Deposits\r','Residual Maturities - trmm0403 Monthend Unsplit Report',6,NULL),(3.4,'Outflows','Deposits','Certificate of Deposit\r','NA',7,NULL),(4,'Outflows','Borrowings','Borrowings\r','Total=4.1+4.2+4.3+4.4',8,NULL),(4.1,'Outflows','Borrowings','Call and Short Notice\r','NA',9,NULL),(4.2,'Outflows','Borrowings','Inter-bank (Term)\r','NA',10,NULL),(4.3,'Outflows','Borrowings','Refinances\r','Refinance Tool',11,'\'SBI_REFINANCE\',\'NABARD_REFINANCE\',\'MUDRA_REFINANCE\',\'NHB_REFINANCE\',\'NSFDC_REFINANCE\',\'NSKFDC_REFINANCE\',\'NBCFDC_REFINANCE\',\'NSTFDC_REFINANCE\''),(4.4,'Outflows','Borrowings','Others_Refinances\r','Refinance Tool',12,'\'BORROWING_OTHER_BANKS\''),(5,'Outflows','Other Liabilities and Provisions','Other Liabilities and Provisions\r','Total=5.1+5.2+5.3+5.4',13,NULL),(5.1,'Outflows','Other Liabilities and Provisions','Bills Payable5.1\r','TRB',14,'\'DRAFTS_BTW_CORE\',\'BANKERS_CHEQUE\''),(5.2,'Outflows','Other Liabilities and Provisions','Branch Adjustments5.2\r','TRB',15,NULL),(5.3,'Outflows','Other Liabilities and Provisions','Provisions5.3\r','TRB',16,'\'PROVISION_STD_ASSETS\''),(5.4,'Outflows','Other Liabilities and Provisions','Others_provision5.4\r','TRB',17,NULL),(6,'Outflows','Lines of Credit Committed to','Lines of Credit Committed to\r','NA',18,NULL),(6.1,'Outflows','Lines of Credit Committed to','Institutions\r','NA',19,NULL),(6.2,'Outflows','Lines of Credit Committed to','Customers\r','NA',20,NULL),(7,'Outflows','Unavailed Protion of Cash Credit/ Overdraft/ Demand Loan Component of Working Capital','Unavailed Protion of Cash Credit/ Overdraft/ Demand Loan Component of Working Capital\r','NA',21,NULL),(8,'Outflows','Letters of Credit/ Guarantees','Letters of Credit/ Guarantees\r','NA',22,NULL),(9,'Outflows','Repos','Repos\r','NA',23,NULL),(10,'Outflows','Bills Rediscounted (DUPN)_repos','Bills Rediscounted (DUPN)_repos\r','NA',24,NULL),(11,'Outflows','Interest Payable','Interest Payable\r','TRB',25,NULL),(12,'Outflows','Others_Interest Payable','Others_Interest Payable\r','TRB',26,NULL),(1,'Inflows','Cash','Cash\r','TRB',28,NULL),(2,'Inflows','Balances with RBI','Balances with RBI\r','TRB',29,NULL),(3,'Inflows','Balances with Other Banks','Balances with Other Banks\r','TRB',30,NULL),(3.1,'Inflows','Balances with Other Banks','Current Account\r','TRB',31,NULL),(3.2,'Inflows','Balances with Other Banks','Money at Call and Short Notice','TRB',32,NULL),(4,'Inflows','Investments (including those under Repos but excluding Reverse Repos)','Investments (including those under Repos but excluding Reverse Repos)\r','ALM_SLR+BOND+MF',33,NULL),(5,'Inflows','Advances (Performing)','Advances (Performing)\r','MIS.NPA_MONTHEND',34,NULL),(5.1,'Inflows','Advances (Performing)','Bills Purchased and Discounted (including bills under DUPN)\r','NA',35,NULL),(5.2,'Inflows','Advances (Performing)','Cash Credits, Overdrafts and Loans repayable on demand','MIS.NPA_MONTHEND',36,NULL),(5.3,'Inflows','Advances (Performing)','Term Loans\r','TRMM0401',37,NULL),(6,'Inflows','NPAs (Advances and Investments) 2','NPAs (Advances and Investments) 2\r','',38,NULL),(7,'Inflows','Fixed Assets','Fixed Assets\r','',39,NULL),(8,'Inflows','Other Assets','Other Assets\r','',40,NULL),(8.1,'Inflows','Other Assets','Branch Adjustments8.1\r','',41,NULL),(8.2,'Inflows','Other Assets','Leased Assets8.2\r','NA',42,NULL),(8.3,'Inflows','Other Assets','Others-Leased Assets8.3\r','NA',43,NULL),(9,'Inflows','Reverse Repos','Reverse Repos\r','NA',44,NULL),(10,'Inflows','Bills Rediscounted (DUPN)_reverserepo','Bills Rediscounted (DUPN)_reverserepo\r','NA',45,NULL),(11,'Inflows','Interest Receivable','Interest Receivable\r','',46,NULL),(12,'Inflows','Committed Lines of Credit','Committed Lines of Credit\r','NA',47,NULL),(13,'Inflows','Others-cumlines of credit','Others-cumlines of credit\r','NA',48,NULL),(101,'Total','Total Outflows','Total Outflows - A\r','',27,NULL),(102,'Total','Total Inflows','Total Inflows - B\r','',49,NULL),(103,'Total','Mismatch (B-A)','Mismatch (B-A) - C\r','',50,NULL),(104,'Total','Cumulative Mismatch','Cumulative Mismatch\r','',51,NULL),(105,'Total','C as % to A','C as % to A\r','',52,NULL);

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

/*Data for the table `cgllist` */

insert  into `cgllist`(`CGL_ACC_NO`,`ACC_TYPE`,`LEVEL3`,`LEVEL2`,`LEVEL1`,`LEVEL1ID`,`LEVEL2ID`,`LEVEL3ID`,`LEVEL4ID`,`EntryId`,`EntryDate`,`prod_desc_cat1`) values ('1000505003','DM SUSPENSE ACCOUNT','MIGRATION SUSPENSE ACCOUNT','INTER OFFICE ACCOUNTS','ASSETS',2,9,4,25,647,'0000-00-00',NULL)

;

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

/*Data for the table `crystal_mapping` */

insert  into `crystal_mapping`(`GL_ACCT`,`GL_ACCTNAME`,`GL_GROUPNAME_ACCT`,`GL_GROUPNAME`,`GL_GROUPNAME_OUT`,`GL_MAINGROUP`,`GL_NATURE`) values ('2029505009','CURRENT A/C OVERDRAFT','','1005_CURRENT A/C WITH SBI COMM','1001_CASH BALANCES','1000_ASSETS','FLOAT')

;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
