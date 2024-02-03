n                                                      <!DOCTYPE HTML>
<html lang="en">

<head>
<?php
$fnameTitle=basename($_SERVER['SCRIPT_NAME'],".php");
echo "<title> $fnameTitle | ALM </title>";
?>
</head>

<script type="text/javascript">
	
function  get_the_data_from_112(query_string)
{

var set_the_data;

/*fetch('http://10.88.1.112/112_api.php?func_name=alm_data_for_refinance_data&in_data='+query_string).then( res => res.json() ).then( d  => {
set_the_data = JSON.stringify(d);
document.getElementById('refinance').value = set_the_data ;
document.sub_this_form_of_refin_data.submit();
} );
*/

fetch('http://10.88.1.112/112_api.php?func_name=alm_data_for_refinance_data&in_data='+query_string).then( res => res.json() ).then( d  =>console.log(d))

}

</script>
<form id="sub_this_form_of_refin_data" method="post" name="sub_this_form_of_refin_data">
	<input id="refinance" name="refinace_data" type="hidden" />
</form>
<body>

<?php
include 'index.php';
include 'update_functions.php';




$sql2="SELECT distinct asondate,sum(case when UpdatedTS>'0000-00-00 00:00:00' then 1 else 0 end) from  investments.alm_appendix1_maturity_profile_liquidity group by asondate order by asondate desc limit 1";
$result2=mysqli_query($conn,$sql2);
$row2=mysqli_fetch_row($result2);
$asondate1=$row2[0];
$asondate1_cnt=$row2[1];


if ($asondate1_cnt<52)
 $asondate=$asondate1;
else
 {
 $asondate=date("Y-m-t",strtotime("$asondate1 +1 day"));
 $sql_ins="insert into investments.alm_appendix1_maturity_profile_liquidity(OrderNo, op_mode, Category, sub_Category,asondate,DisplayOrder) select OrderNo, op_mode, Category, sub_Category,'$asondate',DisplayOrder from investments.alm_appendix1_model order by DisplayOrder";
 $res_ins=mysqli_query($conn,$sql_ins);
 $sql_ins="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D=0,RM_15D_to_28D=0,RM_29D_to_3M=0, RM_3M_to_6M=0,RM_6M_to_1Y=0, RM_1Y_to_3Y=0, RM_3Y_to_5Y=0, RM_OVER_5Y=0, RM_TOTAL=0 where asondate='$asondate' and Comments='NA' ";
 $res_ins=mysqli_query($conn,$sql_ins);
 
 }

$cnoCnt=1;

$sql3="SELECT sum(if(OrderNo=1,RM_TOTAL,0)),sum(if (OrderNo=2,RM_TOTAL,0))  from  investments.alm_appendix1_maturity_profile_liquidity where OrderNo<=2 and asondate='$asondate1' and op_mode='Outflows'";
$result3=mysqli_query($conn,$sql3);
$row3=mysqli_fetch_row($result3);
$capital=$row3[0];
$reserves_surplus=$row3[1];

//$asondate=$_POST['asondate'];
$asondate1=date("Y-m",strtotime($asondate));

?>
<h2>Appendix-I - Statement of Structural Liquidity</h2>
<form action="" enctype="multipart/form-data" method="post">
	<table align="center" class="hoverTable">
		<tr>
			<td><?php echo $cnoCnt++; ?></td>
			<td>As on Month-End</td>
			<td>Source</td>
			<td>
			<input name="asondate" type="month" value="<?php echo $asondate1; ?>" /></td>
			<td><input name="showAsondate" type="submit" value="show Data" /></td>
		</tr>
		<tr>
			<td><?php echo $cnoCnt++; ?></td>
			<td>Trial Balance</td>
			<td>Available Dates:<br><?php
	$sql="select distinct run_date from investments.dailyweekly_monthend where run_date>='$asondate' order by  run_date asc";
	$res=mysqli_query($conn,$sql);
	while ($row=mysqli_fetch_row($res))
	    echo " | $row[0]";
	?></td>
			<td>Attach File :<input name="Attach_trb" type="file" /></td>
			<td><input name="submitTRB" type="submit" value="Submit Data" /></td>
		</tr>
		<?php
