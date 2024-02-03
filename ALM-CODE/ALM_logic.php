<!-- <script type="text/javascript">alert("1");</script> -->
<?php 
// $asondate="2022-06-30";
// $dailyweeklyTbl = "mis.dailyweekly";
// $npaTbl = "mis.npa";
error_reporting(1);


// include __DIR__ . '/commoncssjs/includes/config.php';


// $conn = new mysqli("10.88.1.222","root","","investments");
$conn112 = new mysqli("10.88.1.112","root","","");


$sql="truncate investments.dailyweeklyTbl";
$stt = $conn->prepare($sql);
$stt->execute();

$sql="insert into investments.dailyweeklyTbl 
       select * from  $dailyweeklyTbl d";
$stt = $conn->prepare($sql);
$stt->execute();


$chkMonthEnd=0;
$monthEnd=date("Y-m-t",strtotime($asondate));
// if ($monthEnd == $asondate) 
// {
//        $chkMonthEnd=1;
//        include 'fetchFromBSTool112.php';       

//        $sql="insert into investments.dailyweeklyTbl (cgl_acc_no,balance) 
//        select gl_acct,manual_bal from  investments.cgl_add_ded";
//        $stt = $conn->prepare($sql);
//        $stt->execute();
// }


$dailyweeklyTbl = "investments.dailyweeklyTbl";

$sql="delete from  investments.alm_appendix1_maturity_profile_liquidity where asondate='$asondate' ";
$stt = $conn->prepare($sql);
$stt->execute();

$sql_ins="insert into investments.alm_appendix1_maturity_profile_liquidity(OrderNo, op_mode, Category,sub_Category,asondate,DisplayOrder) 
       select OrderNo, op_mode, Category, sub_Category,'$asondate',DisplayOrder 
       from investments.alm_appendix1_model 
       order by DisplayOrder";
$stt = $conn->prepare($sql_ins);
$stt->execute();

$sql="update investments.alm_appendix1_maturity_profile_liquidity a,investments.`alm_appendix1_model` am 
set RM_1D_to_14D=0,RM_15D_to_28D=0,RM_29D_to_3M=0, RM_3M_to_6M=0,RM_6M_to_1Y=0, RM_1Y_to_3Y=0, RM_3Y_to_5Y=0, RM_OVER_5Y=0, RM_TOTAL=0 
where asondate='$asondate' and a.displayorder=am.displayorder and am.Comments='NA' ";
$stt = $conn->prepare($sql);
$stt->execute();


?>


<?php

