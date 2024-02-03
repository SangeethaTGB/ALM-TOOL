<!DOCTYPE HTML>
<html lang="en">
<head><title> SLR </title></head>
<?php	
include 'index.php';
$asondate=$_POST['asondate'];
?>
<style>

 /* Style inputs with type="text", select elements and textareas */
input[type=text], select, textarea {
  padding: 12px; /* Some padding */ 
  border: 1px solid #ccc; /* Gray border */
  border-radius: 4px; /* Rounded borders */
  box-sizing: border-box; /* Make sure that padding and width stays in place */
  margin-top: 6px; /* Add a top margin */
  margin-bottom: 16px; /* Bottom margin */
}

/* Style the submit button with a specific background color etc */



/* When moving the mouse over the submit button, add a darker green color */
input[type=submit]:hover {
  background-color: #45a049;
}

/* Add a background color and some padding around the form */
.container {
  background-color: #f2f2f2;
  padding-top:20px;

} 
	#headerDiv{
		text-align: center;
		height: auto;
		padding: 1px;	
		background-color :#122359;
		font-size: 20px;
		margin:auto;
	}
sup	{

	color:red;
	vertical-align:super;
	padding-right:5px;
}

</style>
<script type="text/javascript">
    function form_submit(elem){
 document.getElementById("SUITFILEDFilterForm").submit();
}
    function form_submit_1(elem){
 document.getElementById("SarfaesiFilterForm2").submit();
}
    function form_submit_3(elem){
 document.getElementById("SarfaesiFilterForm3").submit();
}
</script>
<body>

		<CENTER>




	<?php 
		if(isset($_POST["deleteEntry"]))
		{	  
			$Entry_ID = $_POST['Entry_ID'];
			$sql_del="delete from investments.alm_SLR where Entry_ID=$Entry_ID";
			$res_del=mysqli_query($conn,$sql_del);
		}
		if(isset($_POST["updateBond"]))
		{	  
			$Purchase_Date = $_POST['Purchase_Date']; 
			$Investment_Particulars = $_POST['Investment_Particulars']; 
			$Face_Value = $_POST['Face_Value']; 
			$Book_Value = $_POST['Book_Value'];
			$Purchase_Value = $_POST['Purchase_Value'];
			$Maturity_Date = $_POST['Maturity_Date'];
			$Interest_Rate = $_POST['Interest_Rate'];
			$ISIN = $_POST['ISIN'];
			$Last_Intr_Recd_Date= $_POST['Last_Intr_Recd_Date'];
			$Entry_ID = $_POST['Entry_ID'];
			$sql3 = "update investments.alm_SLR set 
													Updated_By='$pid',
													Purchase_Date=NULLIF('$Purchase_Date',''),
													Investment_Particulars=NULLIF('$Investment_Particulars',''),
													Face_Value=NULLIF('$Face_Value',''),
													Book_Value=NULLIF('$Book_Value',''),
													Purchase_Value=NULLIF('$Purchase_Value',''),
													Maturity_Date=NULLIF('$Maturity_Date',''),
													Interest_Rate=NULLIF('$Interest_Rate',''),
													ISIN=NULLIF('$ISIN',''),
													Last_Intr_Recd_Date=NULLIF('$Last_Intr_Recd_Date','')
					where Entry_ID=$Entry_ID";
					
			$result3 = mysqli_query($conn,$sql3);
		}

		if(isset($_POST["addBond"]))
		{	  
			$Purchase_Date = $_POST['Purchase_Date']; 
			$Investment_Particulars = $_POST['Investment_Particulars']; 
			$Face_Value = $_POST['Face_Value']; 
			$Book_Value = $_POST['Book_Value'];
			$Purchase_Value = $_POST['Purchase_Value'];
			$Maturity_Date = $_POST['Maturity_Date'];
			$Interest_Rate = $_POST['Interest_Rate'];
			$ISIN = $_POST['ISIN'];
			$sql3 = "INSERT INTO investments.alm_SLR( 
													Entry_Date,
													Updated_By,
													Updated_On,
													Purchase_Date,
													Investment_Particulars,
													Face_Value,
													Book_Value,
													Purchase_Value,
													Maturity_Date,
													Interest_Rate,
													ISIN 
													) 
					values (
							CURRENT_DATE(),
							'$pid',
							now(),
							NULLIF('$Purchase_Date',''), 
							NULLIF('$Investment_Particulars',''), 
							NULLIF('$Face_Value',''), 
							NULLIF('$Book_Value',''), 
							NULLIF('$Purchase_Value',''), 
							NULLIF('$Maturity_Date',''), 
							NULLIF('$Interest_Rate',''), 
							NULLIF('$ISIN','')  
						 )";
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);
			if($result)
				echo "Added!";
		}
	?>


<h2>Investments on SLR</h2>
		<form class="form-inline" action="" method="post">
		<input class="form-control" name="asondate" type="date" value="<?php if (isset($asondate)) echo $asondate; else  echo date("Y-m-d");?>" />
		<input class="form-control btn btn-primary" name="showIntrRbl" type="submit" value="Show Interest Receivables" />
		<button class="form-control btn btn-primary" onclick="window.location.href='?';" >Show all</button>
		</form><br>