if (isset($_POST['submitTRB']))
{
$asondate=$_POST['asondate'];
$asondate=date("Y-m-t",strtotime($asondate));

ini_set('upload_max_filesize','100M');
$uploaddir = 'C:/wamp/www/mis/Departments/HeadOffice/ALM/Uploads/';
$attach_trb=basename($_FILES["Attach_trb"]["name"]);
$trb_file=$uploaddir . $attach_trb;
if (file_exists($trb_file))
{
unlink($trb_file);
$res3=move_uploaded_file($_FILES["Attach_trb"]["tmp_name"], $trb_file);
}
$handle_trb = fopen($trb_file , "r");

$attach_trb1="TRIAL_BALANCE_REPORT.prt";
$trb_file1=$uploaddir . $attach_trb1;

$sql_del="delete from investments.dailyweekly_monthend where RUN_DATE='$asondate'";
$res_del=mysqli_query($conn,$sql_del);

$sql_ld="LOAD DATA LOCAL INFILE '$trb_file1' INTO TABLE investments.dailyweekly_monthend 
(@col1) 
set  
RUN_DATE='$asondate',
CGL_ACC_NO=trim(substr(@col1,13,10)),
ACC_TYPE=trim(substr(@col1,25,13)),
DR_BAL=trim(substr(@col1,62,27)),
CR_BAL=trim(substr(@col1,89,19))";

//echo $sql_ld;
$res_ld=mysqli_query($conn,$sql_ld);

$sql_del="delete from investments.dailyweekly_monthend where RUN_DATE='$asondate' and ACC_TYPE<>'ACCOUNT TOTAL' ";
$res_del=mysqli_query($conn,$sql_del);

$sql_up="update investments.dailyweekly_monthend d,mis.cgllist c set d.balance=(d.dr-bal+d.cr_bal),  d.ACC_TYPE=c.ACC_TYPE, d.LEVEL3=c.LEVEL3, d.LEVEL2=c.LEVEL2, d.LEVEL1=c.LEVEL1 where RUN_DATE='$asondate' and  d.CGL_ACC_NO=c.CGL_ACC_NO";
$res_up=mysqli_query($conn,$sql_up);


$sql1="select sum(balance) from investments.dailyweekly_monthend  where run_date='$asondate' and cgl_acc_no in (2001070601 , 2001500001 , 2001505001 , 2001500901 , 2001500401 , 2001500301 , 2001500701 , 2001030601 , 2001500501 , 2001080601)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
update_out_3.1($row1[0]);

$sql1="select sum(balance) from investments.dailyweekly_monthend  where run_date='$asondate' and cgl_acc_no in (
2006030601 , 2006070601 , 2006080601 , 2006500001 , 2006500301 , 2006500701 , 2006500901 , 2006505001 , 2387070601 , 2422070601 , 2425070601 , 2006500101 , 2420070601 , 2423070601 , 2381070601 , 2382070601 , 2385070601 , 2387505001 , 2388070601 , 2388500301 , 2388505001 , 2390070601 , 2384500301 , 2389070601 , 2381030601 , 2387030601 , 2006500501 , 2381505001 , 2383070601 , 2384070601 , 2387080601 , 2384500001 , 2388500001 , 2388500901 , 2421070601 , 2424070601 , 2381500101 , 2387500301 , 2383500001 , 2381500301 , 2382505001 , 2006500401 , 2382500301 , 2383500301 , 2382500001 , 2386070601 , 2381500001 , 2387500001)";
$res1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_row($res1);
update_out_3.2($row1[0]);





/*?



$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24,25,26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);
*/
}
?>
		<!--<tr>
	<td><?php echo $cnoCnt++; ?></td>
	<td>Capital (Out-1)</td>
	<td>Previous Month / Accounts Dept.</td>
	<td><input name="capital" type="text" value="<?php echo $capital; ?>" /></td>
	<td rowspan="2"><input name="submitCapital" type="submit" value="Submit Data" /></td>
</tr>
-->
		<!--<tr>
	<td><?php echo $cnoCnt++; ?></td>
	<td>Reserves and Surplus (Out-2)</td>
	<td>Previous Month / Accounts Dept.</td>
	<td><input name="reserves_surplus" type="text" value="<?php echo $reserves_surplus; ?>" /></td>
</tr>
-->
		<!--<tr>
	<td><?php echo $cnoCnt++; ?></td>
	<td>Current Deposits (Out-3.1) - L01A <br> Savings Bank (Out-3.2) - L01D <br> Cash Balance (In-1) - A01</td>
	<td>Upload \\10.88.1.33\ftp\cdc\reports\[As on Date]\GL_REPORTS\PRT.RPTJPRNT Report</td>
	<td>Attach File :<input name="Attach_dailyweekly" type="file" /></td>
	<td><input name="submitDailyWeekly" type="submit" value="Submit Data" /></td>