//-- 1   1 Capital
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
(SELECT SUM(ABS(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('SHARE_CAPITAL','SHARE_CAPITAL_DEPOSITS') ) b 
SET RM_OVER_5Y=b.bal, RM_TOTAL=b.bal WHERE DisplayOrder=1 AND asondate='$asondate' ";
$stt = $conn->prepare($sql);
$stt->execute();

// echo $sql;
// exit;


//-- 2   2 Reserves and Surplus
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
(SELECT SUM(ABS(d.balance)) bal 
FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('STATUTORY_RESERVES','CAPITAL_RESERVES','REVENUE_OTHER_RESERVES','PROFIT_LOSS','PROFIT_LOSS_CURRENT_YEAR') ) b 
SET RM_OVER_5Y=b.bal, RM_TOTAL=b.bal 
WHERE DisplayOrder=2 AND asondate='$asondate' ";
$stt = $conn->prepare($sql);
$stt->execute();

//-- 3 Deposits = 4 + 5 + 6 + 7
//-- 4   3.1    Current Deposits 1
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
( SELECT SUM(ABS(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('CURRENT_ACCOUNT','CREDIT_BAL_CCOD') ) b 
SET RM_1D_to_14D=b.bal*0.15,RM_1Y_to_3Y=b.bal*0.85, RM_TOTAL=b.bal WHERE DisplayOrder=4 AND asondate='$asondate'";
$stt = $conn->prepare($sql);
$stt->execute();

//-- 5   3.2    Savings Bank 1
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(ABS(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('SAVINGS_BANK') ) b  
 SET RM_1D_to_14D=b.bal*0.10,RM_1Y_to_3Y=b.bal*0.90, RM_TOTAL=b.bal WHERE DisplayOrder=5 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();
 
//-- 6   3.3    Term Deposits - upload Trmm0303.prt file

ini_set('upload_max_filesize','30M');
$uploaddir = 'D:/misdata/';

$attach_trmm0403=basename($_FILES["trmm0403"]["name"]);
if($attach_trmm0403){
$trmm0403_file=$uploaddir . $attach_trmm0403;
// unlink($trmm0403_file);
$res3=move_uploaded_file($_FILES["trmm0403"]["tmp_name"], $trmm0403_file);
$sql = "truncate investments.trmm0403";
$stt = $conn->prepare($sql);
$stt->execute();


$sql1 = "LOAD DATA INFILE 'D:/misdata/trmm0403.prt' 
              into table  investments.trmm0403 (@ROW) 
              SET    Particulars=TRIM(SUBSTR(@ROW,1,28)), 
                     RM_1D_to_14D=TRIM(SUBSTR(@ROW,28,20)), 
                     RM_15D_to_28D=TRIM(SUBSTR(@ROW,48,20)), 
                     RM_29D_to_3M=TRIM(SUBSTR(@ROW,68,20)), 
                     RM_3M_to_6M=TRIM(SUBSTR(@ROW,88,20)), 
                     RM_6M_to_1Y=TRIM(SUBSTR(@ROW,108,20)), 
                     RM_1Y_to_3Y=TRIM(SUBSTR(@ROW,128,20)), 
                     RM_3Y_to_5Y=TRIM(SUBSTR(@ROW,148,20)), 
                     RM_OVER_5Y=TRIM(SUBSTR(@ROW,168,20)), 
                     RM_TOTAL=TRIM(SUBSTR(@ROW,188,20)), 
                     AsonDate='$asondate'
              ";

$stt1 = $conn->query($sql1);

$sql = "delete from investments.trmm0403 where trim(Particulars) <> 'TOTAL' ";
$stt = $conn->prepare($sql);
$stt->execute();
}

$sql="update investments.alm_appendix1_maturity_profile_liquidity a, 
       (select sum(RM_1D_to_14D) as RM_1D_to_14D,sum(RM_15D_to_28D) as RM_15D_to_28D,sum(RM_29D_to_3M) as RM_29D_to_3M,sum(RM_3M_to_6M) as RM_3M_to_6M,sum(RM_6M_to_1Y) as RM_6M_to_1Y,sum(RM_1Y_to_3Y) as RM_1Y_to_3Y,sum(RM_3Y_to_5Y) as RM_3Y_to_5Y,sum(RM_OVER_5Y) as RM_OVER_5Y,sum(RM_TOTAL) as RM_TOTAL from investments.trmm0403 where asondate='$asondate') b 
       set    a.RM_1D_to_14D=b.RM_1D_to_14D,a.RM_15D_to_28D=b.RM_15D_to_28D,a.RM_29D_to_3M=b.RM_29D_to_3M,   a.RM_3M_to_6M=b.RM_3M_to_6M,a.RM_6M_to_1Y=b.RM_6M_to_1Y, a.RM_1Y_to_3Y=b.RM_1Y_to_3Y,    a.RM_3Y_to_5Y=b.RM_3Y_to_5Y,    a.RM_OVER_5Y=b.RM_OVER_5Y,    a.RM_TOTAL=b.RM_TOTAL 
       where DisplayOrder=6 and asondate='$asondate' ";
 $stt = $conn->prepare($sql);
 $stt->execute();
// echo $sql;
// exit;

//-- 7   3.4    Certificate of Deposit      -      NA







//-- 8   4      Borrowings    =      9 + 10 + 11 + 12
//-- 9   4.1    Call and Short Notice       -      NA
//-- 10  4.2    Inter-bank (Term)    -      NA

//-- 11  4.3    Refinances - only total
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(ABS(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('SBI_REFINANCE','NABARD_REFINANCE','MUDRA_REFINANCE','NHB_REFINANCE','NSFDC_REFINANCE','NSKFDC_REFINANCE','NBCFDC_REFINANCE','NSTFDC_REFINANCE') ) b 
 SET RM_TOTAL=b.bal WHERE DisplayOrder=11 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//Outflows - Refinances - 4.3 - except tot (daily_weekly)
$qry="select sum(c.outstanding),classification from (select t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,max(r.inst_date),'$asondate',
       datediff(max(r.inst_date),'$asondate') as 'days',
       case when (datediff(max(r.inst_date),'$asondate')>0 and datediff(max(r.inst_date),'$asondate')<=14) then '1'
            when (datediff(max(r.inst_date),'$asondate')>14 and datediff(max(r.inst_date),'$asondate')<=28) then '2' 
            when (datediff(max(r.inst_date),'$asondate')>28 and datediff(max(r.inst_date),'$asondate')<=90) then '3' 
            when (datediff(max(r.inst_date),'$asondate')>90 and datediff(max(r.inst_date),'$asondate')<=180) then '4' 
            when (datediff(max(r.inst_date),'$asondate')>180 and datediff(max(r.inst_date),'$asondate')<=365) then '5' 
            when (datediff(max(r.inst_date),'$asondate')>365 and datediff(max(r.inst_date),'$asondate')<=1095) then '6' 
            when (datediff(max(r.inst_date),'$asondate')>1095 and datediff(max(r.inst_date),'$asondate')<=1825) then '7' 
            when (datediff(max(r.inst_date),'$asondate')>1825 ) then '8' 
       else 0 end as classification  from 
       (SELECT a.Refinance_agency,a.Scheme,a.Interest,a.RefID,a.Inst_amt+a.outStanding as outStanding FROM refinance.inst_table a, 
       (SELECT min( Inst_date ) mindate,`RefID` rid FROM refinance.inst_table  WHERE Inst_date >= '$asondate' GROUP BY RefID)
        b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid) t, refinance.inst_table r where t.RefId=r.RefId  group by refId) c group by classification";
//echo $qry;
$res=mysqli_query($conn112,$qry);
$cnt=0;
$totOs=0;
while ($row=mysqli_fetch_row($res))
    {
    $period[$row[1]]=$row[0];
    $totOs+=$row[0];
    $cnt++;
    }
$sql="update investments.alm_appendix1_maturity_profile_liquidity  
              set    RM_1D_to_14D='$period[1]', 
                     RM_15D_to_28D='$period[2]', 
                     RM_29D_to_3M='$period[3]',
                     RM_3M_to_6M='$period[4]', 
                     RM_6M_to_1Y='$period[5]', 
                     RM_1Y_to_3Y='$period[6]', 
                     RM_3Y_to_5Y='$period[7]',
                     RM_OVER_5Y='$period[8]' 
              where DisplayOrder=11 and asondate='$asondate' ";
 $stt = $conn->prepare($sql);
 $stt->execute();


//-- 12  4.4    Others_Refinances
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(ABS(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('BORROWING_OTHER_BANKS') ) b 
 SET RM_1D_to_14D=b.bal, RM_TOTAL=b.bal WHERE DisplayOrder=12 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();







//-- 13  5      Other Liabilities and Provisions

//-- 14  5.1    Bills Payable5.1
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT abs(SUM(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('DRAFTS_BTW_CORE','BANKERS_CHEQUE') ) b 
 SET RM_1D_to_14D=b.bal,RM_TOTAL=b.bal WHERE DisplayOrder=14 AND asondate='$asondate'";

// UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
// (SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, investments.dailyweekly_30062022 d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('DRAFTS_BTW_CORE','BANKERS_CHEQUE') ) b 
//  SET RM_TOTAL=b.bal WHERE DisplayOrder=14 AND asondate='2022-06-30';

 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 15  5.2    Branch Adjustments5.2
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(
SELECT aa.bal bal_aa, bb.bal bal_bb, abs(aa.bal+bb.bal) bal FROM   
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('BCGA_AC') ) aa, 
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('IBIT_AC','CORE_INTER_BRANCH_AC') ) bb
) b
SET RM_1D_to_14D=IF(b.bal_aa>b.bal_bb,b.bal,0), RM_TOTAL=IF(b.bal_aa>b.bal_bb,b.bal,0) WHERE DisplayOrder=15 AND asondate='$asondate'";
$stt = $conn->prepare($sql);
$stt->execute();

//-- 16  5.3    Provisions5.3
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(ABS(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('PROVISION_STD_ASSETS') ) b 
 SET RM_1D_to_14D=b.bal, RM_TOTAL=b.bal WHERE DisplayOrder=16 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 17  5.4    Others_provision5.4
 // -- fetch DEFERED_TAX_LIABILITY from 112 - manual entry
 $DEFERED_TAX_LIABILITY_112=0;
// if($chkMonthEnd)
// {
//  $sql = "SELECT AMT from balancesheet_2022_23_jun.manual_entries where SCHEME='ADD_DEFERED_TAX'";
//  $res = mysqli_query($conn112,$sql);
//  $row = mysqli_fetch_row($res);
//  $DEFERED_TAX_LIABILITY_112=$row[0];
// }


$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
       ( 
       SELECT ABS(c.bal+d.bal+e.bal+f.bal+$DEFERED_TAX_LIABILITY_112) bal 
       FROM 
              ( 
              SELECT aa.bal bal_aa, bb.bal bal_bb, IF(bb.bal < aa.bal,ABS(bb.bal-aa.bal),0) bal 
              FROM 
                     (
                     SELECT ABS(SUM(d.balance)) bal 
                     FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
                     WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('PROVISION_INCOME_TAX') 
                     ) aa, 
                     (
                     SELECT ABS(SUM(d.balance)) bal 
                     FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
                     WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('ADV_TAX','TDS') 
                     ) bb 
              ) e, 
              ( 
              SELECT (xx.bal+yy.bal) bal 
              FROM 
                     (
                     SELECT ABS(SUM(d.balance)) bal 
                     FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
                     WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('PROVISION_STATUTORY_AUDITORS', 'PROVISION_FRAUDS', 'OTHER_PROVISIONS', 'PROVISION_INVESTMENT', 'PROVISION_LEAVE_ENCASHMENT', 'PROVISION_GRATUITY', 
'CROP_INSURANCE', 'LINK_BANK_TRANSFERS', 'SUSPENSE_5_SCH', 'APPRISAL_CHARGES', 'RENT_POS', 'PMJJBY_PMSBY', 'SALARY_ADMIN', 'BLOCKED_ACCOUNT', 
'SUNDRY_DEPOSIT', 'SUBSIDY_RESERVE_FUND', 'SUNDRY_TDS_DEPOIST', 'DEFERED_TAX_LIABILITY', 'CGST_IGST_SGST', 'GM_OD_AC', 
'AADHAR_ENROLLMENT_SETTLEMENT', 'INCOME_TAX_PROFESSIONAL_TAX','PREPAID_INCOME','PROVISION_BD_AC')
                     ) xx, 
                     (
                     SELECT SUM(aaa.balance) bal 
                     FROM 
                            (
                            SELECT (CASE WHEN SUM(d.balance) <0 THEN SUM(d.balance) ELSE SUM(0) END)  AS 'balance' 
                            FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
                            WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping LIKE '%suspense%'  
                            GROUP BY c.cgl HAVING balance <0
                            ) aaa 
                     ) yy 
              ) c, 
              ( 
              SELECT IF(SUM(d.balance) IS NULL,0,SUM(d.balance)) bal 
              FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
              WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('PROVISION_PENSION_NPS') 
              ) d,
              (
              SELECT SUM(ABS(d.balance)) bal 
              FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
              WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('INT_ACCRUED_SCH5') 
              ) f 
       ) b 
       SET RM_1D_to_14D=b.bal, RM_TOTAL=b.bal 
       WHERE DisplayOrder=17 AND asondate='$asondate' ";

// echo $sql;
$stt = $conn->prepare($sql);
$stt->execute();









//-- 18  6      Lines of Credit Committed to       -      6.1 + 6.2
//-- 19  6.1    Institutions  -      NA
//-- 20  6.2    Customers     -      NA






//-- 21  7      Unavailed Protion of Cash Credit/ Overdraft/ Demand Loan Component of Working Capital      -      NA
//-- 22  8      Letters of Credit/ Guarantees      - NA
//-- 23  9      Repos  -      NA
//-- 24  10     Bills Rediscounted (DUPN)_repos    -      NA

//-- 25  11     Interest Payable     --     Execute in 112 and fetch to $row[0] and update
$sql = "SELECT SUM(c.intr_pbl) 
FROM (SELECT t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,MAX(r.inst_date),'$asondate',
DATEDIFF(MAX(r.inst_date),'$asondate') AS 'days',((t.Interest/36500)*DATEDIFF(MAX(r.inst_date),'$asondate')*t.outStanding) intr_pbl
FROM 
(SELECT a.Refinance_agency,a.Scheme,a.Interest,a.RefID,a.Inst_amt+a.outStanding AS outStanding FROM refinance.inst_table a, 
(SELECT MIN( Inst_date ) mindate,`RefID` rid FROM refinance.inst_table  WHERE Inst_date >= '$asondate' GROUP BY RefID)
b WHERE a.`Inst_date` = b.mindate AND a.`RefID` = b.rid) t, refinance.inst_table r WHERE t.RefId=r.RefId AND t.Refinance_agency='NABARD' GROUP BY refId) c";
$stt = $conn112->prepare($sql);
$row = $stt->execute(); 

//-- Update 111
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity  
SET RM_1D_to_14D='$row[0]', RM_TOTAL='$row[0]' WHERE asondate='$asondate' AND DisplayOrder=25 ";
$stt = $conn->prepare($sql);
$stt->execute();


//-- 26  12     Others_Interest Payable     --     Execute in 112 and fetch to $row[0] and update
$sql = "SELECT SUM(c.intr_pbl) 
FROM (SELECT t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,MAX(r.inst_date),'$asondate',
DATEDIFF(MAX(r.inst_date),'$asondate') AS 'days',((t.Interest/36500)*DATEDIFF(MAX(r.inst_date),'$asondate')*t.outStanding) intr_pbl
FROM 
(SELECT a.Refinance_agency,a.Scheme,a.Interest,a.RefID,a.Inst_amt+a.outStanding AS outStanding FROM refinance.inst_table a, 
(SELECT MIN( Inst_date ) mindate,`RefID` rid FROM refinance.inst_table  WHERE Inst_date >= '$asondate' GROUP BY RefID)
b WHERE a.`Inst_date` = b.mindate AND a.`RefID` = b.rid) t, refinance.inst_table r WHERE t.RefId=r.RefId AND t.Refinance_agency<>'NABARD' GROUP BY refId) c";
$stt = $conn112->prepare($sql);
$row = $stt->execute(); 

//-- Update 111
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity  
SET RM_1D_to_14D='$row[0]', RM_TOTAL='$row[0]' WHERE asondate='$asondate' AND DisplayOrder=26 ";
$stt = $conn->prepare($sql);
$stt->execute();

//-- 27  101    Total Outflows - A = 1 + 2 + 3 + 4 + 5 + 6 + 7 + 8 + 9 + 10 + 11 + 12


  




//-- -------------------------------------------------------------------------------------------
 
//-- INFLOWS

//-- 28  1      Cash
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('CASH_ON_HAND') ) b 
 SET RM_1D_to_14D=b.bal, RM_TOTAL=b.bal WHERE DisplayOrder=28 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 29  2      Balances with RBI
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('CASH_RBI') ) b 
 SET RM_1D_to_14D=b.bal, RM_TOTAL=b.bal WHERE DisplayOrder=29 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 30  3      Balances with Other Banks   =      3.1 + 3.2
//-- 31  3.1    Current Account
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d 
WHERE d.cgl_acc_no=c.cgl AND 
       (
       (c.ar1_mapping IN ('CA_LINK_BANK', 'BRANCH_CA_LINK_BANK', 'HO_CA_SBI_MERCHANT', 'HO_CA_ICICI',  'CA_AEPS', 'CA_NEFT_SBI', 'CA_RTGS_SBI', 'CA_IMPS_SBI', 'CA_UPI_SBI', 'CA_ATM_SBI', 'NPCI_ACH_CREDIT' ) )
       OR 
       (d.balance>0 AND c.ar1_mapping IN ('HO_CA_SBI_COMMERCIAL', 'BORROWING_OTHER_BANKS' ))
       )
       ) b ,
(SELECT SUM(DailyLimit) bal FROM investments.alm_ca_settlement) c
 SET RM_1D_to_14D=b.bal-c.bal,RM_1Y_to_3Y=c.bal, RM_TOTAL=b.bal WHERE DisplayOrder=31 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 32  3.2    Money at Call and Short Notice
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT (aa.bal+bb.bal) bal FROM  
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('REVERSE_REPO_AC') ) aa ,
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('TD_SBI_OTHERS'))bb )b
 SET RM_1D_to_14D=b.bal, RM_TOTAL=b.bal WHERE DisplayOrder=32 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();






