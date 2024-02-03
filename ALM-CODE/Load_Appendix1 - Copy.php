<!DOCTYPE HTML>
<html lang="en">

<head>
<?php
$fnameTitle=basename($_SERVER['SCRIPT_NAME'],".php");
echo "<title> $fnameTitle | ALM </title>";
?>
</head>

<script>
	
function  get_the_data_from_112(query_string)
{

var set_the_data;

fetch('http://10.88.1.112/112_api.php?func_name=alm_data_for_refinance_data&in_data='+query_string).then( res => res.json() ).then( d  => {
set_the_data = JSON.stringify(d);
document.getElementById('refinance').value = set_the_data ;
document.sub_this_form_of_refin_data.submit();
} );
}

</script>
<form id="sub_this_form_of_refin_data" method="post" name="sub_this_form_of_refin_data">
	<input id="refinance" name="refinace_data" class='form-control' type="hidden" />
</form>
<body>

<?php
include 'index.php';
$prevDay=date("Y-m-d",strtotime("-1 day"));



$sql2="SELECT max(asondate) from  investments.alm_appendix1_maturity_profile_liquidity ";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_row($result2);
$asondate1=$row2[0];


if ($asondate1<$prevDay)
 {
 //echo "<script>alert('All Entries of $asondate1 were completed. Hence, moved to Next Month');</script>";
 $asondate=$prevDay;//date("Y-m-t",strtotime("$asondate1 +1 day"));
 $sql_ins="insert into investments.alm_appendix1_maturity_profile_liquidity(OrderNo, op_mode, Category, sub_Category,asondate,DisplayOrder) select OrderNo, op_mode, Category, sub_Category,'$asondate',DisplayOrder from investments.alm_appendix1_model order by DisplayOrder";
 $res_ins=mysqli_query($conn,$sql_ins);
 $sql_ins="update investments.alm_appendix1_maturity_profile_liquidity a,investments.`alm_appendix1_model` am 
 			set RM_1D_to_14D=0,RM_15D_to_28D=0,RM_29D_to_3M=0, RM_3M_to_6M=0,RM_6M_to_1Y=0, RM_1Y_to_3Y=0, RM_3Y_to_5Y=0, RM_OVER_5Y=0, RM_TOTAL=0 
 			where asondate='$asondate' and a.displayorder=am.displayorder and am.Comments='NA' ";
 $res_ins=mysqli_query($conn,$sql_ins);

 $sql_ins="insert into investments.alm_data_load_status(EntryDate,asondate,data_list,staffid,DLEntryId) SELECT curdate(),'$asondate',`FilesList`,$pid,EntryId FROM `investments`.`alm_data_load` ";
 $res_ins=mysqli_query($conn,$sql_ins);
 
 }
else
 $asondate=$asondate1;



$cnoCnt=1;
$rowSttCnt=-1;

$sql3="SELECT sum(if(OrderNo=1,RM_TOTAL,0)),sum(if (OrderNo=2,RM_TOTAL,0))  from  investments.alm_appendix1_maturity_profile_liquidity where OrderNo<=2 and asondate='$asondate1' and op_mode='Outflows'";
$result3=mysqli_query($conn,$sql3);
$row3=mysqli_fetch_row($result3);
$capital=$row3[0];
$reserves_surplus=$row3[1];

//$asondate=$_POST['asondate'];
//$asondate1=date("Y-m-t",strtotime($asondate));

$sucessCnt=0;


if (isset($_POST['showAsondate']))
	{
		 	$asondate=$_POST['asondate'];

		$sql2_chk="SELECT COUNT(1) FROM  investments.alm_appendix1_maturity_profile_liquidity WHERE asondate='$asondate' ";
		// echo $sql2_chk;

		$result2_chk=mysqli_query($conn,$sql2_chk);
		$row2_chk=mysqli_fetch_row($result2_chk);
		$asondate_chk=$row2_chk[0];
		// var_dump($asondate_chk);
		if (!$asondate_chk)
		{
		 $sql_ins="insert into investments.alm_appendix1_maturity_profile_liquidity(OrderNo, op_mode, Category, sub_Category,asondate,DisplayOrder) select OrderNo, op_mode, Category, sub_Category,'$asondate',DisplayOrder from investments.alm_appendix1_model order by DisplayOrder";
		 $res_ins=mysqli_query($conn,$sql_ins);
		 $sql_ins="update investments.alm_appendix1_maturity_profile_liquidity a,investments.`alm_appendix1_model` am 
		 			set RM_1D_to_14D=0,RM_15D_to_28D=0,RM_29D_to_3M=0, RM_3M_to_6M=0,RM_6M_to_1Y=0, RM_1Y_to_3Y=0, RM_3Y_to_5Y=0, RM_OVER_5Y=0, RM_TOTAL=0 
		 			where asondate='$asondate' and a.displayorder=am.displayorder and am.Comments='NA' ";
		 $res_ins=mysqli_query($conn,$sql_ins);

		 $sql_ins="insert into investments.alm_data_load_status(EntryDate,asondate,data_list,staffid,DLEntryId) SELECT curdate(),'$asondate',`FilesList`,$pid,EntryId FROM `investments`.`alm_data_load` ";
		 $res_ins=mysqli_query($conn,$sql_ins);	
		}
	}

?>


<!--Trial Balance-->		

