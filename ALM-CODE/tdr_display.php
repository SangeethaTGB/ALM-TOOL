<!DOCTYPE HTML>
<html lang="en">
<head><title> TDRs | ALM </title></head>
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
<body>

		<CENTER>



<?php
		if($_POST["deleteEntryStt"]=="true")
		{	  
			$Entry_ID = $_POST['Entry_ID'];
			$sql_del="delete from investments.alm_tdr where Entry_ID=$Entry_ID";
			$res_del=mysqli_query($conn,$sql_del);
		}
		
		if(isset($_POST["updateTDR"]))
		{	  
			$Purchase_Date = $_POST['Purchase_Date'];
			$Bank_Name = $_POST['Bank_Name'];
			$Account_No = $_POST['Account_No'];
			$Amount_Deposited = $_POST['Amount_Deposited'];
			$Maturity_Date = $_POST['Maturity_Date'];
			$Interest_Rate = $_POST['Interest_Rate'];
			$Entry_ID = $_POST['Entry_ID'];
			$sql3 = "update investments.alm_tdr set 
													Updated_By='$pid',
													Updated_On = now(),
													Purchase_Date=NULLIF('$Purchase_Date',''),
													Bank_Name=NULLIF('$Bank_Name',''),
													Account_No=NULLIF('$Account_No',''),
													Amount_Deposited=NULLIF('$Amount_Deposited',''),
													Maturity_Date=NULLIF('$Maturity_Date',''),
													Interest_Rate=NULLIF('$Interest_Rate','') 
					where Entry_ID=$Entry_ID";
					
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);
		}

		if(isset($_POST["addTDR"]))
		{	  
			$Purchase_Date = $_POST['Purchase_Date'];
			$Bank_Name = $_POST['Bank_Name'];
			$Account_No = $_POST['Account_No'];
			$Amount_Deposited = $_POST['Amount_Deposited'];
			$Maturity_Date = $_POST['Maturity_Date'];
			$Interest_Rate = $_POST['Interest_Rate'];
			

			$sql3 = "INSERT INTO investments.alm_tdr(
													Entry_Date,
													Updated_By,
													Updated_On,
													Purchase_Date,
													Bank_Name,
													Account_No,
													Amount_Deposited,
													Maturity_Date,
													Interest_Rate 
													) 
					values (
							CURRENT_DATE(),
							'$pid',
							now(),
							NULLIF('$Purchase_Date',''), 
							NULLIF('$Bank_Name',''), 
							NULLIF('$Account_No',''), 
							NULLIF('$Amount_Deposited',''), 
							NULLIF('$Maturity_Date',''), 
							NULLIF('$Interest_Rate','') 
						 )";
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);
		}
	?>

<h2>Deposits in Other Banks - TDRs</h2>


		<form class="form-inline" action="" method="post">
		<input class="form-control" name="asondate" type="date" value="<?php if (isset($asondate)) echo $asondate; else  echo date("Y-m-d");?>" />
		<input class="form-control btn btn-primary" name="showIntrRbl" type="submit" value="Show Interest Receivables" />
		<button class="form-control btn btn-primary" onclick="window.location.href='?';" >Show all</button>
		</form><br>
<?php
if (isset($_POST['showIntrRbl']))
{
//$asondate=date("Y-m-t",strtotime($asondate));
$sql="		SELECT Purchase_Date,	Bank_Name,	Account_No,	Amount_Deposited,	Maturity_Date,	Interest_Rate,Days as 'Completed Days'
		, investments.calc_tdr_interest(Interest_Rate,Purchase_Date,Maturity_Date,'$asondate',Amount_Deposited)  as 'Interest Receivable (Rs.)' FROM
		(
		SELECT *,(DATEDIFF('$asondate',`Purchase_Date`)+1) AS 'Days'
		FROM investments.alm_tdr 
		WHERE Maturity_Date>='$asondate' and Purchase_Date<='$asondate' 
		) a 
		order by Purchase_Date";
// echo $sql;
//show_query_output($sql);
$result = mysqli_query($conn,$sql);


echo "<center><table  class='table table-hover table-bordered' style='width:80%' >";

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
     if ($cnt==4 || $cnt==6 || $cnt==8) 
      echo "<td style='text-align: right'>" . indian_money_format($cell,2) . "</td>";
     else
      echo "<td style='text-align: center'>$cell</td>";
     }
    echo "</tr>";
    $tot_Intr_Rbl+=$row[7];

}
echo "<h1><label class='btn btn-success' style='font-size: 20px'>Interest Receivables on TDRs (as on $asondate) : 
		<b>Rs." . indian_money_format($tot_Intr_Rbl) . "</b></label></h1>";