//-- 33  4      Investments (including those under Repos but excluding Reverse Repos)
 $sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(SELECT (aa.bal-IF(bb.bal IS NULL, 0 , bb.bal)) bal FROM  
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('SLR_GOVT' ,
 'SUBSIDARY_JOINT_VENTURES', 'IVP_KVP_MF', 'MUTUAL_FUNDS'  , 'APPROVED_OTHER_SECURITIES' , 'SHARES' , 'NON_SLR' ,  'NET_PROVISION_INVESTMENT_OUTSIDE_INDIA') ) aa ,
(SELECT SUM(IF (d.balance IS NULL, 0, d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping 
IN ('LESS_PROVISION_DEPRECIATION', 'LESS_PROVISION_VENTURES_IVP_MUTUAL', 'LESS_PROVISION_SECURITIES_BONDS_SHARES'))bb 
)b
 SET RM_1D_to_14D=b.bal,RM_TOTAL=b.bal WHERE DisplayOrder=33 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

// $sql1="update investments.alm_appendix1_maturity_profile_liquidity a, 
//        (select 
//               sum(case when bb.days<=14 then Book_Value end) as 'bb1',
//               sum(case when bb.days>14 and bb.days<=28 then Book_Value end) as 'bb2',  
//               sum(case when bb.days>28 and bb.days<=90 then Book_Value end) as 'bb3',
//               sum(case when bb.days>90 and bb.days<=180 then Book_Value end) as 'bb4',
//               sum(case when bb.days>180 and bb.days<=365 then Book_Value end) as 'bb5',
//               sum(case when bb.days>365 and bb.days<=1095 then Book_Value end) as 'bb6',
//               sum(case when bb.days>1095 and bb.days<=1825 then Book_Value end) as 'bb7',
//               sum(case when bb.days>1825 then Book_Value end) as 'bb8'
//               from
//               (SELECT DATEDIFF('$asondate',`Purchase_Date`) AS 'Days',`Amount_Deposited` Book_Value FROM investments.alm_tdr WHERE Maturity_Date>='$asondate' UNION ALL 
//               SELECT DATEDIFF('$asondate',`Purchase_Date`) AS 'Days',Book_Value FROM investments.alm_slr WHERE Maturity_Date>='$asondate' UNION ALL 
//               SELECT 14 AS 'Days',SUM(IF(Market_Value<`Purchase_Value`,`Market_Value`,`Purchase_Value`)) Book_Value FROM investments.alm_mf 
//               ) bb
//        ) b 
//        set    RM_1D_to_14D=b.bb1, 
//               RM_15D_to_28D=b.bb2, 
//               RM_29D_to_3M=b.bb3,
//               RM_3M_to_6M=b.bb4, 
//               RM_6M_to_1Y=b.bb5, 
//               RM_1Y_to_3Y=b.bb6, 
//               RM_3Y_to_5Y=b.bb7,
//               RM_OVER_5Y=b.bb8 
//        where DisplayOrder=33 and asondate='$asondate' ";
//  $stt = $conn->prepare($sql);
//  $stt->execute();

  
 
//-- 34  5      Advances (Performing)       =      5.1 + 5.2 + 5.3
//-- 35  5.1    Bills Purchased and Discounted (including bills under DUPN)    -      NA

//-- 36  5.2    Cash Credits, Overdrafts and Loans repayable on demand 
 $sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
( 
SELECT 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)<=14) THEN BALANCE ELSE 0 END),2) AS A1,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>14 AND DATEDIFF(run_date,SAN_DT)<=28) THEN BALANCE ELSE 0 END),2) AS A2,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>29 AND DATEDIFF(run_date,SAN_DT)<=90) THEN BALANCE ELSE 0 END),2) AS A3,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>90 AND DATEDIFF(run_date,SAN_DT)<=180) THEN BALANCE ELSE 0 END),2) AS A4,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>180 AND DATEDIFF(run_date,SAN_DT)<=365) THEN BALANCE ELSE 0 END),2) AS A5,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>365 AND DATEDIFF(run_date,SAN_DT)<=1095) THEN BALANCE ELSE 0 END),2) AS A6,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>1095 AND DATEDIFF(run_date,SAN_DT)<=1825) THEN BALANCE ELSE 0 END),2) AS A7,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>1825) THEN BALANCE ELSE 0 END),2) AS A8,
       ROUND(SUM(balance),2) AS 'TOTAL' 