<?php
if (isset($_POST['submitTRB']))
{
$asondate=$_POST['asondate'];
//$asondate=date("Y-m-t",strtotime($asondate));
$sucessCnt=0;

//Outflows - Capital  - 1 
$sql1="select sum(abs(balance)) from mis.dailyweekly  where level1='LIABILITIES' and level2='SHARE CAPITAL'";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$sql1="update investments.alm_appendix1_maturity_profile_liquidity a set RM_OVER_5Y='$row1[0]', RM_TOTAL='$row1[0]' where DisplayOrder=1 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Outflows - RESERVES AND SURPLUS - 2
$sql1="select sum(abs(balance)) from mis.dailyweekly  where level1='LIABILITIES' and level2='RESERVES AND SURPLUS'";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_OVER_5Y='$row1[0]', RM_TOTAL='$row1[0]' where DisplayOrder=2 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Outflows - Current Deposits - 3.1
$sql1="select sum(abs(balance)) from mis.dailyweekly  where  level1='LIABILITIES' AND level2='DEMAND DEPOSITS' AND level3='CURRENT A/C'";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$L01A=$row1[0];
$L01A_1=$L01A*0.15;
$L01A_2=$L01A*0.85;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$L01A_1',RM_1Y_to_3Y='$L01A_2', RM_TOTAL='$L01A' where DisplayOrder=4 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Outflows - Savings Bank - 3.2
$sql1="select sum(abs(balance)) from mis.dailyweekly where  level1='LIABILITIES' AND level2='DEMAND DEPOSITS' AND level3='SAVINGS BANK A/C'";
//echo "<br>$sql1";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$L01D=$row1[0];
$L01D_1=$L01D*0.10;
$L01D_2=$L01D*0.90;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$L01D_1',RM_1Y_to_3Y='$L01D_2', RM_TOTAL='$L01D' where DisplayOrder=5 and asondate='$asondate' ";
//echo "<br>$sql1";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//updating 3 with 3.1+3.2+3.3+3.4
bulk_update(3,$asondate);
$sucessCnt++;

//Outflows - Bills Payables - 5.1
$sql1="select sum(abs(balance)) from mis.dailyweekly where level1='LIABILITIES' and level2 in ('INTER OFFICE ACCOUNTS','INTER BRANCH ADJUSTMENT AC')";
//echo "<br>$sql1";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal=$row1[0];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal', RM_TOTAL='$bal' where DisplayOrder=14 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
//echo "<br>$sql1";
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Outflows - Branch Adjustments - 5.2
$sql1="select round(a.bal-b.bal,2) from
		(select sum(abs(balance)) bal from mis.dailyweekly  where level1='LIABILITIES' and level2='INTER BRANCH ADJUSTMENT AC') a,
		(select sum(abs(balance)) bal from mis.dailyweekly  where level1='ASSETS' and level2='INTER BRANCH ADJUSTMENT AC') b
		";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal=$row1[0];
if ($bal>0)
	{
	$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal', RM_TOTAL='$bal' where DisplayOrder=15 and asondate='$asondate' ";
	$res1=mysqli_query($conn,$sql1);
	if (!$res1)
	 die("<br>Failed : $sql1");
	$sucessCnt++;

	$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='0', RM_TOTAL='0' where DisplayOrder=41 and asondate='$asondate' ";
	$res1=mysqli_query($conn,$sql1);
	if (!$res1)
	 die("<br>Failed : $sql1");
	$sucessCnt++;
	}
else
	{
	$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='0', RM_TOTAL='0' where DisplayOrder=15 and asondate='$asondate' ";
	$res1=mysqli_query($conn,$sql1);
	if (!$res1)
	 die("<br>Failed : $sql1");
	$sucessCnt++;

	$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal', RM_TOTAL='$bal' where DisplayOrder=41 and asondate='$asondate' ";
	$res1=mysqli_query($conn,$sql1);
	if (!$res1)
	 die("<br>Failed : $sql1");
	$sucessCnt++;
	}

//Outflows - Provisions - 5.3
$sql1="select sum(abs(balance)) from mis.dailyweekly where cgl_acc_no in (
				2017505004, 2029505014, 2029505016, 2029505017, 2029505019, 2029505021 , 2029505022	
		)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal=$row1[0];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal', RM_TOTAL='$bal' where DisplayOrder=16 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Outflows - Other Provisions - 5.4
$sql1="select sum(abs(balance)) from mis.dailyweekly where cgl_acc_no in (
				2029505023	
		)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal=$row1[0];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal', RM_TOTAL='$bal' where DisplayOrder=17 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Outflows - Other Liabilities and Provisions - 5
//updating 5 with 5.1+5.2+5.3+5.4
bulk_update(13,$asondate);
$sucessCnt++;


//Outflows - total Outflows - 13
//updating Total Outflows
bulk_update(27,$asondate);
$sucessCnt++;


//Inflows - Cash - 1
$sql1="select sum(abs(balance)) from mis.dailyweekly  where cgl_acc_no in (
				1204505001	
		)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal=$row1[0];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal', RM_TOTAL='$bal' where DisplayOrder=28 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Inflows - Blances with RBI - 2
$sql1="select sum(abs(balance)) from mis.dailyweekly  where level2 in ('DEMAND DEPOSITS','TIME DEPOSITS') ";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal1_tmp=$row1[0];
$bal1=$bal1_tmp-($bal1_tmp*0.04);

$sql1="select sum(abs(balance)) from mis.dailyweekly  where cgl_acc_no in (
				1230505004	
		)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal2=$row1[0];

$bal=$bal1+$bal2;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$bal1',RM_15D_to_28D='$bal2', RM_TOTAL='$bal' where DisplayOrder=29 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;


//Inflows - Current Account - 3.1
$sql1="select sum(abs(balance)) from mis.dailyweekly  where cgl_acc_no in (
				1033505001 , 1221505001 , 1230505006 , 1230505010 , 1230505011 , 1221505002 , 1224505024, 1230505004, 1517505007, 1517505008, 1204505002 , 1221505003 , 1221505004	
		)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal1=$row1[0];

$sql1="select sum(DailyLimit) from investments.alm_ca_settlement";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal2=$row1[0];

$excess=$bal1-$bal2;

$bal=$excess+$bal2;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$excess', RM_1Y_to_3Y='$bal2', RM_TOTAL='$bal' where DisplayOrder=31 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Inflows - Fixed Assets - 8
$sql1="select sum(abs(balance)) from mis.dailyweekly  where level2='FIXED ASSETS'";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$bal=$row1[0];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_OVER_5Y='$bal', RM_TOTAL='$bal' where DisplayOrder=39 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;


//updating 3 with 3.1+3.2
bulk_update(30,$asondate);
$sucessCnt++;

//updating 8 with 8.1+8.2+8.3
bulk_update(40,$asondate);
$sucessCnt++;

// Upating Total Inflows
bulk_update(49,$asondate);
$sucessCnt++;

last3_rows_update($asondate);
$sucessCnt++;

if ($sucessCnt==20)
	{
	$sql1="update `investments`.`alm_data_load_status`  set LoadedTs=now()  where asondate='$asondate' and data_list='TrialBalance' ";
	$res1=mysqli_query($conn,$sql1);
	}

}
?>
		<?php
