<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php
$fnameTitle=basename($_SERVER['SCRIPT_NAME'],".php");
echo "<title> $fnameTitle | ALM </title>";
?>
</head>
<?php
include 'index.php';



?>

<body>
	<h2>Load Data Module</h2>
		<b style='color:red'>
			Note: <ul>
				<li>For asonDate : <?php echo date("Y-m-d",strtotime("-1 day")); ?> - use tables - mis.dailyweekly / mis.npa</li>
				<li>For specific date - load and use tables - investments.dailyweekly_date / investments.npa_date</li>
			</ul>
		</b>
<?php 
	$prevDate=date("Y-m-d",strtotime("-1 day"));
	// $asondate = $_POST['asondate'];
	$asondate = isset($_POST['asondate']) ? $_POST['asondate'] : date("Y-m-d",strtotime("-1 day"));
	if ($prevDate == $asondate) {
		$dailyweeklyTbl = "mis.dailyweekly";
		$npaTbl = "mis.npa";
		}	
	else {
		$tmpDate = date("dmY",strtotime($asondate));
		$dailyweeklyTbl = "investments.dailyweekly_$tmpDate";
		$npaTbl = "investments.npa_$tmpDate";		
	} 
	// $dailyweeklyTbl = isset($_POST['dailyweeklyTbl']) ? $_POST['dailyweeklyTbl'] : "mis.dailyweekly";
	// $npaTbl = isset($_POST['npaTbl']) ? $_POST['npaTbl'] : "mis.npa";
	$trmm0403 = isset($_POST['trmm0403.prt']) ? $_POST['trmm0403.prt'] : "investments.trmm0403";
 ?>
<form class="form-inline text-center" method="post" enctype="multipart/form-data"  >
<div style="display:flex;justify-content: space-evenly;align-items: center;">
	<div>
		<label class="control-label">As on Date</label><br>
		<input class="form-control" type="date" name="asondate"  value="<?php echo $asondate; ?>" required>		
	</div>
	<div>
		<label class="control-label">Trial Balance</label><br>
		<input class="form-control" type="text" name="dailyweeklyTbl" value="<?php echo $dailyweeklyTbl; ?>" required>		
	</div>
	<div>
		<label class="control-label">Advances &amp; NPA</label><br>
		<input class="form-control" type="text" name="npaTbl" value="<?php echo $npaTbl; ?>" required>		
	</div>	
<!-- 	<div>
		<label class="control-label">Residual Maturites of Deposits</label><br>
		<input class="form-control" type="text" name="trmm0403" value="<?php echo $trmm0403; ?>" required>		
	</div> -->
	<div>
		<label class="control-label">Residual Maturites of Deposits</label><br>
		<input class="form-control" type="file" name="trmm0403" value="Upload file"  ><br>	
		<label class="control-label">Select, Extract and Upload file from <br> \\10.88.1.33\ftp\cdc\unsplitrep\<?php echo date("Ymd",strtotime($asondate)); ?>\trmm0403.prt</label>
	</div>
	<input class="form-control btn btn-primary" type="submit" name="LoadData" value="Load Data">	
	<!-- <input class="form-control btn btn-primary" type="submit" name="BulkUpdate" value="BulkUpdate">	 -->
	<!-- <div class="form-control btn btn-info" onclick="loadALM();" >Load Data</div>	 -->
</div>

</form>
<hr>
<form class="form-inline text-center" method="post" enctype="multipart/form-data"  >
<div style="display:flex;justify-content: space-evenly;align-items: center;">
	<div>
		<label class="control-label">As on Date</label><br>
		<input class="form-control" type="date" name="asondate"  value="<?php echo $asondate; ?>" required>		
	</div>
	<input class="form-control btn btn-primary" type="submit" name="alm_BulkUpdate" value="BulkUpdate">	
</div>

</form>
<hr>
<?php 
// error_reporting(1);
if(isset($_POST['LoadData'])){
	if(isset($_POST['LoadData']))
		include 'alm_logic.php';
}