FROM $npaTbl  
WHERE CRDR LIKE '%dR%' AND account_type NOT LIKE 'STAFF FA%' 
AND irac_o<4 AND product NOT IN 
('62321102', '62321101', '62311101', '62321103', '62321105', '62321207', '62321216', '62321214', '62321215', '62321201', '62311201', '62321210', '62311209', '62311111', '62321221', '62321220', '62321212', '62321223', '62321111', '62523112', '62322105', '62322102', '61112103', '62211601', '62211501', '62211302', '62321218', '62301201', '62608102', '62608103', '63609101', '63609102', '62505504', '62505010', '62523103', '62505012', '62505016', '62525006', '61113101', '62213101', '62123101', '61113106', '62213201', '62505011', '62213105', '62211901', '62312010', '62312002', '62515007', '62123103', '62503108', '62312003', '62523104', '62503107', '62526015', '62526013', '62516011', '62608404', '62526008', '62526009', '62526016', '62526001', '62526005', '62526014', '62608101', '62608002', '62608003', '62608001', '62608005', '62608006', '62608004', '62608202', '62608201')
) b 
 SET RM_1D_to_14D=b.A1, RM_15D_to_28D=b.A2, RM_29D_to_3M=b.A3,RM_3M_to_6M=b.A4, RM_6M_to_1Y=b.A5, RM_1Y_to_3Y=b.A6, RM_3Y_to_5Y=b.A7,RM_OVER_5Y=b.A8,RM_TOTAL=b.TOTAL 
 WHERE DisplayOrder=36 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 37  5.3    Term Loans
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
(  
SELECT 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)<=14) THEN BALANCE ELSE 0 END),2) AS A1,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>14 AND DATEDIFF(run_date,SAN_DT)<=28) THEN BALANCE ELSE 0 END),2) AS A2,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>29 AND DATEDIFF(run_date,SAN_DT)<=90) THEN BALANCE ELSE 0 END),2) AS A3,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>90 AND DATEDIFF(run_date,SAN_DT)<=180) THEN BALANCE ELSE 0 END),2) AS A4,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>180 AND DATEDIFF(run_date,SAN_DT)<=365) THEN BALANCE ELSE 0 END),2) AS A5,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>365 AND DATEDIFF(run_date,SAN_DT)<=1095) THEN BALANCE ELSE 0 END),2) AS A6,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>1095 AND DATEDIFF(run_date,SAN_DT)<=1825) THEN BALANCE ELSE 0 END),2) AS A7,
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>1825) THEN BALANCE ELSE 0 END),2) AS A8,
       ROUND(SUM(balance),2) AS 'TOTAL' 