if (isset($_POST['UpdateInv']))
{
$asondate=$_POST['asondate'];

//echo "<script>alert('$asondate');</script>";
$sucessCnt=0;
//Inflows - Other Bank Deposits - TDRs - 3.2
$sql1="select 
		sum(case when b.days<=14 then intr_pbl end) as '0',
		sum(case when b.days>14 and b.days<=28 then intr_pbl end) as '1',  
		sum(case when b.days>28 and b.days<=90 then intr_pbl end) as '2',
		sum(case when b.days>90 and b.days<=180 then intr_pbl end) as '3',
		sum(case when b.days>180 and b.days<=365 then intr_pbl end) as '4',
		sum(case when b.days>365 and b.days<=1095 then intr_pbl end) as '5',
		sum(case when b.days>1095 and b.days<=1825 then intr_pbl end) as '6',
		sum(case when b.days>1825 then intr_pbl end) as '7'
		from
		(select a.Days,a.intr_pbl from 
		(select *,datediff(Maturity_Date,'$asondate') as 'Days',round(((Interest_Rate/365000)*Amount_Deposited)*datediff(Maturity_Date,'$asondate'),2) as intr_pbl from investments.alm_tdr where Maturity_Date>='$asondate') a) b
	";
//echo $sql1;
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$tot=$row1[0]+$row1[1]+$row1[2]+$row1[3]+$row1[4]+$row1[5]+$row1[6]+$row1[7];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$row1[0]', RM_15D_to_28D='$row1[1]', RM_29D_to_3M='$row1[2]',RM_3M_to_6M='$row1[3]', RM_6M_to_1Y='$row1[4]', RM_1Y_to_3Y='$row1[5]', RM_3Y_to_5Y='$row1[6]',RM_OVER_5Y='$row1[7]', RM_TOTAL='$tot' where DisplayOrder=32 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;

//Inflows -Investments - 4
//TDRs
$sql1="select 
		sum(case when b.days<=14 then Book_Value end) as '1',
		sum(case when b.days>14 and b.days<=28 then Book_Value end) as '2',  
		sum(case when b.days>28 and b.days<=90 then Book_Value end) as '3',
		sum(case when b.days>90 and b.days<=180 then Book_Value end) as '4',
		sum(case when b.days>180 and b.days<=365 then Book_Value end) as '5',
		sum(case when b.days>365 and b.days<=1095 then Book_Value end) as '6',
		sum(case when b.days>1095 and b.days<=1825 then Book_Value end) as '7',
		sum(case when b.days>1825 then Book_Value end) as '8'
		from
		(SELECT DATEDIFF('$asondate',`Purchase_Date`) AS 'Days',`Amount_Deposited` Book_Value FROM investments.alm_tdr WHERE Maturity_Date>='$asondate' UNION ALL 
		SELECT DATEDIFF('$asondate',`Purchase_Date`) AS 'Days',Book_Value FROM investments.alm_slr WHERE Maturity_Date>='$asondate' UNION ALL 
		SELECT 14 AS 'Days',SUM(IF(Market_Value<`Purchase_Value`,`Market_Value`,`Purchase_Value`)) Book_Value FROM investments.alm_mf 
		) b
	";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$tot1=$row1[0]+$row1[1]+$row1[2]+$row1[3]+$row1[4]+$row1[5]+$row1[6]+$row1[7];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$row1[0]', RM_15D_to_28D='$row1[1]', RM_29D_to_3M='$row1[2]',RM_3M_to_6M='$row1[3]', RM_6M_to_1Y='$row1[4]', RM_1Y_to_3Y='$row1[5]', RM_3Y_to_5Y='$row1[6]',RM_OVER_5Y='$row1[7]', RM_TOTAL='$tot' where DisplayOrder=33 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;


//Inflows - Interest Receivables - 11 - All investments - Bonds, SLR, TDRs
$sql1="SELECT 
		SUM(CASE WHEN b.days<=14 THEN intr_rbl END) AS '0',
		SUM(CASE WHEN b.days>14 AND b.days<=28 THEN intr_rbl END) AS '1',  
		SUM(CASE WHEN b.days>28 AND b.days<=90 THEN intr_rbl END) AS '2',
		SUM(CASE WHEN b.days>90 AND b.days<=180 THEN intr_rbl END) AS '3',
		SUM(CASE WHEN b.days>180 AND b.days<=365 THEN intr_rbl END) AS '4',
		SUM(CASE WHEN b.days>365 AND b.days<=1095 THEN intr_rbl END) AS '5',
		SUM(CASE WHEN b.days>1095 AND b.days<=1825 THEN intr_rbl END) AS '6',
		SUM(CASE WHEN b.days>1825 THEN intr_rbl END) AS '7'
		
		FROM
		(
		SELECT Days , ROUND(`Book_Value`* mis.interest_factor('simple','',Interest_Rate,Days)-`Book_Value`,2) AS 'intr_rbl' 
		FROM 
			( SELECT *,DATEDIFF('$asondate',`Last_Intr_Recd_Date`) AS 'Days' FROM investments.alm_bond WHERE Maturity_Date>='$asondate' AND Last_Intr_Recd_Date<='$asondate' ) a1 
		UNION ALL
		SELECT Days , ROUND(`Book_Value`* mis.interest_factor('simple','',Interest_Rate,Days)-Book_Value,2) AS 'intr_rbl' 
		FROM 
			( SELECT *,DATEDIFF('$asondate',`Last_Intr_Recd_Date`) AS 'Days' FROM investments.alm_slr WHERE Maturity_Date>='$asondate' AND Last_Intr_Recd_Date<='$asondate' ) a2 
		UNION ALL
		SELECT Days, ROUND(Amount_Deposited * mis.interest_factor('compound','quarterly',Interest_Rate,Days),2) AS 'intr_rbl' 
		FROM 
			( SELECT *,DATEDIFF('$asondate',`Purchase_Date`) AS 'Days' FROM investments.alm_tdr WHERE Maturity_Date>='$asondate' AND Purchase_Date<='$asondate' ) a3 
		)  b
		";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
$tot1=$row1[0]+$row1[1]+$row1[2]+$row1[3]+$row1[4]+$row1[5]+$row1[6]+$row1[7];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$row1[0]', RM_15D_to_28D='$row1[1]', RM_29D_to_3M='$row1[2]',RM_3M_to_6M='$row1[3]', RM_6M_to_1Y='$row1[4]', RM_1Y_to_3Y='$row1[5]', RM_3Y_to_5Y='$row1[6]',RM_OVER_5Y='$row1[7]', RM_TOTAL='$tot' where DisplayOrder=46 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;


//Inflows - Balances with Other Banks - 3
//updating 3 with 3.1+3.2
bulk_update(30,$asondate);
$sucessCnt++;

//Total Inflows
bulk_update(49,$asondate);
$sucessCnt++;

last3_rows_update($asondate);
$sucessCnt++;

if ($sucessCnt==6)
	{
	$sql1="update `investments`.`alm_data_load_status`  set LoadedTs=now()  where asondate='$asondate' and data_list='Investments' ";
	$res1=mysqli_query($conn,$sql1);
	}

}
?>


