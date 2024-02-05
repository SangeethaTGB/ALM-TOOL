
<?php 
include 'DBConnect.php';

$conn111 = $conn;//  new mysqli("10.88.1.222","root","","investments");
// $conn=$con1;
function output_of_query($qry)
{
	global $conn111;
	$stt = $conn111->prepare($qry);
 	$stt->execute(); 	
	return $res;   
}

function output_of_query_rows($qry)
{
	global $conn111;
	$result = mysqli_query($conn111,$qry);
	$res=mysqli_fetch_all($reslut);
	return $res;   
}



function bulk_update($DisplayOrder,$asondate)
{
	global $conn111;
//echo "<script>alert('$asondate');</script>"; 

 switch ($DisplayOrder)
 {
 	case 3:
 		$ordernoList="4,5,6,7";
 		break;
 	case 8:
 		$ordernoList="9,10,11,12";
 		break;
 	case 13:
 		$ordernoList="14,15,16,17";
 		break;
 	case 18:
 		$ordernoList="19,20";
 		break;
 	case 27:
 		$ordernoList="1,2,3,8,13,18,21,22,23,24,25,26";
 		break;
 	case 30:
 		$ordernoList="31,32";
 		break;
 	case 34:
 		$ordernoList="35,36,37";
 		break;
 	case 40:
 		$ordernoList="41,42,43";
 		break;
 	case 49:
 		$ordernoList="28,29,30,33,34,38,39,40,44,45,46,47,48";
 		break;
 }

$sql="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in ($ordernoList) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=$DisplayOrder ";
// echo "<br>$sql"; 

$res=output_of_query($sql);
}



function last3_rows_update($asondate)
{
	global $conn111;
//echo "<script>alert('$asondate');</script>";
$sql="select (RM_1D_to_14D) a, (RM_15D_to_28D) b, (RM_29D_to_3M) c, (RM_3M_to_6M) d, (RM_6M_to_1Y) e, (RM_1Y_to_3Y) f, (RM_3Y_to_5Y) g, (RM_OVER_5Y) h, (RM_TOTAL) i,DisplayOrder   
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (27,49) order by DisplayOrder desc";
// echo $sql;exit;
$result = $conn111->query($sql);
$mismatch_res=mysqli_fetch_all($result);
// $mismatch_res=output_of_query_rows($sql);		
// var_dump($mismatch_res);exit;

$a=$mismatch_res[0][0] - $mismatch_res[1][0];		
$b=$mismatch_res[0][1] - $mismatch_res[1][1];		
$c=$mismatch_res[0][2] - $mismatch_res[1][2];		
$d=$mismatch_res[0][3] - $mismatch_res[1][3];		
$e=$mismatch_res[0][4] - $mismatch_res[1][4];		
$f=$mismatch_res[0][5] - $mismatch_res[1][5];		
$g=$mismatch_res[0][6] - $mismatch_res[1][6];		
$h=$mismatch_res[0][7] - $mismatch_res[1][7];		
$i=$mismatch_res[0][8] - $mismatch_res[1][8];		

$sql="update investments.alm_appendix1_maturity_profile_liquidity
	set RM_1D_to_14D=$a, RM_15D_to_28D=$b, RM_29D_to_3M=$c,RM_3M_to_6M=$d, RM_6M_to_1Y=$e, RM_1Y_to_3Y=$f, RM_3Y_to_5Y=$g,RM_OVER_5Y=$h, RM_TOTAL=$i 
	where asondate='$asondate' and DisplayOrder=50 ";
$res=output_of_query($sql);

$sql="update investments.alm_appendix1_maturity_profile_liquidity
	set RM_1D_to_14D=$a, RM_15D_to_28D=$a+$b, RM_29D_to_3M=$a+$b+$c,RM_3M_to_6M=$a+$b+$c+$d, RM_6M_to_1Y=$a+$b+$c+$d+$e, RM_1Y_to_3Y=$a+$b+$c+$d+$e+$f, RM_3Y_to_5Y=$a+$b+$c+$d+$e+$f+$g,RM_OVER_5Y=$a+$b+$c+$d+$e+$f+$g+$h, RM_TOTAL=$a+$b+$c+$d+$e+$f+$g+$h+$i 
	where asondate='$asondate' and DisplayOrder=51 ";
//echo $sql;
$res=output_of_query($sql);

$a1=(($mismatch_res[1][0] != 0)) ? round($a*100/$mismatch_res[1][0],0) : 0 ;		
$b1=(($mismatch_res[1][0] != 0)) ? round($b*100/$mismatch_res[1][1],0) : 0 ;		
$c1=(($mismatch_res[1][0] != 0)) ? round($c*100/$mismatch_res[1][2],0) : 0 ;		
$d1=(($mismatch_res[1][0] != 0)) ? round($d*100/$mismatch_res[1][3],0) : 0 ;		
$e1=(($mismatch_res[1][0] != 0)) ? round($e*100/$mismatch_res[1][4],0) : 0 ;		
$f1=(($mismatch_res[1][0] != 0)) ? round($f*100/$mismatch_res[1][5],0) : 0 ;		
$g1=(($mismatch_res[1][0] != 0)) ? round($g*100/$mismatch_res[1][6],0) : 0 ;		
$h1=(($mismatch_res[1][0] != 0)) ? round($h*100/$mismatch_res[1][7],0) : 0 ;		
$i1=(($mismatch_res[1][0] != 0)) ? round($i*100/$mismatch_res[1][8],0) : 0 ;		

$sql="update investments.alm_appendix1_maturity_profile_liquidity
	set RM_1D_to_14D=$a1, RM_15D_to_28D=$b1, RM_29D_to_3M=$c1,RM_3M_to_6M=$d1, RM_6M_to_1Y=$e1, RM_1Y_to_3Y=$f1, RM_3Y_to_5Y=$g1,RM_OVER_5Y=$h1, RM_TOTAL=$i1 
	where asondate='$asondate' and DisplayOrder=52 ";
//echo $sql;
$res=output_of_query($sql);

}
 
?>