<?php
if (isset($_POST['showIntrRbl'])){
//$asondate=date("Y-m-t",strtotime($asondate));
$sql="		SELECT Purchase_Date,	`Investment_Particulars`,	`Face_Value`,	`Book_Value`,`Purchase_Value`,Last_Intr_Recd_Date,Lastest_Intr_Recd_Date, Maturity_Date,`Interest_Rate`,Days AS 'Completed Days' 
		, ROUND((Face_Value * Interest_Rate * Days)/36000,2) AS 'Interest Receivable (Rs.)' 
		FROM 
		( 
		SELECT *,investments.calc_days360(investments.calcLastIntrRcdDate(Last_Intr_Recd_Date,'$asondate'),'$asondate')AS 'Days',investments.calcLastIntrRcdDate(Last_Intr_Recd_Date,'$asondate') Lastest_Intr_Recd_Date
		,investments.calc_days360(Last_Intr_Recd_Date,'$asondate') AS 'Days_old' FROM investments.alm_slr WHERE Maturity_Date>='$asondate' 
		) a 
		ORDER BY Purchase_Date desc";
// echo $sql;
//show_query_output($sql);
$result = mysqli_query($conn,$sql);


echo "<center><table  class='table table-hover table-bordered' style='width:80%' >";

echo "<thead><tr><th>S.No</th>";
$fields_num1 = mysqli_num_fields($result);

for($i=0; $i<$fields_num1; $i++){
    $field = mysqli_fetch_field($result);
    echo "<th>{$field->name}</th>";
}
echo "</tr></thead><tbody>";

// printing table rows
$row_chk=0;
$amt=0;
$total2[]=0;
$maiBr=0;
$tot_Intr_Rbl=0;
while($row = mysqli_fetch_row($result))
{
    $cnt=0;
    $row_chk=$row_chk + 1;
    echo "<tr><td>$row_chk</td>";
    foreach($row as $cell)
     {
     $cnt++;
     if (($cnt>=3 && $cnt<=5) || $cnt==10) 
      echo "<td style='text-align: right'>" . indian_money_format($cell,2) . "</td>";
     else
      echo "<td style='text-align: center'>$cell</td>";
     }
    echo "</tr>";
    $tot_Intr_Rbl+=$row[10];

}
echo "<h1><label class='btn btn-warning' style='font-size: 20px'>Interest Receivables on SLRs (as on $asondate) : 
		<b>Rs." . indian_money_format($tot_Intr_Rbl) . "</b></label></h1>";
// echo "<h2>Interest Receivables on SLRs as on $asondate : <u>Rs. $tot_Intr_Rbl</u></h2>";
echo "</tbody></table><br><br><br>";

}

else
{
?>

<?php    

	 	$query = "select * from investments.alm_SLR order by Purchase_Date desc";
//  Entry_ID
// Entry_Date
// Updated_By
// Updated_On


// Purchase_Date
// Investment_Particulars
// Face_Value
// Book_Value
// Purchase_Value
// Maturity_Date
// Interest_Rate
// ISIN
		
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);

		$test = $test . "<table border=1>";
		$test = $test . "<tr><th><b>S.No.</b></th>";
		$test = $test . "<th><b>Purchase_Date</b></th>";  
		$test = $test . "<th><b>Maturity_Date</b></th>";  
		$test = $test . "<th><b>Interest_Rate</b></th>";  
		$test = $test . "<th><b>Book_Value</b></th>";  
		$test = $test . "<th><b>ISIN</b></th>";  
		$test = $test . "<th><b>HTM_AFS</b></th>";  
		$test = $test . "<th><b>Investment_Particulars</b></th>";  
		$test = $test . "<th><b>Face_Value</b></th>";  
		$test = $test . "<th><b>Purchase_Value</b></th>";  
		?>