<?php
if(isset($_POST["submitDailyWeekly"]))
{
$sucessCnt=0;

ini_set('upload_max_filesize','30M');
$uploaddir = 'C:/wamp/www/mis/Departments/HeadOffice/ALM/Uploads/';
$attach_dailyweekly=basename($_FILES["Attach_dailyweekly"]["name"]);
$dailyweekly_file=$uploaddir . $attach_dailyweekly;
unlink($dailyweekly_file);
$res3=move_uploaded_file($_FILES["Attach_dailyweekly"]["tmp_name"], $dailyweekly_file);
$handle = fopen($dailyweekly_file , "r");
$L01A=$L01D=$A01=$NDTL=0;
echo "Dailyweekly:<Ul>";

while(!feof($handle))
{
$contents = fgets($handle);
 $rm_tmp=trim(substr($contents,0,4));

if ($rm_tmp=="L01A")
 $L01A+=str_replace(",","",trim(substr($contents,80,21)));

if ($rm_tmp=="L01D")
 $L01D+=str_replace(",","",trim(substr($contents,80,21)));

if (trim(substr($rm_tmp,0,3))=="A01")
 $A01+=str_replace(",","",trim(substr($contents,80,21)));

if ((trim(substr($rm_tmp,0,3)=="L01")) || (trim(substr($rm_tmp1,0,3)=="L03")) ) //NDTL (DD+TD)
 $NDTL+=str_replace(",","",trim(substr($contents,80,21)));
}
fclose($handle);

echo "<li>CASH BALANCE - $</li>";
$CRR=$NDTL*(4/100);
$excess_CRR=$NDTL-$CRR;
echo "<li>Excess_CRR - $excess_CRR</li>";

echo "</Ul>";

$asondate=$_POST['asondate'];
$asondate=date("Y-m-t",strtotime($asondate));

		$L01A_1=$L01A*0.15;
		$L01A_2=$L01A*0.85;
		$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$L01A_1',RM_1Y_to_3Y='$L01A_2', RM_TOTAL='$L01A' where DisplayOrder=4 and asondate='$asondate' ";
		$res1=mysqli_query($conn,$sql1);

		$L01D_1=$L01D*0.10;
		$L01D_2=$L01D*0.90;
		$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$L01D_1',RM_1Y_to_3Y='$L01D_2', RM_TOTAL='$L01D' where DisplayOrder=5 and asondate='$asondate' ";
		$res1=mysqli_query($conn,$sql1);


$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$A01', RM_TOTAL='$A01' where DisplayOrder=28 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);

$sql1="select sum(abs(balance)) from mis.dailyweekly where LEVEL2='FIXED ASSETS' and date_sub(run_date,'interval 1 day')='$asondate' ";
$res1=mysqli_query($conn,$sql1);
$tot_with_RBI=$excess_CRR+$ca_with_RBI;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$excess_CRR',RM_15D_to_28D='$ca_with_RBI', RM_TOTAL='$tot_with_RBI' where DisplayOrder=29 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);


$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (4,5,6,7) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=3 ";
$res1=mysqli_query($conn,$sql1);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24.25.26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);

}
?>
		<?php
if (isset($_POST['submitTrmm0403']))
{
$asondate=$_POST['asondate'];

$sucessCnt=0;

ini_set('upload_max_filesize','30M');
$uploaddir = 'C:/wamp/www/mis/Departments/HeadOffice/ALM/Uploads/';

$attach_trmm0403=basename($_FILES["Attach_trmm0403"]["name"]);
$trmm0403_file=$uploaddir . $attach_trmm0403;
unlink($trmm0403_file);
$res3=move_uploaded_file($_FILES["Attach_trmm0403"]["tmp_name"], $trmm0403_file);
$handle = fopen($trmm0403_file , "r");
$rm_1d_14d=$rm_15d_28d=$rm_29d_3m=$rm_3m_6m=$rm_6m_1y=$rm_1y_3y=$rm_3y_5y=$rm_abv_5y=$rm_total=0;

while(!feof($handle))
{
$contents = fgets($handle);
//$stLine=trim(substr($contents,1,28));
 $rm_tmp=trim(substr($contents,0,5));

//echo "<li>$rm_tmp</li>";
//exit;
if ($rm_tmp=="TOTAL")
 {
 $rm_1d_14d+=trim(substr($contents,28,20));
 $rm_15d_28d+=trim(substr($contents,48,20));
 $rm_29d_3m+=trim(substr($contents,68,20));
 $rm_3m_6m+=trim(substr($contents,88,20));
 $rm_6m_1y+=trim(substr($contents,108,20));
 $rm_1y_3y+=trim(substr($contents,128,20));
 $rm_3y_5y+=trim(substr($contents,148,20));
 $rm_abv_5y+=trim(substr($contents,168,20));
 $rm_total+=trim(substr($contents,188,20));
 }

}
fclose($handle);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$rm_1d_14d',RM_15D_to_28D='$rm_15d_28d',RM_29D_to_3M='$rm_29d_3m',	RM_3M_to_6M='$rm_3m_6m',RM_6M_to_1Y='$rm_6m_1y',	
							RM_1Y_to_3Y='$rm_1y_3y',	RM_3Y_to_5Y='$rm_3y_5y',	RM_OVER_5Y='$rm_abv_5y',	RM_TOTAL='$rm_total' where DisplayOrder=6 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if (!$res1)
 die("<br>Failed : $sql1");
$sucessCnt++;
 
//updating Outflows 3 with 3.1+3.2+3.3
bulk_update(3,$asondate);
$sucessCnt++;

//updating Total Outflows 
bulk_update(27,$asondate);
$sucessCnt++;

if ($sucessCnt==3)
	{
	$sql1="update `investments`.`alm_data_load_status`  set LoadedTs=now()  where asondate='$asondate' and data_list='ResidualMaturites' ";
	$res1=mysqli_query($conn,$sql1);
	}

}

?>
		<?php