elseif(isset($_POST['alm_BulkUpdate'])){
$asondate=$_POST['asondate'];
bulk_update(3,$asondate);
bulk_update(8,$asondate);
bulk_update(13,$asondate);
bulk_update(18,$asondate);
bulk_update(27,$asondate);
bulk_update(30,$asondate);
bulk_update(34,$asondate);
bulk_update(40,$asondate);
bulk_update(49,$asondate);   
last3_rows_update($asondate); 
}

else
	include 'alm_show.php';

?>

<!-- <script type="text/javascript">
function loadALM(){
	fetch(`alm_logic.php?`);
}
</script>
 -->
<!-- 

-- Loading loan balance file from reports

CREATE TABLE `investments`.`npa_30062022` LIKE investments.npa;
 
LOAD DATA  INFILE 'F:/MISDATA/deposit30062022.TXT' 
INTO TABLE `investments`.`npa_30062022` FIELDS TERMINATED BY '$$' LINES TERMINATED BY '\n' 
(@col1,@col2,@col3,@col4,@col5,@col6,@col7,@col8,@col9,@col10,@col11,@col12,@col13,@col14,@col15,@col16,@col17,@col18,@col19,@col20,@col21,@col22,@col23,@col24,@col25) 
SET  RUN_DATE=CONCAT(RIGHT(TRIM(@col1),4),'-',RIGHT(LEFT(TRIM(@col1),5),2),'-',LEFT(TRIM(@col1),2)),BRCODE=TRIM(@col2),ACCOUNT_NO=TRIM(@col3),
ACCOUNT_TYPE=TRIM(@col4),CUSTOMER_NAME=TRIM(@col5),IRATE=TRIM(@col6),`LIMIT`=TRIM(@col7),IRREGULARITY=TRIM(@col8),IRAC_N=TRIM(@col9),
IRAC_O=TRIM(@col10),BALANCE=TRIM(@col11),SAN_DT=TRIM(@col12),CCOD_TLDL=TRIM(@col13),CRDR=TRIM(@col14),ExpiryDate=TRIM(@col15),
SancLimit=TRIM(@col16),CIF=TRIM(@col17),Product=TRIM(@col18),STATUS=TRIM(@col19),Mobile=TRIM(@col20),Aadhar=TRIM(@col21),
PAN=TRIM(@col22),HomeBranch=TRIM(@col23),AcctBranch=TRIM(@col24),LstCrDate=TRIM(@col25)";
$stt = $conn111->prepare($sql);
$stt->execute();

LOAD DATA INFILE 'F:/MISDATA/lond30062022.TXT' 
INTO TABLE `investments`.`npa_30062022` FIELDS TERMINATED BY '$$' LINES TERMINATED BY '\n' 
(@col1,@col2,@col3,@col4,@col5,@col6,@col7,@col8,@col9,@col10,@col11,@col12,@col13,@col14,@col15,@col16,@col17,@col18,@col19,@col20,@col21,@col22,@col23,@col24,@col25) 
SET RUN_DATE=CONCAT(RIGHT(TRIM(@col1),4),'-',RIGHT(LEFT(TRIM(@col1),5),2),'-',LEFT(TRIM(@col1),2)),BRCODE=TRIM(@col2),ACCOUNT_NO=TRIM(@col3),ACCOUNT_TYPE=TRIM(@col4),
CUSTOMER_NAME=TRIM(@col5),IRATE=TRIM(@col6),`LIMIT`=TRIM(@col7),IRREGULARITY=TRIM(@col8),IRAC_N=TRIM(@col9),IRAC_O=TRIM(@col10),BALANCE=TRIM(@col11),
SAN_DT=TRIM(@col12),CCOD_TLDL=TRIM(@col13),CRDR=TRIM(@col14),ExpiryDate=TRIM(@col15),SancLimit=TRIM(@col16),CIF=TRIM(@col17),Product=TRIM(@col18),
STATUS=TRIM(@col19),Mobile=TRIM(@col20),Aadhar=TRIM(@col21),PAN=TRIM(@col22),HomeBranch=TRIM(@col23),AcctBranch=TRIM(@col24),LstCrDate=TRIM(@col25);
-- end of loading 


-->

</body>
</html>