FROM $npaTbl  
WHERE CRDR LIKE '%dR%' AND account_type NOT LIKE 'STAFF FA%' 
AND irac_o<4 AND product IN 
('62321102', '62321101', '62311101', '62321103', '62321105', '62321207', '62321216', '62321214', '62321215', '62321201', '62311201', '62321210', '62311209', '62311111', '62321221', '62321220', '62321212', '62321223', '62321111', '62523112', '62322105', '62322102', '61112103', '62211601', '62211501', '62211302', '62321218', '62301201', '62608102', '62608103', '63609101', '63609102', '62505504', '62505010', '62523103', '62505012', '62505016', '62525006', '61113101', '62213101', '62123101', '61113106', '62213201', '62505011', '62213105', '62211901', '62312010', '62312002', '62515007', '62123103', '62503108', '62312003', '62523104', '62503107', '62526015', '62526013', '62516011', '62608404', '62526008', '62526009', '62526016', '62526001', '62526005', '62526014', '62608101', '62608002', '62608003', '62608001', '62608005', '62608006', '62608004', '62608202', '62608201')
) b 
 SET RM_1D_to_14D=b.A1, RM_15D_to_28D=b.A2, RM_29D_to_3M=b.A3,RM_3M_to_6M=b.A4, RM_6M_to_1Y=b.A5, RM_1Y_to_3Y=b.A6, RM_3Y_to_5Y=b.A7,RM_OVER_5Y=b.A8,RM_TOTAL=b.TOTAL 
 WHERE DisplayOrder=37 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();
 






