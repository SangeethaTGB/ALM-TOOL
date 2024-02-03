<!DOCTYPE html>
<html>
<head>		
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/css2.css">
	<link rel="stylesheet" href="css/font.css">
	<link rel="stylesheet" href="css/boot.css">
	<link rel="stylesheet" href="css/table.css">
	<script src="js/jquery_latest.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/Chart.bundle.min.js"></script>
	<script src="js/boot.js"></script>
	<script src="js/datatable.js"></script> 
	<script src="jquery.js"></script>	<script src="jquery.js"></script>
	<title>Trend | ALM</title>
</head>
<style type="text/css">
	div h3 a: hover{
	color: white;
	text-decoration:none;
}
</style>
<body>
<?php
// include $_SERVER['DOCUMENT_ROOT'] . '/commoncssjss/includes/header.php';
include 'CommonCssJs\index.php';
	$displayorder=$_POST['displayorder'];
	$fname=$_POST['fname'];

$connect = $conn;// mysqli_connect("10.88.1.222","root","","investments");


$sql="select max(asondate) from investments.alm_appendix1_maturity_profile_liquidity";
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($res);
$asondate1=$row[0];

$asondate = isset($_POST['asondate']) ? $_POST['asondate'] : $asondate1;

?>
<center>
	<br>
<div style="display: flex; justify-content: space-evenly;">
	<div>
		


<!-- <h2 style="font-weight: bolder; color:green;"></h2> -->
<form class="form-inline text-center" action="" method="post">
	<label class="form-control control-label">Bank Assets & Liabilities as on</label>
	<input name="asondate" class='form-control' type="date" value="<?php echo $asondate; ?>" max="<?php echo $asondate1; ?>" />
	<input name="showAsondate" class='form-control btn btn-info' type="submit" value="Show" />
</form>
	</div>
	<div>
		

<!-- <h2 style="font-weight: bolder; color:green;"></h2> -->
<form class="form-inline" method="post" action="">

<select class="form-control" name="displayorder" required="required">
<option value="">Select the Parameter</option>
<?php
$sql="select distinct displayorder,  sub_category,op_mode from investments.alm_appendix1_model where comments <>'NA' order by displayorder";
$res=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_row($res))
    {
    if ($row[0]==1 || $row[0]==28)
    	echo "<option disabled> -------- $row[2] --------</option>";
    if ($displayorder==$row[0])
     echo "<option value='$row[0]' selected='selected'>$row[1]</option>";
    else
     echo "<option value='$row[0]'>$row[1]</option>";
    }
?>
</select>

<select class="form-control" name="fname" required="required">
<option value="">Select the Time Band</option>
<?php
$showText['RM_TOTAL'] = "Total";
$showText['RM_OVER_5Y'] = "Beyond 5 Years";
$showText['RM_3Y_to_5Y'] = "3 Years to 5 Years";
$showText['RM_1Y_to_3Y'] = "1 Year to 3 Years";
$showText['RM_6M_to_1Y'] = "6 Months to 12 Months";
$showText['RM_3M_to_6M'] = "3 Months to 6 Months";
$showText['RM_29D_to_3M'] = "1 Month to 3 Months";
$showText['RM_15D_to_28D'] = "15 Days to 28 Days";
$showText['RM_1D_to_14D'] = "1 Day to 14 Days";

$sql="select RM_TOTAL,	RM_OVER_5Y,	RM_3Y_to_5Y,	RM_1Y_to_3Y,	RM_6M_to_1Y,	RM_3M_to_6M,	RM_29D_to_3M,	RM_15D_to_28D
, RM_1D_to_14D	 from investments.alm_appendix1_maturity_profile_liquidity limit 1";
$res=mysqli_query($conn,$sql);
while ($field=mysqli_fetch_field($res))
    {
    if ($fname==$field->name)
     echo "<option value='{$field->name}'  selected='selected' >" . $showText[$field->name] . "</option>";
    else
     echo "<option value='{$field->name}'>" . $showText[$field->name] . "</option>";
    }
?>
</select>
<input class="btn btn-success" name="showDetails" type="submit" value="Show Trend " />
</form>
	</div>
</div>
</center>

