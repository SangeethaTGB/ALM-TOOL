TELANGANA GRAMEENA BANK
ASSET & LIABILITY MANAGEMENT TOOL
STANDARD OPERATING PROCEDURE
I.	Objective:
To assess and generate Bank’s Inflows and Outflows as per the guidelines / format of NABARD Return - Appendix-I - Statement of Structural Liquidity.

II.	Inputs Required
1.	Daily Unsplit Reports by C-Edge:
a.	Trail Balance (TRIAL_BALANCE_REPORT.prt)
b.	CCOD / Loan Balance Files (depd0580.prt & lond2390.prt)
c.	Residual Maturities of Deposits (trmm0403.prt)
2.	Investment Particulars (Entry-wise):
a.	Bonds
b.	SLR
c.	Mutual Funds
d.	TDRs
3.	Mandatory Balances to be maintained with Other Banks as Current Accounts
4.	Refinances(Entry-wise)

III.	Schema:
Databases required: investments, refinance.
Tables (structure only) – Refer file - investments_structure.sql and refinance_structure.sql. 

IV.	Pre-Requisites:
a.	Ensure all CGLs of Trial Balance are mapped either with cgl_AR1_mapping table or cgl_AR2_mapping table.
b.	All CGLs are to be mapped as per Crystal Mapping.
c.	Ensure all Investment Particulars are up-to-date.
d.	Ensure all Refinances Particulars are up-to-date.
e.	Ensure Current Account details are up-to-date.


V.	Modules:
1.	Data Loading:
a.	ALM -> Load Data – Admin page
b.	Preprocess the daily reports as per the Schema mentioned below:
Report Name	Load into Table	Remarks
TRIAL_BALANCE_REPORT.prt	dailyweekly	RUN_DATE - AsonDate
depd0580.prt & lond2390.prt	npa	RUN_DATE - AsonDate
trmm0403.prt	Direct upload and value extraction	

c.	Select trmm0403.prt file and click Load Data
d.	Wait for response and then click Bulk Update 
e.	Data loaded successfully.

2.	Record Maintenance – Investments, Current A/Cs & Refinances
a.	Bond – Add / Edit / Delete 
b.	SLR – Add / Edit / Delete
c.	Mutual Funds – Add / Edit / Delete
d.	TDRs – Add / Edit / Delete
e.	Refinances– Add / Edit / Delete

3.	Trend Analysis:
a.	View Bank’s Assets & Liabilities statement as on any date.
b.	Trend of Parameter-wise Time Band-wise
 

VI.	Code Changes to be done:
a.	Change the file includes path information.
b.	Check DB connection code in all pages.
c.	Change all DB connections with different IPs to localhost.
d.	Create file:DBConnect.php as below:
<?php
$conn=mysqli_connect('localhost','root','');
?>
e.	Find in files: 
include $_SERVER['DOCUMENT_ROOT'] . '\mis\DBConnect.php'; 
And Replace with: 
include 'DBConnect.php';
f.	Comment the below File Include (as it pertains to Login & user authentication):
include $_SERVER['DOCUMENT_ROOT'] . '\mis\DepNoCSS.php'; 


VII.	Software required:
Any Latest compatible versions of WAMP / XAMPP 
(or)
Apache2.4
PHP 8.1 
MYSQL/MARIA DB 10.4


Contact:
D. Sangeetha, Senior Manager (IT) – 9491041965
M Praveen Kumar, Manager (IT) – 7901617565
Gunda Naresh, Senior Manager (INVESTMENT) – 7901617540

****