//-- 38  6      NPAs (Advances and Investments) 2 
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a, 
( 
SELECT 
       ROUND(SUM(CASE WHEN irac_o=4 THEN BALANCE ELSE 0 END),2) AS A7,
       ROUND(SUM(CASE WHEN irac_o>4 THEN BALANCE ELSE 0 END),2) AS A8,
       ROUND(SUM(CASE WHEN irac_o>=4 THEN BALANCE ELSE 0 END),2) AS TOTAL
FROM $npaTbl  
WHERE CRDR LIKE '%dR%' AND account_type NOT LIKE 'STAFF FA%' 
AND irac_o>=4 
) b 
 SET RM_3Y_to_5Y=b.A7,RM_OVER_5Y=b.A8,RM_TOTAL=b.TOTAL 
 WHERE DisplayOrder=38 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 39  7      Fixed Assets 
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(
SELECT SUM(d.balance) bal FROM $dailyweeklyTbl d WHERE d.level2='FIXED ASSETS' 
) b 
 SET RM_OVER_5Y=B.BAL, RM_TOTAL=b.bal WHERE DisplayOrder=39 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();

//-- 40  8      Other Assets  =      8.1 + 8.2 + 8.3

//-- 41  8.1    Branch Adjustments8.1
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(
SELECT aa.bal bal_aa, bb.bal bal_bb, (aa.bal+bb.bal) bal FROM   
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('BCGA_AC') ) aa, 
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('IBIT_AC','CORE_INTER_BRANCH_AC') ) bb
) b
SET RM_1D_to_14D=IF(b.bal_aa<b.bal_bb,b.bal,0), RM_TOTAL=IF(b.bal_aa<b.bal_bb,b.bal,0) WHERE DisplayOrder=41 AND asondate='$asondate'";
$stt = $conn->prepare($sql);
$stt->execute();