<!-- <div class="container" > -->
<?php 
if(isset($_POST['showAsondate'])){
	$asondate=$_POST['asondate'];
	// var_dump($asondate);
	include 'alm_show.php';
}
 ?>

	<?php 
	if (isset($_POST['showDetails']))
	{
	
	$chartType="line";
	// $connect = mysqli_connect("localhost","root","","investments");
	
		$sql="select sub_category,op_mode from investments.alm_appendix1_model where displayorder=$displayorder";
		$res=mysqli_query($conn,$sql);
		$row=mysqli_fetch_row($res);

	?>
	
	<h2 style="font-weight: bolder; color:green;"> <center> Trend of <?php echo $row[0]; ?> (<?php echo $row[1]; ?>) - <?php echo $showText[$fname]; ?>  </center></h2>
	
	<?php

	// if ($displayorder==52)
	//  $summary_query = "select sub_category, AsonDate,distinct $fname as Amount from investments.alm_appendix1_maturity_profile_liquidity WHERE displayorder=$displayorder and $fname>0 group by $fname order by asondate";
	// else
	 $summary_query = "select distinct $fname as Amount, sub_category, AsonDate from investments.alm_appendix1_maturity_profile_liquidity WHERE displayorder=$displayorder and $fname>0 group by round($fname/10000000,0) order by asondate";
	
	// echo $summary_query;

	//$summary_query = "select AsonDate,RM_1D_to_14D a1,RM_29D_to_3M a2,RM_3M_to_6M a3,RM_6M_to_1Y a4,RM_1Y_to_3Y a5,RM_3Y_to_5Y a6,RM_OVER_5Y a7,RM_TOTAL a8 from investments.alm_appendix1_maturity_profile_liquidity WHERE displayorder=$displayorder order by asondate";
	$exec_summ = mysqli_query($connect,$summary_query);
	$summary_op = mysqli_fetch_all($exec_summ,MYSQLI_ASSOC); 
	echo "<br>";
 	$fields = mysqli_fetch_fields($exec_summ); 
 	 // var_dump($fields); 
 	$length = sizeof($summary_op);
	echo "<br>"; 
 

$val_arr = array();
$stat_arr =array("Data1","Data2");
$count_arr = array();

$cnt=0;
	foreach ($summary_op as $key => $value) 
		{
	 	$val_arr[date("d-M-Y",strtotime($value['AsonDate']))] =($displayorder==52)? $value['Amount'] : round($value['Amount']/10000000,0); 
	 	$count_arr = $value['Amount']; 
	 	$cnt++;
		}
$val_arr1 = array();
$count_arr1 = array();
$cnt=0;
	foreach ($summary_op as $key => $value) 
		{
	 	$val_arr1[date("d-M-Y",strtotime($value['AsonDate']))] = round($value['Amount']/1000000,0) ; 
	 	$count_arr1 = $value['Amount']; 
	 	$cnt++;
		}

	// print_r($val_arr);
	 ?>
	 <!-- <input type="text" name="arr" value="<?php echo $val_arr ;?>" id="arr"> -->
<?php
//var_dump($val_arr);
?>

<div style="display: flex; justify-content: space-between;">
<div style="height: 60vh; overflow: auto;width: 100%">
<table class="table table-hover table-bordered" align="center" ><thead>
	<tr>
		 <th>S.No.</th>
		 <th>Day</th>
		 <th>Amount <br>(Rs. in Crores) </th>
		 <th>Change</th>
	</tr></thead><tbody>
	<tr><?php
		$count= 0;
		$row_cnt=1;
		 for ($i=0; $i <$length ; $i++) 
		     { 
		     $thisMnth=date("d-M-Y",strtotime($summary_op[$i]['AsonDate']));
		     // $thisAmt=$summary_op[$i]['Amount'];  ;
		     
		     $thisAmt= ($displayorder==52)? $summary_op[$i]['Amount'] : round($summary_op[$i]['Amount']/10000000,0); ;
		     $growth_over_prev_month=round($thisAmt-$prev_month,2);
		     if ($growth_over_prev_month>0)
		      $growth_over_prev_month="<b style='color: green'>&#129137; $growth_over_prev_month</b>";
		     else
		      $growth_over_prev_month="<b style='color: red'>&#129139; $growth_over_prev_month</b>";
			 echo "<tr>
				 		<td>" . $row_cnt++ . "</td>
				 		<td>$thisMnth</td>
				 		<td style='text-align: right'>$thisAmt</td>
				 		<td style='text-align: right'>$growth_over_prev_month</td>
			 		</tr> ";
			 $prev_month=$thisAmt;
		     }  
		?>     
	  
</tbody></table>
</div>
<div style="width:80vw" >
	<canvas id="Pie1" style="max-width:80vw;height: 60vh"></canvas>
</div>
</div>
<!-- </div> -->
<?php 	
// die("");
}
else
{
$chartType="bar";


?>


<!-- <div class="container" > -->

	
	<h2 style="font-weight: bolder; color:green;"> <center> Bank Assets & Liabilities (in Crores) as on <u><?php echo date("d F, Y",strtotime("$asondate")); ?></u> </center></h2>
	
	<?php

	 // $summary_query = "SELECT category,ROUND(rm_total/100000,0) 'Amt' FROM investments.alm_appendix1_maturity_profile_liquidity WHERE displayorder IN (27,49) AND asondate='$asondate'";
	
	 $summary_query = "SELECT category,ROUND(rm_total/10000000,0) 'Amt' FROM investments.alm_appendix1_maturity_profile_liquidity WHERE displayorder IN (1,2,3,8,13,27,28,29,30,33,34,38,39,40,46,49) AND asondate='$asondate' order by displayorder ";
	
	 // echo $summary_query;
	$exec_summ = mysqli_query($connect,$summary_query);
	$summary_op = mysqli_fetch_all($exec_summ,MYSQLI_ASSOC); 
	echo "<br>";
 	$fields = mysqli_fetch_fields($exec_summ); 
 	 // var_dump($fields); 
 	$length = sizeof($summary_op);
 	// var_dump($length);
 	if (!$length)	die("<h2>No Records!</h2>");
	echo "<br>"; 
 

$val_arr = array();
$count_arr = array();

$cnt=0;
	foreach ($summary_op as $key => $value) 
		{
	 	$val_arr[$value['category']] =round($value['Amt'],0); 
	 	$count_arr = $value['Amt']; 
	 	$cnt++;
		}
?>
<div style="width:70vw" >
	<canvas id="Pie1" style="max-width:80vw;height: 50vh"></canvas>
</div>


<?php } ?>
<!-- </div> -->



	<script type="text/javascript">
		var darr = document.getElementById("arr");
		var ctxP = document.getElementById("Pie1").getContext('2d');
		var list_of_status_labels =  <?php echo json_encode(array_keys($val_arr)) ?>;
		var list_of_status_values =  <?php echo json_encode(array_values($val_arr)) ?>;
		var list_of_status_values1 =  <?php echo json_encode(array_values($val_arr1)) ?>;

		var mypie = new Chart(ctxP,{
			type: '<?php echo $chartType; ?>' ,

			data:{
					// labels : ['Data1','Data2'] ,
					labels : list_of_status_labels ,
					datasets:[
					{
						fillColor: "#ffffff",
						data:list_of_status_values,
						// data:,
						backgroundColor:["#f7464a","#468FBD","#FDB45C","#949FB1","#405360", "#A053F0","#785236","#112233","#ff00dd","#ac5482","#f02589","#12f35d","#95dc25","#f7464a","#468FBD","#FDB45C","#949FB1","#405360", "#A053F0","#785236","#112233","#ff00dd","#ac5482","#f02589","#12f35d","#95dc25"],
						hoverBackgroundColor:["#f7464a","#468FBD","#FDB45C","#949FB1","#405360","#A053F0","#785236","#112233","#ff00dd","#ac5482","#f02589","#12f35d","#95dc25",]
					}]
				},
			options:{
						responsive:true,
						datasetFill: false,
						steps:20,
						scales:{
							yAxes:[{
								display:true,
								ticks:{
									 // beginAtZero:true,
									 steps:30, 									 
								}
							}],
							xAxes:[{
								display:true,
								ticks:{
									 // beginAtZero:true,
									 steps:20, 									 
								}
							}]
						},

					}
		});
		// mypie.render();
	</script>
</body>
</html>