</tr>
--><?php
if(isset($_POST["submitDailyWeekly"]))
{
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



$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$A01', RM_TOTAL='$A01' where DisplayOrder=28 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);

$sql1="select sum(balance) from investments.dailyweekly_monthend where LEVEL2='FIXED ASSETS' and date_sub(run_date,'interval 1 day')='$asondate' ";
$res1=mysqli_query($conn,$sql1);
$tot_with_RBI=$excess_CRR+$ca_with_RBI;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$excess_CRR',RM_15D_to_28D='$ca_with_RBI', RM_TOTAL='$tot_with_RBI' where DisplayOrder=29 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);



$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24,25,26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);

}
?>
		<tr>
			<td><?php echo $cnoCnt++; ?></td>
			<td>Residual Maturites of Deposits (Out-3.3) </td>
			<td>Upload \\10.88.1.33\ftp\cdc\unsplitrep\[As on Date]\trmm0403 Report</td>
			<td>Attach File :<input name="Attach_trmm0403" type="file" /></td>
			<td>
			<input name="submitTrmm0403" type="submit" value="Submit Data" /></td>
		</tr>
		<?php
if (isset($_POST['submitTrmm0403']))
{
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
		<tr>
			<td style="height: 42px"><?php echo $cnoCnt++; ?></td>
			<td style="height: 42px">Advances (In-5) <br>NPA (In-6) </td>
			<td style="height: 42px">Available Dates:<br><?php
	$sql="select distinct run_date from mis.npa_monthend where str_to_date(run_date,'%d/%m/%Y')>'$asondate'";
	//echo $sql;
	$res=mysqli_query($conn,$sql);
	while ($row=mysqli_fetch_row($res))
	    echo " | $row[0]";
	?></td>
			<td style="height: 42px"></td>
			<td style="height: 42px">
			<input name="submitNPAMonthend" type="submit" value="Submit Data" /></td>
		</tr>
		<?php
if (isset($_POST['submitNPAMonthend']))
{
$run_date=date("d/m/Y",strtotime("$asondate +1 day"));
/*
$sql="select run_date, 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=14) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>14 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=28) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>29 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=90) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>90 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=180) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>180 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=365) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>365 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=1095) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>1095 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)<=1825) then BALANCE else 0 end),2), 
       round(sum(case when (irac_o>=4 and datediff(str_to_date(run_date,'%d/%m/%Y'),SAN_DT)>1825) then BALANCE else 0 end),2)  
	  from mis.npa_monthend where run_date='$run_date'";
*/	  

$sql="select  
       round(sum(case when irac_o=4 then BALANCE else 0 end),2), 
       round(sum(case when irac_o>4 then BALANCE else 0 end),2)
	  from mis.npa_monthend where run_date='$run_date'";
//echo $sql;
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($res);
$tot_npa=$row[0]+$row[1];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_3Y_to_5Y='$row[0]',	RM_OVER_5Y='$row[1]',	RM_TOTAL='$tot_npa' where DisplayOrder=38 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);

$sql="select  
       round(sum(case when irac_o=4 then BALANCE else 0 end),2), 
       round(sum(case when irac_o>4 then BALANCE else 0 end),2)
	  from mis.npa_monthend where run_date='$run_date'";
//echo $sql;
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($res);
$tot_npa=$row[0]+$row[1];
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_3Y_to_5Y='$row[0]',	RM_OVER_5Y='$row[1]',	RM_TOTAL='$tot_npa' where DisplayOrder=38 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);

}
?>
		<!--<tr>
	<th colspan="5">
	   <?php
	   $qry="select	   
			t.Refinance_agency,
			t.Scheme,
			t.Interest,
			t.RefID,
			t.outStanding,t.Inst_amt,max(r.inst_date),curdate() from 
			(SELECT a.Refinance_agency,a.Scheme,a.Interest,a.RefID,a.Inst_amt,a.outStanding as outStanding FROM refinance.inst_table a, 
			(SELECT min( Inst_date ) mindate,RefID rid FROM refinance.inst_table  WHERE Inst_date >= \'$asondate\' GROUP BY RefID) b 
			where a.Inst_date = b.mindate and a.RefID = b.rid) t, refinance.inst_table r where t.RefId=r.RefId and t.Refinance_agency=\'NABARD\' group by refId";
?>	
 		<script> 
 		var abcd = `<?php echo $qry ?>`;
 		//console.log(abcd )
 		</script>
		<div onclick="get_the_data_from_112( abcd  )" id="testId" >Get Refinance Data
		</div>
	</th>
</tr>
<?php
if(isset($_REQUEST['refinace_data'])){
$res=$_REQUEST['refinace_data'];
var_dump($res);
}
?>
-->
		<tr>
			<td style="height: 42px"><?php echo $cnoCnt++; ?></td>
			<td style="height: 42px">Refinance </td>
			<td style="height: 42px"></td>
			<td style="height: 42px"></td>
			<td style="height: 42px">
			<input name="getRefinanceData" type="submit" value="Get Data" /></td>
		</tr>
	</table>
	<table>
		<?php
if (isset($_POST['getRefinanceData']))
{
	$connect = mysqli_connect("10.88.1.112","root","","refinance");
	
	   $qry="select sum(c.outstanding),classification from (select t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,max(r.inst_date),curdate(),
			datediff(max(r.inst_date),curdate()) as 'days',
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

	   $qry="select sum(c.outstanding),classification from (select t.Refinance_agency,t.Scheme,t.Interest,t.RefID,t.outStanding,max(r.inst_date),curdate(),
			datediff(max(r.inst_date),curdate()) as 'days',
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

$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (9,10,11,12) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=8 ";
$res1=mysqli_query($conn,$sql1);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24,25,26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);

}
?>
	</table>
