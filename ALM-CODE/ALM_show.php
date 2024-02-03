

<?php
// $conn = new mysqli("10.88.1.222","root","","investments");
$conn112 = new mysqli("10.88.1.112","root","");
error_reporting(0);
?>


<?php 
include 'updateManualEdit.php';
?>



<?php
$file="ALM_Appendix1_" . date("Ymd",strtotime($asondate)) . ".xls";
echo "<h2> " . date("d-F-Y",strtotime($asondate)) . "</h2>";
$test="<h3> Statement of Structural Liquidity as on $asondate </h3>";
$sql="select DisplayOrder as 'S.No.',OrderNo,	sub_Category as 'Segments',	RM_1D_to_14D,	RM_15D_to_28D,	RM_29D_to_3M,	RM_3M_to_6M,	RM_6M_to_1Y,	RM_1Y_to_3Y,	RM_3Y_to_5Y,	RM_OVER_5Y,	RM_TOTAL,UpdatedTS as 'Status' from investments.alm_appendix1_maturity_profile_liquidity where asondate='$asondate' order by DisplayOrder ";
// echo $sql;
// $stt = $conn->prepare($sql);
$res = $conn->query($sql);
// var_dump($conn, $res);
$count = $res->num_rows;
$fields_num1 = 13;
if ($count == 0)
 die("<h2>No Records</h2>");

echo "<center><br><table class='table table-hover table-bordered' border='1' style='width: 80%'><caption>Amt in Lakhs</caption><thead>";      
$test=$test . "<center><br><table class='table table-hover table-bordered' border='1' >";      


$RM_1D_to_14D="1-14 Days <hr> " . date("d/m/Y",strtotime($asondate)) . " to " . date("d/m/Y",strtotime("$asondate +14 days")); 
$RM_15D_to_28D="15-28 Days <hr> " . date("d/m/Y",strtotime("$asondate +15 days")) . " to " . date("d/m/Y",strtotime("$asondate +28 days")); 
$RM_29D_to_3M="1-3 Months <hr> " . date("d/m/Y",strtotime("$asondate +29 days")) . " to " . date("d/m/Y",strtotime("$asondate +90 days")); 
$RM_3M_to_6M="3-6 Months <hr> " . date("d/m/Y",strtotime("$asondate +91 days")) . " to " . date("d/m/Y",strtotime("$asondate +180 days")); 
$RM_6M_to_1Y="6-12 Months <hr> " . date("d/m/Y",strtotime("$asondate +181 days")) . " to " . date("d/m/Y",strtotime("$asondate +365 days")); 
$RM_1Y_to_3Y="1-3 Years <hr> " . date("d/m/Y",strtotime("$asondate +366 days")) . " to " . date("d/m/Y",strtotime("$asondate +1095 days")); 
$RM_3Y_to_5Y="3-5 Years <hr> " . date("d/m/Y",strtotime("$asondate +1096 days")) . " to " . date("d/m/Y",strtotime("$asondate +1825 days")); 
$RM_OVER_5Y="Above 5 Years <hr> Beyond <br>" . date("d/m/Y",strtotime("$asondate +1825 days")); 

echo "<tr><th>S.No.</th><th>OrderNo</th><th>Segments</th>
		<th>$RM_1D_to_14D</th>
		<th>$RM_15D_to_28D</th>
		<th>$RM_29D_to_3M</th>
		<th>$RM_3M_to_6M</th>
		<th>$RM_6M_to_1Y</th>
		<th>$RM_1Y_to_3Y</th>
		<th>$RM_3Y_to_5Y</th>
		<th>$RM_OVER_5Y</th>
		<th>TOTAL</th>
		<th>Status</th>
		</tr>";

$test=$test .  "<tr><th>S.No.</th><th>OrderNo</th><th>Segments</th>
		<th>$RM_1D_to_14D</th>
		<th>$RM_15D_to_28D</th>
		<th>$RM_29D_to_3M</th>
		<th>$RM_3M_to_6M</th>
		<th>$RM_6M_to_1Y</th>
		<th>$RM_1Y_to_3Y</th>
		<th>$RM_3Y_to_5Y</th>
		<th>$RM_OVER_5Y</th>
		<th>TOTAL</th>
		<th>Status</th>
		</tr>";

echo "</thead><tbody><tr style='background-color: lightblue ' ><td></td><td></td><td><b>Outflows</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
$test=$test .  "<tr style='background-color: lightblue ' ><td></td><td></td><td><b>Outflows</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";

$row_chk=0;
$highlight_rows=array(1,2,3,8,13,18,31,40);
$pendingCnt=0;

		// $count = mysqli_num_rows($res);


$not_to_edit=array(3,8,13,18,27,30,34,40,49,50,51,52);
 
while($row = $res->fetch_row())
{
    $row_chk=$row_chk + 1;
    $frmId="frmId" . $row_chk;
    $tblTrId="tblTrId" . $row_chk;
    //if ($row_chk==27 || $row_chk>=49)
    // echo "<tr style='background-color: lightblue; font-weight: bold ' ><td>$row_chk</td>";
    //else
    if ($row_chk==11 || $row_chk==12 || $row_chk==32 || $row_chk==33 || $row_chk==46)
    	$rowDispClr="color:blue";
    else
    	$rowDispClr="";
    echo "<tr style='$rowDispClr' id='$tblTrId' ondblclick='enableEdit($row_chk,$count)'><form class='form-inline' id='$frmId' method='post' >";
    $test=$test .  "<tr>";
    $cnt=0;
    
    
    foreach($row as $cell)
	     {

	     $varName="varName" . $cnt;
 	     if ($cnt>=3 && $cnt<$fields_num1 && $row_chk<$count)
	        $row[$cnt] = ($row[$cnt]) ? round($row[$cnt]/100000,0) : $row[$cnt];
	     //$field = mysqli_fetch_field($res);
		if ($editId && $cnt>2 && !in_array($row_chk, $not_to_edit))
		 $val="<input class='form-control' type='number' step='0.01' name='$varName' title='$varName' value='$row[$cnt]' style='border:none; background: none; text-align: right; height: 3vh' />";
		elseif($cnt>2 && $row[0]<52)
		 		$val="<div style='cursor: not-allowed; text-align: right' >" . indian_money_format($row[$cnt],2) . "</div>";
		 	else
		 		$val="<div style='cursor: not-allowed' >$row[$cnt]</div>";
	     $cnt++;

	     if ($cnt>3 && $cnt<$fields_num1)
		      {
		      // $val = round($val/100000,0);
		      if (in_array($row_chk, $not_to_edit) ) //|| $cnt==$i
		       echo "<td style='background-color: lightblue'>$val</td>";
		      else
		       echo "<td>$val</td>";
		      }
	     else
		      {
		      if ($cnt==$fields_num1)
			       {
			       echo "<td style='display: flex; justify-content: flex-start; vertical-align:middle '>";
			       if ($cell > "0000-00-00 00:00:00")
			        {
			        	// if ()
			        	echo "<b style='text-align: center; color: green; font-size: 20px'>&#128504;</b>";
			        }
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
if ($pendingCnt)
	echo "<h3 style='color:red'>No. of Pending Entries : $pendingCnt</h3>";
echo "</tbody></table>";
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