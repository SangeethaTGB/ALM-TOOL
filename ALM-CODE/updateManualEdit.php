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