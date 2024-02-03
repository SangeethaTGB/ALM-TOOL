<!DOCTYPE HTML>
<html lang="en">
<head><title> Bonds </title></head>
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
input[type=submit] {
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
	
		include 'index.php';
?>

<h2>Bonds</h2>
<?php    

	 	$query = "select * from investments.alm_tdr order by entry_id desc";
// 	 	Entry_ID
// Entry_Date
// Updated_By
// Updated_On


// Purchase_Date
// Bank_Name
// Account_No
// Amount_Deposited
// Maturity_Date
// Interest_Rate
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
			<table class='table table-hover table-bordered' >
			<tr>
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Purchase_Date  </b></th>  
				<th style="text-align: center;"><b>Bank_Name  </b></th>  
				<th style="text-align: center;"><b>Account_No  </b></th>  
				<th style="text-align: center;"><b>Amount_Deposited  </b></th>  
				<th style="text-align: center;"><b>Maturity_Date  </b></th>  
				<th style="text-align: center;"><b>Interest_Rate  </b></th>  
			</tr>
				<tr style="height: 35px; background-color:  #DDFFFF; vertical-align:middle">
				<form method="post" action="">
					<td style="text-align: right;">Add New</td> 				 
		 
					 <td style= 'text-align:left' >  <input type="date" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  /></td>
						<td style= 'text-align:left' >  <input type="text" name="Bank_Name" value="<?php echo $row_acc['Bank_Name']; ?>"  /></td>
						<td style= 'text-align:left' >  <input type="text" name="Account_No" value="<?php echo $row_acc['Account_No']; ?>"  /></td>
						<td style= 'text-align:left' >  <input type="number" step="0.01" name="Amount_Deposited" value="<?php echo $row_acc['Amount_Deposited']; ?>"  /></td>
						<td style= 'text-align:left' >  <input type="date" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  /></td>
						<td style= 'text-align:left' >  <input type="number" step="0.01" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>"  /></td>
						<td style="text-align: left;"><input name="addTDR" type="submit" value="Add TDR" /></td> 
				</form>
				</tr>

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

				<tr id="tr_<?php echo $rowcnt; ?>"  ondblclick="enableEdit('<?php echo $rowcnt; ?>','<?php echo $count; ?>')"  title="Double Click for EDIT"   >
				<form method="post" action="" readonly="readonly">
					<td style="text-align: left;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><input type="date" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  style="border:none; background: none"  /></td>  
					<td style="text-align: left;"> <input type="text" name="Bank_Name" value="<?php echo $row_acc['Bank_Name']; ?>"  style="border:none; background: none"  /></td> 
					<td style="text-align: left;"> <input type="text" name="Account_No" value="<?php echo $row_acc['Account_No']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" name="Amount_Deposited" value="<?php echo $row_acc['Amount_Deposited']; ?>" style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="date" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  style="border:none; background: none"  /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>" style="border:none; background: none"  /></td> 
					 
					<td id="edit_<?php echo $rowcnt; ?>" style="text-align: left; display: none"><input name="updateTDR" type="submit" value="Update" style="width: 100%; vertical-align:middle" /><input name="Entry_ID" type="text" value="<?php echo $row_acc['Entry_ID']; ?>" style="display:none" /></td> 
				</form>
				</tr>
		<?php 

			}
			echo"</table>";
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

			if ($result3)
			{
				header("location:TDR_DISPLAY.php");
			}
			else
			{
				echo "<br>Data Incorrect. Try again."; 
			}
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
			if ($result3)
			{
				header("location:TDR_DISPLAY.php");
			}
			else
			{
				echo "<br>Data Incorrect. Try again."; 
			}
		}
	?>


</body>
</html>