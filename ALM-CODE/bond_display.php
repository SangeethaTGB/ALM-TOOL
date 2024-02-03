<!DOCTYPE HTML>
<html lang="en">
<head><title> Bonds </title></head>
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
/*input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  cursor: pointer;
}
button[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  cursor: pointer;
}*/


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



<script>
function confirmDelete(i)
{
var txt;
var x=confirm("Are You Sure! You want to DELETE Sl.No. - " + i + "?");
if (x)
 {
 var frm="frm_" + i;
 var deleteBondSttId="deleteBondSttId_" + i;
 document.getElementById('deleteBondSttId_'+i).value=x;
 windows.document.forms[frm].submit();
 }
}
</script>

	<?php 
		if($_POST["deleteBondStt"]=="true")
		{	  
			$Entry_ID = $_POST['Entry_ID'];
			$sql_del="delete from investments.alm_BOND where Entry_ID=$Entry_ID";
			//echo "<script>alert('$sql_del');</script>";
			$res_del=mysqli_query($conn,$sql_del);
		
		}

		if(isset($_POST["updateBond"]))
		{	  
			$Purchase_Date = $_POST['Purchase_Date']; 
			$Invest_Particulars = $_POST['Invest_Particulars']; 
			$Face_Value = $_POST['Face_Value']; 
			$Book_Value = $_POST['Book_Value'];
			$Purchase_Value = $_POST['Purchase_Value'];
			$Maturity_Date = $_POST['Maturity_Date'];
			$Interest_Rate = $_POST['Interest_Rate'];
			$ISIN = $_POST['ISIN'];
			$Last_Intr_Recd_Date= $_POST['Last_Intr_Recd_Date'];
			$Entry_ID = $_POST['Entry_ID'];
			$sql3 = "update investments.alm_BOND set 
													Updated_By='$pid',
													Purchase_Date=NULLIF('$Purchase_Date',''),
													Invest_Particulars=NULLIF('$Invest_Particulars',''),
													Face_Value=NULLIF('$Face_Value',''),
													Book_Value=NULLIF('$Book_Value',''),
													Purchase_Value=NULLIF('$Purchase_Value',''),
													Maturity_Date=NULLIF('$Maturity_Date',''),
													Interest_Rate=NULLIF('$Interest_Rate',''),
													ISIN=NULLIF('$ISIN',''),
													Last_Intr_Recd_Date=NULLIF('$Last_Intr_Recd_Date','')
					where Entry_ID=$Entry_ID";
					
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);
		}

		if(isset($_POST["addBond"]))
		{	  
			$Purchase_Date = $_POST['Purchase_Date']; 
			$Invest_Particulars = $_POST['Invest_Particulars']; 
			$Face_Value = $_POST['Face_Value']; 
			$Book_Value = $_POST['Book_Value'];
			$Purchase_Value = $_POST['Purchase_Value'];
			$Maturity_Date = $_POST['Maturity_Date'];
			$Interest_Rate = $_POST['Interest_Rate'];
			$ISIN = $_POST['ISIN'];
			$sql3 = "INSERT INTO investments.alm_BOND( 
													Entry_Date,
													Updated_By,
													Updated_On,
													Purchase_Date,
													Invest_Particulars,
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
							NULLIF('$Invest_Particulars',''), 
							NULLIF('$Face_Value',''), 
							NULLIF('$Book_Value',''), 
							NULLIF('$Purchase_Value',''), 
							NULLIF('$Maturity_Date',''), 
							NULLIF('$Interest_Rate',''), 
							NULLIF('$ISIN','')  
						 )";
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);
		}
	?>



<h2>Investments on Bonds</h2>
		<form class="form-inline" action="" method="post">
		<input class="form-control" name="asondate" type="date" value="<?php if (isset($asondate)) echo $asondate; else  echo date("Y-m-d"); ?>" />
		<input class="form-control btn btn-primary" name="showIntrRbl" type="submit" value="Show Interest Receivables" />
		<button class="form-control btn btn-primary" onclick="window.location.href='?';" >Show all</button>
		</form>
<br>
<?php
if (isset($_POST['showIntrRbl']))
{
//$asondate=date("Y-m-t",strtotime($asondate));
$sql="		SELECT Purchase_Date,	`Invest_Particulars`,	`Face_Value`,	`Book_Value`,`Purchase_Value`,Last_Intr_Recd_Date, Maturity_Date,`Interest_Rate`,Days AS 'Completed Days' 
		, ROUND((Face_Value * Interest_Rate * Days)/36500,2) AS 'Interest Receivable (Rs.)' 
		FROM 
		( 
		SELECT *,(DATEDIFF('$asondate',`Last_Intr_Recd_Date`)+1) AS 'Days' FROM investments.alm_bond WHERE Maturity_Date>='$asondate' AND Last_Intr_Recd_Date<='$asondate'
		) a 
		ORDER BY Purchase_Date";
//echo $sql;
//show_query_output($sql);
$result = mysqli_query($conn,$sql);


echo "<br><center><table  class='table table-hover table-bordered' style='width:80%' >";

echo "<thead><tr><th>S.No</th>";
$fields_num1 = mysqli_num_fields($result);

for($i=0; $i<$fields_num1; $i++)
{
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
    $tot_Intr_Rbl+=$row[9];

}
echo "<h1><label class='btn btn-success' style='font-size: 20px'>Interest Receivables on Bonds (as on $asondate) : 
		<b>Rs." . indian_money_format($tot_Intr_Rbl) . "</b></label></h1>";
// echo "<h2>Interest Receivables on Bonds as on $asondate : <u>Rs. $tot_Intr_Rbl</u></h2>";
echo "</tbody></table><br><br>";

}

