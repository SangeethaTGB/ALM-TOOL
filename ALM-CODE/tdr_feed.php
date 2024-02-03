
<!DOCTYPE HTML>
<html lang="en">
<head>
<title> TDR Enter</title>
<link rel="shortcut icon" href="file:///localhost/mis/tgb.jpg">
</head>
<body >
	<?php 
		$heading = "Enter TDRs";
		include $_SERVER['DOCUMENT_ROOT'] . '\mis\depnoheader.php';
		 
		echo "<form method='post'>"; 
		
	?> 
	</form> 
  
				<center>
					<h2>Dear <?php echo $EmpDesig; ?>, Kindly enter TDR Data</h2>
					<form method="post" action=""> 
						<table class='table table-hover table-bordered' border='1' >

							<tr>
								<th style= 'text-align:right' >	Purchase/Invested Date :</th>
								<td style= 'text-align:left' >  <input type="date" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Bank Name :</th>
								<td style= 'text-align:left' >  <input type="text" name="Bank_Name" value="<?php echo $row_acc['Bank_Name']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Account Number :</th>
								<td style= 'text-align:left' >  <input type="text" name="Account_No" value="<?php echo $row_acc['Account_No']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Amount Deposited :</th>
								<td style= 'text-align:left' >  <input type="number" step="0.01" name="Amount_Deposited" value="<?php echo $row_acc['Amount_Deposited']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Maturity Date :</th>
								<td style= 'text-align:left' >  <input type="date" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Interest Rate :</th>
								<td style= 'text-align:left' >  <input type="number" step="0.01" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>"  /></td>
							</tr> 
				 
				 
			 

							<tr><td style= 'text-align:center' colspan="2" ><button TYPE="SUBMIT" name="UPDATE" />Save</button></td>
							</tr>
						</table>
					</form>
				</center>
	
	<?php
		  



 


		if(isset($_POST["UPDATE"]))
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


