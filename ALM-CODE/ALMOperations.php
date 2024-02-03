
<!DOCTYPE HTML>
<html lang="en">
<head>
<style>
div h3{
	background-color: maroon;
	color: white;
	padding: 5px 20px;
	border-radius: 10px;
}

div h3 a{
	color: white;
	text-decoration:none;
}
</style>
</head>
<body style="">
<?php
$adminIdsList=array(99999,2828);
if (in_array($pid,$adminIdsList))
 $editId=1;
else
 $editId=0;
?>
<table class="table" style="width: 100%">
<tr>
<th style="background-color: teal ! important">
<div style="display: flex; justify-content: space-around; border:thick maroon  double;  background-color:#FCEDEB;">
<!--h3><a href="showAvailableMonth.php">View Available Months</a></h3-->
<!--<h3><a href="Load_RM_Data.php">Appendix-I</a></h3>
-->
<h2>ALM</h2>
<h3><a href="ALM_View.php">Load Data</a></h3>
<h3><a href="Load_Appendix1.php">View Statement</a></h3>
<h3><a href="Trend.php">Trend Analysis</a></h3> 
</div>

</th>
<th style="background-color: teal ! important">
<div style="display: flex; justify-content: space-around; border:thick maroon  double;  background-color:#FCEDEB;">
<h2>Investments</h2>
<h3><a href="Bond_Display.php">Bonds</a></h3>
<h3><a href="SLR_Display1.php">SLR</a></h3>
<h3><a href="MF_Display.php">Mutual Funds</a></h3>
<h3><a href="TDR_Display.php">TDRs</a></h3>
</div>
</th>
<th style="background-color: teal ! important">
<div style="display: flex; justify-content: space-around; border:thick maroon  double;  background-color:#FCEDEB;">
<h3><a href="CA_Display.php">Current Accounts</a></h3>
</div>
</th>
<th style="background-color: teal ! important">
<div style="display: flex; justify-content: space-around; border:thick maroon  double;  background-color:#FCEDEB;">
<h3><a href="http://10.88.1.112/Refinance/Outstanding.php" target="_blank">Refinances</a></h3>
</div>
</th>
</tr>
</table>
</body>
</html> 