//-- 42  8.2    Leased Assets8.2
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(
SELECT (AA.BAL+BB.BAL+CC.BAL+DD.BAL+EE.BAL) bal FROM 
(SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN ('INT_ACCRUED') AND level3 !='INTEREST ACCRUED A' )AA, 
(SELECT IF(SUM(d.balance)<0,0,SUM(d.balance)) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN  
('PROVISION_INCOME_TAX','ADV_TAX','TDS'))BB, 
 (SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN  
('STAMPS_ACC','STATIONARY_AC')) CC , 
  (SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND c.ar1_mapping IN  
('INTEREST_RECEIVEABLE_GOI' , 'THREE_PERCENT_INTEREST_RECEIVEABLE_GOI' ,'VLR_SG' ,'NRLM_INT_SUBVENTION_5_5_GOI')) DD,   
   (SELECT SUM(d.balance) bal FROM investments.cgl_ar1_mapping c, $dailyweeklyTbl d WHERE d.cgl_acc_no=c.cgl AND (c.ar1_mapping IN  
('CGST', 'SGST', 'IGST', 'ASSET_ACCOUNT_ITC', 'UTILITIES', 'UID_CREDIT', 'CERSAI', 'OTHER_ASSETS', 'PREPAID_EXPENSE', 'NON_INT_BEARING_ADV_STAFF', 'ADJUSTING_AC')  
OR C.CGL='1231505002' )) EE   
 ) b 
 SET RM_OVER_5Y=b.bal,RM_TOTAL=b.bal WHERE DisplayOrder=42 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute(); 
 