</form>
<hr><?php
if (isset($_POST['showAsondate']))
 $asondate=$_POST['asondate'];

$asondate=date("Y-m-t",strtotime($asondate));

$file="ALM_Appendix_I.xls";
echo "<h3> Statement of Structural Liquidity as on $asondate </h3>";
$test="<h3> Statement of Structural Liquidity as on $asondate </h3>";
$sql="select OrderNo,	sub_Category as 'Segments',	RM_1D_to_14D,	RM_15D_to_28D,	RM_29D_to_3M,	RM_3M_to_6M,	RM_6M_to_1Y,	RM_1Y_to_3Y,	RM_3Y_to_5Y,	RM_OVER_5Y,	RM_TOTAL,UpdatedTS as 'Status' from investments.alm_appendix1_maturity_profile_liquidity where asondate='$asondate' order by DisplayOrder ";
$res=mysqli_query($conn,$sql);

?>
<!--<form action='/mis/pdf/index.php' method="POST" target="_blank">
<input name="qry" type="text" value="<?php echo $sql; ?>" style="display:none" />
<input name="Submit1" type="submit" value="SaveAsPdf" /></form>

--><?php
echo "<center><br><table class='table table-hover table-bordered' border='1' style='width: 80vw'><tr><th>S.No.</th>";      
$test=$test . "<center><br><table class='table table-hover table-bordered' border='1' style='width: 80vw'><tr><th>S.No.</th>";      

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

 
while($row = mysqli_fetch_row($res))
{
    $row_chk=$row_chk + 1;
    if ($row_chk==27 || $row_chk>=49)
     echo "<tr style='background-color: lightblue; font-weight: bold ' ><td>$row_chk</td>";
    else
     echo "<tr ondblclick='enableEdit($row_chk,$count)'><td>$row_chk</td>";
    $test=$test .  "<tr><td>$row_chk</td>";
    $cnt=0;
    
    
    foreach($row as $cell)
	     {
		if ($pid==1888 && $cnt>1)
		 $val="<input type='number' name='' value='$row[$cnt]' style='border:none; background: none' />";
		else
		 $val=indian_money_format($row[$cnt],2);
	     $cnt++;

	     if ($cnt>2 && $cnt<$i)
		      {
		      if (in_array($row_chk, $highlight_rows) ) //|| $cnt==$i
		       echo "<td style='background-color: transparent'>$val</td>";
		      else
		       echo "<td>$val</td>";
		      }
	     else
		      {
		      if ($cnt==$i)
			       {
			       echo "<td>";
			       if ($cell > "0000-00-00 00:00:00")
			        echo "<h2 style='text-align: center; color: green;'>&#128504;</h2>";
			       else 
			        {
			        $pendingCnt++;
			        echo "<h2 style='text-align: center; color: red; '>&#128502;</h2>";
			        }
			        $entryid=$row_acc['Entry_ID'];
			       	echo "<input id='edit_$row_chk' name='updateAcc' type='submit' value='Update' style='width: 100%; vertical-align:middle; display: none' />"; 
				   echo "<input name='Entry_ID' type='text' value='$entryid' style='display:none' /></td>";
			       }
		      else
		       echo "<td>$val</td>";
		      } 
		 $test=$test . "<td>$cell</td>";
	     }
     
    echo "</tr>";
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
 document.getElementById(edit).style.display="none";
 }

var edit="edit_" + i;
alert(edit);
document.getElementById(edit).style.display="Block";
}
</script>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . '\mis\saveBtn.php';
?>

</body>

</html>