if (isset($_POST['submitNPAMonthend']))
{
$asondate=$_POST['asondate'];

$sucessCnt=0;
$run_date=date("Y-m-d",strtotime("$asondate +1 day"));


//Outflows - Unavailed Protion of Cash Credit/ Overdraft/ Demand Loan Component of Working Capital - 7
$sql="SELECT 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)<=14) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>14 AND DATEDIFF(run_date,SAN_DT)<=28) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>29 AND DATEDIFF(run_date,SAN_DT)<=90) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>90 AND DATEDIFF(run_date,SAN_DT)<=180) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>180 AND DATEDIFF(run_date,SAN_DT)<=365) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>365 AND DATEDIFF(run_date,SAN_DT)<=1095) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>1095 AND DATEDIFF(run_date,SAN_DT)<=1825) THEN unavailed ELSE 0 END),2), 
       ROUND(SUM(CASE WHEN (DATEDIFF(run_date,SAN_DT)>1825) THEN unavailed ELSE 0 END),2)  
		FROM 
		(
		SELECT run_date,SAN_DT,BALANCE,sanclimit,IF(crdr='DR',REPLACE(`SancLimit`,',','')-BALANCE,REPLACE(`SancLimit`,',','')+BALANCE) AS 'unavailed' 
		FROM mis.npa 
		WHERE irac_o < 4 AND REPLACE(`SancLimit`,',','')>=BALANCE  AND balance>0  
		UNION ALL 
		SELECT run_date,SAN_DT,BALANCE,sanclimit,IF(crdr='DR',REPLACE(`SancLimit`,',','')-BALANCE,REPLACE(`SancLimit`,',','')+BALANCE) AS 'unavailed'
		FROM mis.npa n INNER JOIN  others.`prod_desc` ON (prod = account_type)  
		WHERE irac_o < 4  AND REPLACE(`SancLimit`,',','')>=BALANCE AND balance>0   AND `SegmentName` = 'Demand Loans (DL)' 
		) a  	  
	  ";
$res=mysqli_query($conn,$sql);
$row1=mysqli_fetch_row($res);
$tot=$row1[0]+$row1[1]+$row1[2]+$row1[3]+$row1[4]+$row1[5]+$row1[6]+$row1[7];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$row1[0]', RM_15D_to_28D='$row1[1]', RM_29D_to_3M='$row1[2]',RM_3M_to_6M='$row1[3]', RM_6M_to_1Y='$row1[4]', RM_1Y_to_3Y='$row1[5]', RM_3Y_to_5Y='$row1[6]',RM_OVER_5Y='$row1[7]', RM_TOTAL='$tot' where DisplayOrder=21 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

//Inflows - NPA - 6
$sql="select  
       round(sum(case when irac_o=4 then BALANCE else 0 end),2), 
       round(sum(case when irac_o>4 then BALANCE else 0 end),2)
	  from mis.npa ";
//echo $sql;
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($res);
$tot_npa=$row[0]+$row[1];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_3Y_to_5Y='$row[0]',	RM_OVER_5Y='$row[1]',	RM_TOTAL='$tot_npa' where DisplayOrder=38 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

$conn_1=$conn;
//Inflows - CC, OD , DL - 5.2
$sql="SELECT Sum(A1) A1,
Sum(A2) A2,
Sum(A3) A3,
Sum(A4) A4,
Sum(A5) A5,
Sum(A6) A6,
Sum(A7) A7,
Sum(A8) A8 FROM (select 
       round(sum(case when (datediff(run_date,SAN_DT)<=14) then BALANCE else 0 end),2) as A1,
       round(sum(case when (datediff(run_date,SAN_DT)>14 and datediff(run_date,SAN_DT)<=28) then BALANCE else 0 end),2) as A2,
       round(sum(case when (datediff(run_date,SAN_DT)>29 and datediff(run_date,SAN_DT)<=90) then BALANCE else 0 end),2) as A3,
       round(sum(case when (datediff(run_date,SAN_DT)>90 and datediff(run_date,SAN_DT)<=180) then BALANCE else 0 end),2) as A4,
       round(sum(case when (datediff(run_date,SAN_DT)>180 and datediff(run_date,SAN_DT)<=365) then BALANCE else 0 end),2) as A5,
       round(sum(case when (datediff(run_date,SAN_DT)>365 and datediff(run_date,SAN_DT)<=1095) then BALANCE else 0 end),2) as A6,
       round(sum(case when (datediff(run_date,SAN_DT)>1095 and datediff(run_date,SAN_DT)<=1825) then BALANCE else 0 end),2) as A7,
       round(sum(case when (datediff(run_date,SAN_DT)>1825) then BALANCE else 0 end),2) as A8 
	  from mis.npa  
    where irac_o < 4 
	  AND ccod_tldl LIKE '%CCOD%' 
 UNION 

  select 
       round(sum(case when (datediff(run_date,SAN_DT)<=14) then BALANCE else 0 end),2) as A1,
       round(sum(case when (datediff(run_date,SAN_DT)>14 and datediff(run_date,SAN_DT)<=28) then BALANCE else 0 end),2) as A2,
       round(sum(case when (datediff(run_date,SAN_DT)>29 and datediff(run_date,SAN_DT)<=90) then BALANCE else 0 end),2) as A3,
       round(sum(case when (datediff(run_date,SAN_DT)>90 and datediff(run_date,SAN_DT)<=180) then BALANCE else 0 end),2) as A4,
       round(sum(case when (datediff(run_date,SAN_DT)>180 and datediff(run_date,SAN_DT)<=365) then BALANCE else 0 end),2) as A5,
       round(sum(case when (datediff(run_date,SAN_DT)>365 and datediff(run_date,SAN_DT)<=1095) then BALANCE else 0 end),2) as A6,
       round(sum(case when (datediff(run_date,SAN_DT)>1095 and datediff(run_date,SAN_DT)<=1825) then BALANCE else 0 end),2) as A7,
       round(sum(case when (datediff(run_date,SAN_DT)>1825) then BALANCE else 0 end),2) as A8 
	 from mis.npa  INNER JOIN  others.`prod_desc` ON 
   (prod = account_type )
  
  where irac_o < 4  AND 
  `SegmentName` = 'Demand Loans (DL)'  )t  
	  ";

// echo $sql;
$res=mysqli_query($conn,$sql);
$row1=mysqli_fetch_row($res);
$tot=$row1[0]+$row1[1]+$row1[2]+$row1[3]+$row1[4]+$row1[5]+$row1[6]+$row1[7];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$row1[0]', RM_15D_to_28D='$row1[1]', RM_29D_to_3M='$row1[2]',RM_3M_to_6M='$row1[3]', RM_6M_to_1Y='$row1[4]', RM_1Y_to_3Y='$row1[5]', RM_3Y_to_5Y='$row1[6]',RM_OVER_5Y='$row1[7]', RM_TOTAL='$tot' where DisplayOrder=36 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

//Inflows - TL - 5.3
$sql="select 
       round(sum(case when (datediff(run_date,SAN_DT)<=14) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>14 and datediff(run_date,SAN_DT)<=28) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>29 and datediff(run_date,SAN_DT)<=90) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>90 and datediff(run_date,SAN_DT)<=180) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>180 and datediff(run_date,SAN_DT)<=365) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>365 and datediff(run_date,SAN_DT)<=1095) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>1095 and datediff(run_date,SAN_DT)<=1825) then BALANCE else 0 end),2), 
       round(sum(case when (datediff(run_date,SAN_DT)>1825) then BALANCE else 0 end),2)  
	  from mis.npa  INNER JOIN  others.`prod_desc` ON 
   (prod = account_type )
  where  irac_o < 4 
	  AND ccod_tldl LIKE '%TLDL%' AND  `SegmentName`<>'Demand Loans (DL)'  	  
	  ";
