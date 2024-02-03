<!DOCTYPE html >
<html >

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title></title>
</head>

<body>
<?php
include 'index.php';
?>

<center>
<form method="post" action="">
<select name="asondate" onchange="this.form.submit();" required="required">
<option value=''>Select Month</option>
<?php
$sql="select distinct asondate from investments.alm_appendix1_maturity_profile_liquidity order by asondate desc";
$res=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_row($res))
    echo "<option value='$row[0]'>" . date("M, Y",strtotime($row[0])) . "</option>";
?>
</select>
</form>
</center>
<?php
if (isset($_POST['asondate']))
{
$asondate=$_POST['asondate'];
$sql="select * from investments.alm_appendix1_maturity_profile_liquidity where asondate='$asondate'";
$allrows=output_of_query($sql);
$row_chk=-1;
?>



<table border="1" class="table table-hover table-bordered" >
<tr>
	<th>		S.No.</th>
	<th>		OrderNo</th>
	<th>		Category</th>
	<th>		RM_1D_to_14D</th>
	<th>		RM_15D_to_28D</th>
	<th>		RM_29D_to_3M</th>
	<th>		RM_3M_to_6M</th>
	<th>		RM_6M_to_1Y</th>
	<th>		RM_1Y_to_3Y</th>
	<th>		RM_3Y_to_5Y</th>
	<th>		RM_OVER_5Y</th>
	<th>		RM_TOTAL</th>
</tr>

<tr>
	<td>		</td>
	<td>		</td>
	<td>		OutFlows</td>
	<th>		</th>
	<th>		</th>
	<th>		</th>
	<th>		</th>
	<th>		</th>
	<th>		</th>
	<th>		</th>
	<th>		</th>
	<th>		</th>
</tr>


<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<th>		<?php echo $allrows[$row_chk][5]; ?></th>
	<th>		<?php echo $allrows[$row_chk][6]; ?></th>
	<th>		<?php echo $allrows[$row_chk][7]; ?></th>
	<th>		<?php echo $allrows[$row_chk][8]; ?></th>
	<th>		<?php echo $allrows[$row_chk][9]; ?></th>
	<th>		<?php echo $allrows[$row_chk][10]; ?></th>
	<th>		<?php echo $allrows[$row_chk][11]; ?></th>
	<th>		<?php echo $allrows[$row_chk][12]; ?></th>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>

<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<th>		<?php echo $allrows[$row_chk][5]; ?></th>
	<th>		<?php echo $allrows[$row_chk][6]; ?></th>
	<th>		<?php echo $allrows[$row_chk][7]; ?></th>
	<th>		<?php echo $allrows[$row_chk][8]; ?></th>
	<th>		<?php echo $allrows[$row_chk][9]; ?></th>
	<th>		<?php echo $allrows[$row_chk][10]; ?></th>
	<th>		<?php echo $allrows[$row_chk][11]; ?></th>
	<th>		<?php echo $allrows[$row_chk][12]; ?></th>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>

<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<th>		<?php echo $allrows[$row_chk][5]; ?></th>
	<th>		<?php echo $allrows[$row_chk][6]; ?></th>
	<th>		<?php echo $allrows[$row_chk][7]; ?></th>
	<th>		<?php echo $allrows[$row_chk][8]; ?></th>
	<th>		<?php echo $allrows[$row_chk][9]; ?></th>
	<th>		<?php echo $allrows[$row_chk][10]; ?></th>
	<th>		<?php echo $allrows[$row_chk][11]; ?></th>
	<th>		<?php echo $allrows[$row_chk][12]; ?></th>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>


<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<td>		<?php echo $allrows[$row_chk][5]; ?></td>
	<td>		<?php echo $allrows[$row_chk][6]; ?></td>
	<td>		<?php echo $allrows[$row_chk][7]; ?></td>
	<td>		<?php echo $allrows[$row_chk][8]; ?></td>
	<td>		<?php echo $allrows[$row_chk][9]; ?></td>
	<td>		<?php echo $allrows[$row_chk][10]; ?></td>
	<td>		<?php echo $allrows[$row_chk][11]; ?></td>
	<td>		<?php echo $allrows[$row_chk][12]; ?></td>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>

<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<td>		<?php echo $allrows[$row_chk][5]; ?></td>
	<td>		<?php echo $allrows[$row_chk][6]; ?></td>
	<td>		<?php echo $allrows[$row_chk][7]; ?></td>
	<td>		<?php echo $allrows[$row_chk][8]; ?></td>
	<td>		<?php echo $allrows[$row_chk][9]; ?></td>
	<td>		<?php echo $allrows[$row_chk][10]; ?></td>
	<td>		<?php echo $allrows[$row_chk][11]; ?></td>
	<td>		<?php echo $allrows[$row_chk][12]; ?></td>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>

<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<td>		<?php echo $allrows[$row_chk][5]; ?></td>
	<td>		<?php echo $allrows[$row_chk][6]; ?></td>
	<td>		<?php echo $allrows[$row_chk][7]; ?></td>
	<td>		<?php echo $allrows[$row_chk][8]; ?></td>
	<td>		<?php echo $allrows[$row_chk][9]; ?></td>
	<td>		<?php echo $allrows[$row_chk][10]; ?></td>
	<td>		<?php echo $allrows[$row_chk][11]; ?></td>
	<td>		<?php echo $allrows[$row_chk][12]; ?></td>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>

<tr>
	<td>		<?php echo $row_chk++; ?></td>
	<td>		<?php echo $allrows[$row_chk][0]; ?></td>
	<td>		<?php echo $allrows[$row_chk][3]; ?></td>
	<td>		<?php echo $allrows[$row_chk][5]; ?></td>
	<td>		<?php echo $allrows[$row_chk][6]; ?></td>
	<td>		<?php echo $allrows[$row_chk][7]; ?></td>
	<td>		<?php echo $allrows[$row_chk][8]; ?></td>
	<td>		<?php echo $allrows[$row_chk][9]; ?></td>
	<td>		<?php echo $allrows[$row_chk][10]; ?></td>
	<td>		<?php echo $allrows[$row_chk][11]; ?></td>
	<td>		<?php echo $allrows[$row_chk][12]; ?></td>
	<th>		<?php echo $allrows[$row_chk][13]; ?></th>
</tr>


</table>

<?php
}
?>

</body>

</html>
