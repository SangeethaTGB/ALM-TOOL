<!DOCTYPE HTML>
<html lang="en">
<head><title> Mutual Funds </title></head>
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


<h2>Investments on Mutual Funds </h2>

	<?php
	
		$heading = "Bonds";


		$file= "MF_".trim($EmpBrcode,"").".xls";
		$test="";
		$test = $test .  "<h3>BRANCH CODE ($EmpBrcode)<br></h3>";

		 
	 	$query = "select * from investments.alm_MF;";
 
		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);

		$test = $test . "<table border=1>";
		$test = $test . "<tr><th><b>S.No.</b></th>";
		$test = $test . "<th><b>Purchase_Date</b></th>"; 
		$test = $test . "<th><b>Invest_Particulars</b></th>"; 
		$test = $test . "<th><b>Face_Value</b></th>"; 
		$test = $test . "<th><b>Market_Value</b></th>"; 
		$test = $test . "<th><b>Purchase_Value</b></th>"; 
		$test = $test . "<th><b>Appr_Dep</b></th>"; 

		?>
		<div style="display:flex;flex-direction: column-reverse;">
			<div>
			<table class='table table-hover table-bordered' id="my_filter_table">
			<thead><tr>
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Purchase Date  </b></th>  
				<th style="text-align: center;"><b>Invest Particulars  </b></th>  
				<th style="text-align: center;"><b>Face Value  </b></th>  
				<th style="text-align: center;"><b>Market Value  </b></th>  
				<th style="text-align: center;"><b>Purchase Value  </b></th>  
				<th style="text-align: center;"><b>Appr Dep  </b></th>  
			</tr></thead><tbody>

		<?php
		
		if ($count > 0)
		{
			$rowcnt=0;
			while($row=mysqli_fetch_assoc($result)){
			$rowcnt=$rowcnt+1;
		?>

				<tr style="height: 35px;">
					<td style="text-align: right;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><?php echo $row['Purchase_Date']; ?></td>  
					<td style="text-align: left;"><?php echo $row['Invest_Particulars']; ?></td>  
					<td style="text-align: left;"><?php echo $row['Face_Value']; ?></td>  
					<td style="text-align: left;"><?php echo $row['Market_Value']; ?></td>  
					<td style="text-align: left;"><?php echo $row['Purchase_Value']; ?></td>  
					<td style="text-align: left;"><?php echo $row['Appr_Dep']; ?></td>  
				</tr>

		<?php 

			$test = $test . "<tr><td>".$rowcnt."</td>";
			$test = $test . "<td>".$row['Purchase_Date']."</td>";  
			$test = $test . "<td>".$row['Invest_Particulars']."</td>";  
			$test = $test . "<td>".$row['Face_Value']."</td>";  
			$test = $test . "<td>".$row['Market_Value']."</td>";  
			$test = $test . "<td>".$row['Purchase_Value']."</td>";  
			$test = $test . "<td>".$row['Appr_Dep']."</td>";  
			}
			echo"</table>";
			$test = $test . "</table>";
			}
		else{
			echo "<CENTER><h1>No records to display</h1>";
			}
		?>
	</tbody></table>
		</div>
	</div>

</body>
</html>