//echo $sql;
$res=mysqli_query($conn_1,$sql);
$row1=mysqli_fetch_row($res);
$tot=$row1[0]+$row1[1]+$row1[2]+$row1[3]+$row1[4]+$row1[5]+$row1[6]+$row1[7];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$row1[0]', RM_15D_to_28D='$row1[1]', RM_29D_to_3M='$row1[2]',RM_3M_to_6M='$row1[3]', RM_6M_to_1Y='$row1[4]', RM_1Y_to_3Y='$row1[5]', RM_3Y_to_5Y='$row1[6]',RM_OVER_5Y='$row1[7]', RM_TOTAL='$tot' where DisplayOrder=37 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;


//updating Total Outflows 
bulk_update(27,$asondate);
$sucessCnt++;

//updating Inflows 5 with 5.1+5.2+5.3
bulk_update(34,$asondate);
$sucessCnt++;

//updating Total Inflows 
bulk_update(49,$asondate);
$sucessCnt++;

last3_rows_update($asondate);
$sucessCnt++;

if($sucessCnt==8)
	{
	$sql1="update `investments`.`alm_data_load_status`  set LoadedTs=now()  where asondate='$asondate' and data_list='LoansAdvances' ";
	$res1=mysqli_query($conn,$sql1);
	}

}
?>
		<?php
if (isset($_POST['getRefinanceData']))
{
$asondate=$_POST['asondate'];

$sucessCnt=0;
	$connect = mysqli_connect("10.88.1.112","root","","refinance");
	
//Outflows - Refinances - 4.3
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
			 b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid) t, refinance.inst_table r where t.RefId=r.RefId and t.Refinance_agency='NABARD' group by refId) c group by classification";
		//echo $qry;
		$res=mysqli_query($connect,$qry);
		$cnt=0;
		$totOs=0;
		while ($row=mysqli_fetch_row($res))
		    {
		    $period[$row[1]]=$row[0];
		    $totOs+=$row[0];
		    $cnt++;
		    }
$sql1="update investments.alm_appendix1_maturity_profile_liquidity  
		set RM_1D_to_14D='$period[1]', RM_15D_to_28D='$period[2]', RM_29D_to_3M='$period[3]',RM_3M_to_6M='$period[4]', RM_6M_to_1Y='$period[5]', RM_1Y_to_3Y='$period[6]', RM_3Y_to_5Y='$period[7]',RM_OVER_5Y='$period[8]', RM_TOTAL='$totOs' where asondate='$asondate' and DisplayOrder=11 ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

//Outflows - Other_Refinances - 4.4
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
			 b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid) t, refinance.inst_table r where t.RefId=r.RefId and t.Refinance_agency<>'NABARD' group by refId) c group by classification";
		//echo $qry;
		$res=mysqli_query($connect,$qry);
		$cnt=0;
		$totOs1=0;
		while ($row=mysqli_fetch_row($res))
		    {
		    $period1[$row[1]]=$row[0];
		    $totOs1+=$row[0];
		    $cnt++;
		    }
$sql1="update investments.alm_appendix1_maturity_profile_liquidity  
		set RM_1D_to_14D='$period1[1]', RM_15D_to_28D='$period1[2]', RM_29D_to_3M='$period1[3]',RM_3M_to_6M='$period1[4]', RM_6M_to_1Y='$period1[5]', RM_1Y_to_3Y='$period1[6]', RM_3Y_to_5Y='$period1[7]',RM_OVER_5Y='$period1[8]', RM_TOTAL='$totOs1' where asondate='$asondate' and DisplayOrder=12 ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

//Outflows - Borrowings - 4
$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (9,10,11,12) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=8 ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;


//Outflows - Interest Payable - 11
	   $qry="select SUM(c.intr_pbl),classification from (select t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,max(r.inst_date),'$asondate',
			datediff(max(r.inst_date),'$asondate') as 'days',((t.Interest/36500)*DATEDIFF(MAX(r.inst_date),'$asondate')*t.outStanding) intr_pbl,
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
			 b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid) t, refinance.inst_table r where t.RefId=r.RefId and t.Refinance_agency='NABARD' group by refId) c group by classification";
		//echo $qry;
		$res=mysqli_query($connect,$qry);
		$cnt=0;
		$totOs1=0;
		while ($row=mysqli_fetch_row($res))
		    {
		    $period1[$row[1]]=$row[0];
		    $totOs1+=$row[0];
		    $cnt++;
		    }
$sql1="update investments.alm_appendix1_maturity_profile_liquidity  
		set RM_1D_to_14D='$period1[1]', RM_15D_to_28D='$period1[2]', RM_29D_to_3M='$period1[3]',RM_3M_to_6M='$period1[4]', RM_6M_to_1Y='$period1[5]', RM_1Y_to_3Y='$period1[6]', RM_3Y_to_5Y='$period1[7]',RM_OVER_5Y='$period1[8]', RM_TOTAL='$totOs1' where asondate='$asondate' and DisplayOrder=25 ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

//Outflows - Others_Interest Payable - 12
	   $qry="select SUM(c.intr_pbl),classification from (select t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,max(r.inst_date),'$asondate',
			datediff(max(r.inst_date),'$asondate') as 'days',((t.Interest/36500)*DATEDIFF(MAX(r.inst_date),'$asondate')*t.outStanding) intr_pbl,
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
			 b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid) t, refinance.inst_table r where t.RefId=r.RefId and t.Refinance_agency<>'NABARD' group by refId) c group by classification";
		//echo $qry;
		$res=mysqli_query($connect,$qry);
		$cnt=0;
		$totOs1=0;
		while ($row=mysqli_fetch_row($res))
		    {
		    $period1[$row[1]]=$row[0];
		    $totOs1+=$row[0];
		    $cnt++;
		    }
$sql1="update investments.alm_appendix1_maturity_profile_liquidity  
		set RM_1D_to_14D='$period1[1]', RM_15D_to_28D='$period1[2]', RM_29D_to_3M='$period1[3]',RM_3M_to_6M='$period1[4]', RM_6M_to_1Y='$period1[5]', RM_1Y_to_3Y='$period1[6]', RM_3Y_to_5Y='$period1[7]',RM_OVER_5Y='$period1[8]', RM_TOTAL='$totOs1' where asondate='$asondate' and DisplayOrder=26 ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;



//Outflows - Total - 13
$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24,25,26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);
if(!$res1)
 die("Failed : $sql1");
$sucessCnt++;

if ($sucessCnt==6)
	{
	$sql1="update `investments`.`alm_data_load_status`  set LoadedTs=now()  where asondate='$asondate' and data_list='Refinance' ";
	$res1=mysqli_query($conn,$sql1);
	}
}
?>