// echo "<h2>Interest Receivables on TDRs as on $asondate : <u>Rs. $tot_Intr_Rbl</u></h2>";
echo "</tbody></table><br><br>";

}

else
{
?>

<?php    

	 	$query = "select * from investments.alm_tdr order by maturity_date desc";
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);

		$test = $test . "<table border=1>";
		$test = $test . "<tr><th><b>S.No.</b></th>";
		$test = $test . "<th><b>Purchase_Date</b></th>"; 
		$test = $test . "<th><b>Bank_Name</b></th>"; 
		$test = $test . "<th><b>Account_No</b></th>"; 
		$test = $test . "<th><b>Amount_Deposited</b></th>"; 
		$test = $test . "<th><b>Maturity_Date</b></th>"; 
		$test = $test . "<th><b>Interest_Rate</b></th>"; 

		?>

<?php
//include 'bond_feed.php';
?>
		<div style="display:flex;flex-direction: column-reverse;">
			<div>
			<table class='table table-hover table-bordered' id="my_filter_table" >
			<thead><tr>
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Purchase Date  </b></th>  
				<th style="text-align: center;"><b>Bank Name  </b></th>  
				<th style="text-align: center;"><b>Account No  </b></th>  
				<th style="text-align: center;"><b>Amount Deposited  </b></th>  
				<th style="text-align: center;"><b>Maturity Date  </b></th>  
				<th style="text-align: center;"><b>Interest Rate  </b></th>  
			</tr></thead><tbody>
			<?php if ($editId) { ?>
			<tr style="height: 35px; background-color:  #DDFFFF; vertical-align:middle">
				<form class="form-inline" method="post" action="">
					<td style="text-align: right;">Add New</td> 				 
		 
					 <td style= 'text-align:left' >  <input class="form-control" type="date" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  /></td>
						<td style= 'text-align:left' >  <input class="form-control" type="text" name="Bank_Name" value="<?php echo $row_acc['Bank_Name']; ?>"  /></td>
						<td style= 'text-align:left' >  <input class="form-control" type="text" name="Account_No" value="<?php echo $row_acc['Account_No']; ?>"  /></td>
						<td style= 'text-align:left' >  <input class="form-control" type="number" step="0.01" name="Amount_Deposited" value="<?php echo $row_acc['Amount_Deposited']; ?>"  /></td>
						<td style= 'text-align:left' >  <input class="form-control" type="date" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  /></td>
						<td style= 'text-align:left' >  <input class="form-control" type="number" step="0.01" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>"  /></td>
						<td style="text-align: left;"><input class="form-control btn btn-primary" name="addTDR" type="submit" value="Add TDR" /></td> 
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
					<td style="text-align: left;"><input class="form-control" type="date" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  style="border:none; background: none"  /></td>  
					<td style="text-align: left;"> <input class="form-control" type="text" name="Bank_Name" value="<?php echo $row_acc['Bank_Name']; ?>"  style="border:none; background: none"  /></td> 
					<td style="text-align: left;"> <input class="form-control" type="text" name="Account_No" value="<?php echo $row_acc['Account_No']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input class="form-control" type="number" step="0.01" name="Amount_Deposited" value="<?php echo $row_acc['Amount_Deposited']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input class="form-control" type="date" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input class="form-control" type="number" step="0.01" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>" style="border:none; background: none"  /></td> 
					 
					<td id="edit_<?php echo $rowcnt; ?>" style="text-align: left; display: none"><div style="display: flex">
					<input class="form-control btn btn-primary" name="updateTDR" type="submit" value="Update" style="width: 100%; vertical-align:middle" />
					<input class="form-control" name="Entry_ID" type="hidden" value="<?php echo $row_acc['Entry_ID']; ?>"  />
						&nbsp;&nbsp;&nbsp;<button class="form-control btn btn-primary" name="deleteEntry"  style="width: 100%; vertical-align:middle" onclick="confirmDelete('<?php echo $rowcnt; ?>');" >Delete</button>
						<input class="form-control" id="deleteEntrySttId_<?php echo $rowcnt; ?>" name="deleteEntryStt" type="hidden"  /> 
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
					<td style="text-align: left;"><?php echo $row_acc['Bank_Name']; ?> </td> 
					<td style="text-align: left;"><?php echo $row_acc['Account_No']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Amount_Deposited']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Maturity_Date']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Interest_Rate']; ?></td> 

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