
<!DOCTYPE HTML>
<html lang="en">
<head>
<link rel="shortcut icon" href="file:///localhost/mis/tgb.jpg">
</head>
<body >
  
				<center>
					<h2>Dear <?php echo $EmpDesig; ?>, Kindly enter Bond Data</h2>
					<form method="post" action=""> 
						<table class='table table-hover table-bordered' border='1' >
							<tr>
								<th style= 'text-align:right' >	Purchase/Invested Date :</th>
								<td style= 'text-align:left' >  <input type="date" name="Purchase_Date" value="<?php echo $row_acc['Purchase_Date']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Investment Particulars :</th>
								<td style= 'text-align:left' >  <input type="text" name="Invest_Particulars" value="<?php echo $row_acc['Invest_Particulars']; ?>"  /></td>
							</tr> 							
							<tr>
								<th style= 'text-align:right' >Face Value :</th>
								<td style= 'text-align:left' >  <input type="number" step="0.01" name="Face_Value" value="<?php echo $row_acc['Amount_Deposited']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >Book Value :</th>
								<td style= 'text-align:left' >  <input type="number" step="0.01" name="Book_Value" value="<?php echo $row_acc['Amount_Deposited']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >Purchase Value :</th>
								<td style= 'text-align:left' >  <input type="number" step="0.01" name="Purchase_Value" value="<?php echo $row_acc['Amount_Deposited']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Maturity Date :</th>
								<td style= 'text-align:left' >  <input type="date" name="Maturity_Date" value="<?php echo $row_acc['Maturity_Date']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	Interest Rate :</th>
								<td style= 'text-align:left' >  <input type="number" step="0.01" name="Interest_Rate" value="<?php echo $row_acc['Interest_Rate']; ?>"  /></td>
							</tr>
							<tr>
								<th style= 'text-align:right' >	ISIN :</th>
								<td style= 'text-align:left' >  <input type="text" name="ISIN" value="<?php echo $row_acc['Invest_Particulars']; ?>"  /></td>
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

			if ($result3)
			{
				header("location:bond_DISPLAY.php");
			}
			else
			{
				echo "<br>Data Incorrect. Try again."; 
			}
		}
	?>
</body>
</html>