else
{
?>


<?php    

	 	$query = "select * from investments.alm_bond order by Purchase_Date desc";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);

		$test = $test . "<table border=1>";
		$test = $test . "<tr><th><b>S.No.</b></th>";
		$test = $test . "<th><b>Purchase Date</b></th>";
		$test = $test . "<th><b>Invest Particulars</b></th>";
		$test = $test . "<th><b>Face Value</b></th>";
		$test = $test . "<th><b>Book Value</b></th>";
		$test = $test . "<th><b>Purchase Value</b></th>";
		$test = $test . "<th><b>Maturity Date</b></th>";
		$test = $test . "<th><b>Interest Rate</b></th>";
		$test = $test . "<th><b>ISIN</b></th>"; 

		?>

<?php
//include 'bond_feed.php';
?>
		<div style="display:flex;flex-direction: column-reverse;">
			<div>
			<table class='table table-hover table-bordered' id="my_filter_table">
			<thead>
				<tr>
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Purchase Date  </b></th> 
				<th style="text-align: center; "><b>Invest Particulars  </b></th> 
				<th style="text-align: center;"><b>Face Value  </b></th> 
				<th style="text-align: center;"><b>Book Value  </b></th> 
				<th style="text-align: center;"><b>Purchase Value  </b></th> 
				<th style="text-align: center;"><b>Maturity Date  </b></th> 
				<th style="text-align: center;"><b>Interest Rate  </b></th> 
				<th style="text-align: center;"><b>ISIN  </b></th>  
				<th style="text-align: center;"><b>Last Interest Received Date</b></th>  
			</tr>
			</thead>
			<tbody>
				<?php if ($editId) { ?>
				<tr style="height: 35px; background-color:  #DDFFFF; vertical-align:middle">
				<form class="form-inline" method="post" action="">
					<td style="text-align: right;">Add New</td> 
					<td style="text-align: left;">
					<input type="date" class="form-control" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>" required="required"  /></td> 
					<td style="text-align: left;"><textarea class="form-control" name="Invest_Particulars" required="required" ><?php echo $row_acc['Invest_Particulars']; ?></textarea> </td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Face_Value" value="<?php echo $row_acc['Amount_Deposited']; ?>" required="required"  /></td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Book_Value" value="<?php echo $row_acc['Amount_Deposited']; ?>" required="required"  /></td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Purchase_Value" value="<?php echo $row_acc['Amount_Deposited']; ?>" required="required" /></td> 
					<td style="text-align: left;">
					<input type="date" class="form-control" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  required="required"  /></td> 
					<td style="text-align: left;">
					<input type="number" step="0.01" class="form-control" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>" required="required"  /></td> 
					<td style="text-align: left;">
					<input type="text" class="form-control" name="ISIN" value="<?php echo $row_acc['ISIN']; ?>"required="required" /></td> 
					<td style="text-align: left;"><input class="form-control btn btn-primary" name="addBond" type="submit" value="Add" /></td> 
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
				<form id="frm_<?php echo $rowcnt; ?>" method="post" action="" readonly="readonly">
					<td style="text-align: left;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><textarea class="form-control" name="Invest_Particulars" style="border:none; background: none; width:100%; height: 30px; padding-bottom:0"><?php echo $row_acc['Invest_Particulars']; ?></textarea> </td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Face_Value" value="<?php echo $row_acc['Face_Value']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Book_Value" value="<?php echo $row_acc['Book_Value']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Purchase_Value" value="<?php echo $row_acc['Purchase_Value']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="text" class="form-control" name="ISIN" value="<?php echo $row_acc['ISIN']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="date" class="form-control" name="Last_Intr_Recd_Date" value="<?php echo $row_acc['Last_Intr_Recd_Date']; ?>" style="border:none; background: none"  /></td> 
					<td id="edit_<?php echo $rowcnt; ?>" style="text-align: left; display: none">
					<?php
					$Entry_ID=$row_acc['Entry_ID'];
					?>
					<div style="display: flex">
						<input class="form-control btn btn-primary" name="updateBond" type="submit" value="Update" style="width: 100%; vertical-align:middle" /> 
						<!--<a href="?Entry_ID=<?php echo $Entry_ID; ?>&opt=del">Delete</a>-->
						&nbsp;&nbsp;&nbsp; <button class="form-control btn btn-primary" name="deleteBond"  style="width: 100%; vertical-align:middle" onclick="confirmDelete('<?php echo $rowcnt; ?>');" >Delete</button>
						<input id="deleteBondSttId_<?php echo $rowcnt; ?>" class="form-control" name="deleteBondStt" type="hidden"  /> 
						<input class="form-control" name="Entry_ID" type="hidden" value="<?php echo $row_acc['Entry_ID']; ?>"  />
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
					<td style="text-align: left;"><?php echo $row_acc['Invest_Particulars']; ?> </td> 
					<td style="text-align: left;"><?php echo $row_acc['Face_Value']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Book_Value']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Purchase_Value']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Maturity_Date']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Interest_Rate']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['ISIN']; ?></td> 
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