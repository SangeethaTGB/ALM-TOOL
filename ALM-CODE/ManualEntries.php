<!DOCTYPE HTML>
<html lang="en">
<head><title> Reports | ALM </title></head>

<body>

<?php		
include 'index.php';	

?>
<h2>Reports</h2>
<form class="form-inline text-center" method="post">
	<input class="form-control btn btn-success" type="submit" name="ALMModel" value="ALM Model">
	<input class="form-control btn btn-info" type="submit" name="Manual" value="Manual Entries">
	<input class="form-control btn btn-warning" type="submit" name="diff30062022" value="Difference-30062022">
	<input class="form-control btn btn-warning" type="submit" name="diff30072022" value="Difference-30072022">
</form>

<?php 
if (isset($_POST['ALMModel'])){
	$heading="<h2>ALM Model</h2>";
echo $heading;
$sql = "SELECT DisplayOrder, OrderNo, op_mode, Category, sub_Category, Comments FROM investments.alm_appendix1_model";
$fname = "ALMModel";
show_query_output_fname($sql,$fname, $heading  );
}
?>

<?php 
if (isset($_POST['Manual'])){
echo "<h2>Manual Entries included from BalanceSheet Tool</h2>";
$sql = "select gl_acct, b.level1_classification 'Level1',  if(b.ar1_mapping='0',c.ar2_mapping,b.ar1_mapping) Level2, 	manual_bal 'Manual Additions', 	curmonth
		from investments.cgl_add_ded a,investments.cgl_ar1_mapping b, investments.cgl_ar2_mapping c 
		where a.gl_acct=b.CGL and a.gl_acct=c.CGL 
		order by level2 asc";
show_query_output($sql);
}
?>

<?php 
if (isset($_POST['diff30062022'])){
	$heading="<h2>Difference with BS-30062022</h2>";
echo $heading;
$sql = "SELECT a.DisplayOrder,b.orderno,segment, ROUND(RM_TOTAL/100000,0) as 'ALM-TOOL',amt as 'BS',(ROUND(RM_TOTAL/100000,0)-amt) diff 
FROM investments.alm_appendix1_maturity_profile_liquidity a, investments.`manual_bs_30062022` b
WHERE asondate='2022-06-30' AND a.DisplayOrder = b.DisplayOrder and a.DisplayOrder<=49
ORDER BY DisplayOrder";
$fname = "Difference";
show_query_output_fname($sql,$fname, $heading  );
}
?>


<?php 
if (isset($_POST['diff30072022'])){
	$heading="<h2>Difference with BS-30072022</h2>";
echo $heading;
$sql = "SELECT a.DisplayOrder,b.orderno,segment, ROUND(RM_TOTAL/100000,0) as 'ALM-TOOL',amt as 'BS',(ROUND(RM_TOTAL/100000,0)-amt) diff 
FROM investments.alm_appendix1_maturity_profile_liquidity a, investments.`manual_bs_30072022` b
WHERE asondate='2022-07-31' AND a.DisplayOrder = b.DisplayOrder and a.DisplayOrder<=49
ORDER BY DisplayOrder";
$fname = "Difference";
show_query_output_fname($sql,$fname, $heading  );
}
?>






</body>
</html>