<?php
if (isset($_POST['updateAcc']))
{
$DisplayOrder=$_POST['DisplayOrder'];
$fldCnt=$_POST['fldCnt'];
$asondate=$_POST['asondate'];
//echo "<script>alert($fldCnt);</script>";
//$val1[]=0;
$i1=0;
$tot=0;
for($i=3; $i<$fldCnt-2; $i++)
{
$varName="varName$i";
$val1[$i1]=$_POST[$varName];
$tot+=$val1[$i1];//$_POST[$varName];
$i1++;
//echo "<script>alert('" . $_POST[$varName] . "');</script>";
//echo "<script>alert('" . $val1[$i1] . "');</script>";
//echo $val[$i];
}


$sql="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$val1[0]',	RM_15D_to_28D='$val1[1]',	RM_29D_to_3M='$val1[2]',	RM_3M_to_6M='$val1[3]',	RM_6M_to_1Y='$val1[4]',	RM_1Y_to_3Y='$val1[5]',	RM_3Y_to_5Y='$val1[6]',	RM_OVER_5Y='$val1[7]',	RM_TOTAL='$tot' where asondate='$asondate' and DisplayOrder=$DisplayOrder";
//echo $sql;
$res=mysqli_query($conn,$sql);


if ($DisplayOrder>=4 && $DisplayOrder<=7)
 {
 bulk_update(3,$asondate);
 //bulk_update(27,$asondate);
 }
elseif ($DisplayOrder>=9 && $DisplayOrder<=12)
 {
 bulk_update(8,$asondate);
 //bulk_update(27,$asondate);
 }
elseif ($DisplayOrder>=14 && $DisplayOrder<=17)
 {
 bulk_update(13,$asondate);
 //bulk_update(27,$asondate);
 }
elseif ($DisplayOrder>=19 && $DisplayOrder<=20)
 {
 bulk_update(18,$asondate);
 //bulk_update(27,$asondate);
 }
elseif ($DisplayOrder>=31 && $DisplayOrder<=32)
 {
 bulk_update(30,$asondate);
 //bulk_update(49,$asondate);
 }
elseif ($DisplayOrder>=35 && $DisplayOrder<=37)
 {
 bulk_update(34,$asondate);
 //bulk_update(49,$asondate);
 }
elseif ($DisplayOrder>=41 && $DisplayOrder<=43)
 {
 bulk_update(40,$asondate);
 //bulk_update(49,$asondate);
 }

if ($DisplayOrder<27)
 bulk_update(27,$asondate);
if ($DisplayOrder>=30 && $DisplayOrder<49)
 bulk_update(49,$asondate);

last3_rows_update($asondate);

}
?>

<?php
$sql3="SELECT DLEntryId, if(LoadedTS>'0000-00-00 00:00:00','<b style=\"color: green;text-align: center; font-size: 20px\">&#128505;</b>','<b style=\"color: red;text-align: center; font-size: 20px\">&#128503;</b>') from  investments.alm_data_load_status where asondate='$asondate1' order by DLEntryId ";

$result3=mysqli_query($conn,$sql3);
$rowStt=output_of_query($sql3);

?>



<h2>Appendix-I - Statement of Structural Liquidity</h2>
<form action="" enctype="multipart/form-data" method="post">
	<table class="table table-hover table-bordered table-condensed " align="center" >
		<tr>
			<th colspan="3">Position as on</th>
			<?php
			if (isset($_POST['showAsondate']))
			 $asondate=$_POST['asondate'];
			$checkDate=date("Y-m-d",strtotime("$asondate +1 day"));
			?>
			<th><input name="asondate" class='form-control' type="date" value="<?php echo $asondate; ?>" max="<?php echo $asondate1; ?>" /></th>
			<th><input name="showAsondate" class='btn btn-primary btn-lg' type="submit" value="show Data" style="width:100%" /></th>
		</tr>
<?php
if ($editId)
{
?>
		<tr>
			<th><?php echo $cnoCnt++; ?></th>
			<th>Trial Balance</th>
			<td>Available Dates <?php
	$sql="select distinct run_date from mis.dailyweekly ";
	$res=mysqli_query($conn,$sql);
	$row=mysqli_fetch_row($res);
	echo " | $row[0] ";
	if ($row[0]==$checkDate )
	 $disp="Block"; 
	else
	 $disp="none"; 
	?></td>
			<td style="text-align: center"><?php $rowSttCnt++; echo $rowStt[$rowSttCnt][1]; ?>  </td>
			<th><input id="submitTRBId" name="submitTRB" class='btn btn-primary btn-lg' type="submit" value="Update TRB"  style="width:100%; display: <?php echo $disp; ?>"  /></th>
		</tr>

		<tr>
			<th><?php echo $cnoCnt++; ?></th>
			<th>Investments</th>
			<td>Bonds, SLR, Mutual Funds, TDRs, Current A/c - Settlements, Refinances</td>
			<td style="text-align: center"><?php $rowSttCnt++; echo $rowStt[$rowSttCnt][1]; ?> </td>
			<th><input name="UpdateInv" class='btn btn-primary btn-lg' type="submit" value="Update Investments"  style="width:100%"  /></th>
		</tr>
		<tr>
			<th><?php echo $cnoCnt++; ?></th>
			<th>Residual Maturites of Deposits </th>
			<td>Select, Extract and Upload file from <br> \\10.88.1.33\ftp\cdc\unsplitrep\<?php echo date("Ymd",strtotime($asondate)); ?>\trmm0403.prt <input name="Attach_trmm0403" class='form-control' type="file" onblur="document.getElementById('submitTrmm0403Id').style.display='block';" /></td>
			<td style="text-align: center"><?php $rowSttCnt++; echo $rowStt[$rowSttCnt][1]; ?> </td>
			<th>
			<input id="submitTrmm0403Id" name="submitTrmm0403" class='btn btn-primary btn-lg' type="submit" value="Upload file"  style="width:100%;display: none" /></th>
		</tr>
		<tr>
			<th><?php echo $cnoCnt++; ?></th>
			<th>Advances &amp; NPA </th>
			<td>Available Dates <?php
			$sql="select distinct run_date from mis.npa ";
			//echo $sql;
			$res=mysqli_query($conn,$sql);
			$row=mysqli_fetch_row($res);
			echo " | $row[0]";
			if ($row[0]==$checkDate)
			 $disp="Block"; 
			else
			 $disp="none"; 
	?></td>
			<td style="text-align: center"><?php $rowSttCnt++; echo $rowStt[$rowSttCnt][1]; ?> </td>
			<th>
			<input name="submitNPAMonthend" class='btn btn-primary btn-lg' type="submit" value="Update Advances / NPA"  style="width:100%; display:<?php echo $disp; ?>"  /></th>
		</tr>
		<tr>
			<th><?php echo $cnoCnt++; ?></th>
			<th>Refinance </th>
			<td>Refinances</td>
			<td style="text-align: center"><?php $rowSttCnt++; echo $rowStt[$rowSttCnt][1]; ?> </td>
			<th>
			<input name="getRefinanceData" class='btn btn-primary btn-lg' type="submit" value="Update Refinance"  style="width:100%"  /></th>
		</tr>
<?php
}
?>

	</table>