//-- 43  8.3    Others-Leased Assets8.3







//-- 44  9      Reverse Repos -      NA
//-- 45  10     Bills Rediscounted (DUPN)_reverserepo     - NA

//-- 46  11     Interest Receivable  -      load Investments
//-- Investment data has to be updated with last interest received date.
$sql = "UPDATE investments.alm_appendix1_maturity_profile_liquidity a,
(
SELECT 
              SUM(CASE WHEN bb.days<=14 THEN intr_rbl END) AS A1,
              SUM(CASE WHEN bb.days>14 AND bb.days<=28 THEN intr_rbl END) AS A2,  
              SUM(CASE WHEN bb.days>28 AND bb.days<=90 THEN intr_rbl END) AS A3,
              SUM(CASE WHEN bb.days>90 AND bb.days<=180 THEN intr_rbl END) AS A4,
              SUM(CASE WHEN bb.days>180 AND bb.days<=365 THEN intr_rbl END) AS A5,
              SUM(CASE WHEN bb.days>365 AND bb.days<=1095 THEN intr_rbl END) AS A6,
              SUM(CASE WHEN bb.days>1095 AND bb.days<=1825 THEN intr_rbl END) AS A7,
              SUM(CASE WHEN bb.days>1825 THEN intr_rbl END) AS A8,
              SUM(intr_rbl) AS TOTAL               
FROM
(
SELECT Days , ROUND((Face_Value * Interest_Rate * Days)/36500,2) AS 'intr_rbl' 
FROM ( SELECT *,(DATEDIFF('$asondate',`Last_Intr_Recd_Date`)+1) AS 'Days' FROM investments.alm_bond WHERE Maturity_Date>='$asondate' AND Last_Intr_Recd_Date<='$asondate' ) a1 
UNION ALL
SELECT Days , ROUND((Face_Value * Interest_Rate * Days)/36000,2) AS 'intr_rbl' 
FROM ( SELECT *,investments.calc_days360(Last_Intr_Recd_Date,'$asondate') AS 'Days' FROM investments.alm_slr WHERE Maturity_Date>='$asondate' AND Last_Intr_Recd_Date<='$asondate' ) a2 
UNION ALL
SELECT Days, investments.calc_tdr_interest(Interest_Rate,Purchase_Date,Maturity_Date,'$asondate',Amount_Deposited) AS 'intr_rbl' 
FROM ( SELECT *,(DATEDIFF('$asondate',`Purchase_Date`)+1) AS 'Days' FROM investments.alm_tdr WHERE Maturity_Date>='$asondate' AND Purchase_Date<='$asondate' ) a3 
)  bb
) b 
 SET RM_1D_to_14D=b.A1, RM_15D_to_28D=b.A2, RM_29D_to_3M=b.A3,RM_3M_to_6M=b.A4, RM_6M_to_1Y=b.A5, RM_1Y_to_3Y=b.A6, RM_3Y_to_5Y=b.A7,RM_OVER_5Y=b.A8,RM_TOTAL=b.TOTAL WHERE DisplayOrder=46 AND asondate='$asondate'";
 $stt = $conn->prepare($sql);
 $stt->execute();



//-- 47  12     Committed Lines of Credit 
//-- 48  13     Others-cumlines of credit
//-- 49  102    Total Inflows - B    =      1 + 2 + 3 + 4 + 5 + 6 + 7 + 8 + 9 + 10 + 11 + 12 + 13

 


//-- ---------------------------------------------------------------------------------------------------


//-- 50  103    Mismatch C    =      B - A

//-- 51  104    Cumulative Mismatch

//-- 52  105    C as % to A



// set_time_limit(60000);


// $sql="update $dailyweeklyTbl set balance=balance1 ";
// $stt = $conn->prepare($sql);
// $stt->execute(); 
 
?>




<script type="text/javascript">
// async function 

</script>