<?php
//include 'bond_feed.php';
?>
		<div style="display:flex;flex-direction: column-reverse;">
			<div>
			<table class='table table-hover table-bordered' >
			<thead><tr>
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Purchase_Date  </b></th>   
				<th style="text-align: center;"><b>Investment_Particulars  </b></th>   
				<th style="text-align: center;"><b>Purchase_Value  </b></th>   
				<th style="text-align: center;"><b>Face_Value  </b></th>   
				<th style="text-align: center;"><b>Book_Value  </b></th>   
				<th style="text-align: center;"><b>Maturity_Date  </b></th>   
				<th style="text-align: center;"><b>Interest_Rate  </b></th>   
				<th style="text-align: center;"><b>ISIN  </b></th>   
				<th style="text-align: center;"><b>HTM_AFS  </b></th>   
				<th style="text-align: center;"><b>Last Interest Received Date</b></th>  
			</tr></thead><tbody>
				<?php if ($editId) { ?>
				<tr style="height: 35px; background-color:  #DDFFFF; vertical-align:middle">
				<form method="post" action="">
					<td style="text-align: right;">Add New</td> 
					<td style="text-align: left;">
					<input type="date" class="form-control" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>" required="required" style="height: 20px" /></td> 
					<td style="text-align: left;"><textarea class="form-control" name="Investment_Particulars" required="required" style="height: 37px; width:100%; padding-bottom:0"><?php echo $row_acc['Investment_Particulars']; ?></textarea> </td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Purchase_Value" value="<?php echo $row_acc['Purchase_Value']; ?>" required="required" style="height: 24px" /></td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Face_Value" value="<?php echo $row_acc['Face_Value']; ?>" required="required" style="height: 30px" /></td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Book_Value" value="<?php echo $row_acc['Book_Value']; ?>" required="required" style="height: 28px" /></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  required="required" style="height: 20px" /></td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>" required="required" style="height: 28px" /></td> 
					<td style="text-align: left;"><input type="text" class="form-control" name="ISIN" value="<?php echo $row_acc['ISIN']; ?>"required="required" style="height: 37px"  /></td> 
					<td style="text-align: left;"><input type="text" class="form-control" name="HTM_AFS" value="<?php echo $row_acc['HTM_AFS']; ?>"required="required" style="height: 37px"  /></td> 
					<td style="text-align: left;"><input class="form-control" name="addBond" type="submit" value="Add" /></td> 
				</form>
				</tr>
				<?php } ?>


		<?php
		
		if ($count > 0)
		{
			$rowcnt=0;
			while($row_acc=mysqli_fetch_assoc($result)){
			$rowcnt=$rowcnt+1;
		?>

<script>
function enableEdit(i,j)
{
//alert(i);
for(i1=1;i1<=j;i1++)
 {
 var edit="edit_" + i1;
 var tr="tr_" + i1;
 document.getElementById(edit).style.display="none";
document.getElementById(tr).style.backgroundColor="transparent";
 }

var edit="edit_" + i;
var tr="tr_" + i;
document.getElementById(edit).style.display="Block";
document.getElementById(tr).style.backgroundColor=" #DDFFFF";
}
</script>

				<?php if ($editId) { ?>
				<tr id="tr_<?php echo $rowcnt; ?>"  ondblclick="enableEdit('<?php echo $rowcnt; ?>','<?php echo $count; ?>')"  title="Double Click for EDIT"   >
				<form method="post" action="" readonly="readonly">
					<td style="text-align: left;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><textarea class="form-control" name="Investment_Particulars" style="border:none; background: none; width:100%; height: 30px; padding-bottom:0"><?php echo $row_acc['Investment_Particulars']; ?></textarea> </td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Purchase_Value" value="<?php echo $row_acc['Purchase_Value']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Face_Value" value="<?php echo $row_acc['Face_Value']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Book_Value" value="<?php echo $row_acc['Book_Value']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="text" class="form-control" name="ISIN" value="<?php echo $row_acc['ISIN']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="text" class="form-control" name="HTM_AFS" value="<?php echo $row_acc['HTM_AFS']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Last_Intr_Recd_Date" value="<?php echo $row_acc['Last_Intr_Recd_Date']; ?>" style="border:none; background: none"  /></td> 
					<td id="edit_<?php echo $rowcnt; ?>" style="text-align: left; ">
						<div style="display:flex">
							
						<input class="form-control  btn btn-success" name="updateBond" type="submit" value="Update" style="width: 100%; vertical-align:middle" />
						<input class="form-control" name="Entry_ID" type="text" value="<?php echo $row_acc['Entry_ID']; ?>" style="display:none" />
						<input class="form-control  btn btn-danger" name="deleteEntry" type="submit" value="Delete"  />
						</div>

					</td> 
				</form>
				</tr>
				<?php 
				}
				else
				{
				?>
				<tr>
					<td style="text-align: left;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Purchase_Date']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Investment_Particulars']; ?> </td> 
					<td style="text-align: left;"><?php echo $row_acc['Purchase_Value']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Face_Value']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Book_Value']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Maturity_Date']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Interest_Rate']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['ISIN']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['HTM_AFS']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Last_Intr_Recd_Date']; ?></td> 
				</tr>
				<?php
				}
			   ?>


		<?php 

			}
			echo"</tbody></table>";
			}
		else{
			echo "<CENTER><h1>No records to display</h1>";
			}
	?>
		</div>
		<!-- <div style="display: flex;height: 30px;justify-content: space-around;align-items: center;height: auto;">
			<form method='post' action='export.php'><p><label for='data'></label>
			<input type='text' id='data' name='data' value="<?php echo $test ?>" style='display: none' />
			<input type='text' id='data1' name='data1' value="<?php echo $file ?>" style='display: none' />
			<input type='submit' value='&#x2193; Save to Excel' style="font-size: 15px;" /></form>
		</div> -->
	</div>

<?php
}
?>

</body>
</html>

<script>
function confirmDelete(i)
{
var txt;
var x=confirm("Are You Sure! You want to DELETE Sl.No. - " + i + "?");
if (x)
 {
 var frm="frm_" + i;
 var deleteEntrySttId="deleteEntrySttId_" + i;
 document.getElementById('deleteEntrySttId_'+i).value=x;
 windows.document.forms[frm].submit();
 }
}
</script>