</form>



<?php
if (isset($_POST['showAsondate']))
 $asondate=$_POST['asondate'];

//$asondate=date("Y-m-t",strtotime($asondate));

$file="ALM_Appendix1_" . date("Ymd",strtotime($asondate)) . ".xls";
echo "<h2> " . date("d-F-Y",strtotime($asondate)) . "</h2>";
$test="<h3> Statement of Structural Liquidity as on $asondate </h3>";
$sql="select DisplayOrder as 'S.No.',OrderNo,	sub_Category as 'Segments',	RM_1D_to_14D,	RM_15D_to_28D,	RM_29D_to_3M,	RM_3M_to_6M,	RM_6M_to_1Y,	RM_1Y_to_3Y,	RM_3Y_to_5Y,	RM_OVER_5Y,	RM_TOTAL,UpdatedTS as 'Status' from investments.alm_appendix1_maturity_profile_liquidity where asondate='$asondate' order by DisplayOrder ";
//echo $sql;
$res=mysqli_query($conn,$sql);
$rowCnt=mysqli_num_rows($res);
if ($rowCnt==0)
 die("<h2>No Records</h2>");
?>

<!--<form action='/mis/pdf/index.php' method="POST" target="_blank">
<input name="qry" class='form-control' type="text" value="<?php //echo $sql; ?>" style="display:none" />
<input name="Submit1" class='btn btn-primary btn-lg' type="submit" value="SaveAsPdf" /></form>

--><?php
echo "<center><br><table class='table table-hover table-bordered' border='1' style='width: 80%'><tr>";      
$test=$test . "<center><br><table class='table table-hover table-bordered' border='1' ><tr>";      

// printing table headers
$fields_num1 = mysqli_num_fields($res);
for($i=0; $i<$fields_num1; $i++)
{
    $field = mysqli_fetch_field($res);
    echo "<th>{$field->name}</th>";
    $test=$test .  "<th>{$field->name}</th>";
}
echo "</tr>";
$test=$test . "</tr>";

echo "<tr style='background-color: lightblue ' ><td></td><td></td><td><b>Outflows</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
$test=$test .  "<tr style='background-color: lightblue ' ><td></td><td></td><td><b>Outflows</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";

$row_chk=0;
$highlight_rows=array(1,2,3,8,13,18,31,40);
$pendingCnt=0;

		$count = mysqli_num_rows($res);


$not_to_edit=array(3,8,13,18,27,30,34,40,49,50,51,52);
 
while($row = mysqli_fetch_row($res))
{
    $row_chk=$row_chk + 1;
    $frmId="frmId" . $row_chk;
    $tblTrId="tblTrId" . $row_chk;
    //if ($row_chk==27 || $row_chk>=49)
    // echo "<tr style='background-color: lightblue; font-weight: bold ' ><td>$row_chk</td>";
    //else
     echo "<tr id='$tblTrId' ondblclick='enableEdit($row_chk,$count)'><form class='form-inline' id='$frmId' method='post' >";
    $test=$test .  "<tr>";
    $cnt=0;
    
    
    foreach($row as $cell)
	     {
	     $varName="varName" . $cnt;
	     //$field = mysqli_fetch_field($res);
		if ($editId && $cnt>2 && !in_array($row_chk, $not_to_edit))
		 $val="<input class='form-control' type='number' step='0.01' name='$varName' title='$varName' value='$row[$cnt]' style='border:none; background: none; text-align: right; height: 3vh' />";
		elseif($cnt>2 && $row[0]<52)
		 		$val="<div style='cursor: not-allowed; text-align: right' >" . indian_money_format($row[$cnt],2) . "</div>";
		 	else
		 		$val="<div style='cursor: not-allowed' >$row[$cnt]</div>";
	     $cnt++;

	     if ($cnt>3 && $cnt<$i)
		      {
		      if (in_array($row_chk, $not_to_edit) ) //|| $cnt==$i
		       echo "<td style='background-color: lightblue'>$val</td>";
		      else
		       echo "<td>$val</td>";
		      }
	     else
		      {
		      if ($cnt==$i)
			       {
			       echo "<td style='display: flex; justify-content: flex-start; vertical-align:middle '>";
			       if ($cell > "0000-00-00 00:00:00")
			        echo "<b style='text-align: center; color: green; font-size: 20px'>&#128504;</b>";
			       else 
			        {
			        $pendingCnt++;
			        echo "<b style='text-align: center; color: red; font-size: 20px '>&#128502;</b>";
			        }
			        if($editId)// && !in_array($row_chk, $not_to_edit))
			        {
			        //echo !in_array($row_chk, $not_to_edit);
			        if (in_array($row_chk, $not_to_edit))
				     echo "<div   id='edit_$row_chk'  style=' vertical-align:middle; display: none'></div>";
				    else
			         {
			         $DisplayOrder=$row[0];
			       	 echo "<input id='edit_$row_chk' name='updateAcc' type='submit' value='Update - $DisplayOrder' style=' vertical-align:middle; display: none' class='btn btn-primary btn-lg' />"; 
			       	 echo "<input name='asondate' class='form-control' type='text' value='$asondate' style=' display: none' />"; 
				     echo "<input name='DisplayOrder' class='form-control' type='text' value='$DisplayOrder'  style='display: none'  /><input name='fldCnt' class='form-control' type='text' value='$fields_num1'  style='display: none'   />";
				     }
				   }
				   echo "</td>";
			       }
		      else
		       echo "<td>$val</td>";
		      } 
		 $test=$test . "<td>$cell</td>";
	     }
     
    echo "</form></tr>";
    if ($row_chk==27)
     {
     echo "<tr style='background-color: lightblue' ><td></td><td></td><td><b>Inflows</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
     $test=$test . "<tr style='background-color: lightblue' ><td></td><td></td><td><b>Inflows</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
     }
}
echo "<b>No. of Pending Entries : $pendingCnt</b>";
echo "</table>";
$test=$test . "</table>";

?>






<script>
function enableEdit(i,j)
{
//alert(i);
for(i1=1;i1<=j;i1++)
 {
 var edit="edit_" + i1;
 var tblTrId="tblTrId" + i1;
 document.getElementById(edit).style.display="none";
 document.getElementById(tblTrId).style.backgroundColor="transparent";
 }

var edit="edit_" + i;
var tblTrId="tblTrId" + i;
//alert(edit);
document.getElementById(edit).style.display="Block";
document.getElementById(tblTrId).style.backgroundColor="lightyellow";
}
</script>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . '\mis\saveBtn.php';
?>


<br><br>
</body>

</html>
