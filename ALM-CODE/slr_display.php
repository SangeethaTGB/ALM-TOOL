<!DOCTYPE HTML>
<html lang="en">
<head><title> SLR </title></head>
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


<!-- 	
		Entry_ID
Entry_Date
Updated_By
Updated_On

Purchase_Date
Maturity_Date
Interest_Rate
Book_Value
ISIN
HTM_AFS
Investment_Particulars
Face_Value
Purchase_Value 
-->

	<?php
	
		$heading = "Bonds";
		include $_SERVER['DOCUMENT_ROOT'] . '\mis\depNoHeader.php';


		$file= "SLR_".trim($EmpBrcode,"").".xls";
		$test="";
		$test = $test .  "<h3>BRANCH CODE ($EmpBrcode)<br></h3>";

		 
	 	$query = "select * from investments.alm_SLR;";
 
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
		<div style="display:flex;flex-direction: column-reverse;">
			<div>
			<table class='table table-hover table-bordered' >
			<tr>
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Purchase_Date  </b></th>   
				<th style="text-align: center;"><b>Maturity_Date  </b></th>   
				<th style="text-align: center;"><b>Interest_Rate  </b></th>   
				<th style="text-align: center;"><b>Book_Value  </b></th>   
				<th style="text-align: center;"><b>ISIN  </b></th>   
				<th style="text-align: center;"><b>HTM_AFS  </b></th>   
				<th style="text-align: center;"><b>Investment_Particulars  </b></th>   
				<th style="text-align: center;"><b>Face_Value  </b></th>   
				<th style="text-align: center;"><b>Purchase_Value  </b></th>   
			</tr>

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
					<td style="text-align: left;"><?php echo $row['Maturity_Date']; ?></td>   
					<td style="text-align: left;"><?php echo $row['Interest_Rate']; ?></td>   
					<td style="text-align: left;"><?php echo $row['Book_Value']; ?></td>   
					<td style="text-align: left;"><?php echo $row['ISIN']; ?></td>   
					<td style="text-align: left;"><?php echo $row['HTM_AFS']; ?></td>   
					<td style="text-align: left;"><?php echo $row['Investment_Particulars']; ?></td>   
					<td style="text-align: left;"><?php echo $row['Face_Value']; ?></td>   
					<td style="text-align: left;"><?php echo $row['Purchase_Value']; ?></td>   
				</tr>

		<?php 

			$test = $test . "<tr><td>".$rowcnt."</td>";
			$test = $test . "<td>".$row['Purchase_Date']."</td>"; 
			$test = $test . "<td>".$row['Maturity_Date']."</td>"; 
			$test = $test . "<td>".$row['Interest_Rate']."</td>"; 
			$test = $test . "<td>".$row['Book_Value']."</td>"; 
			$test = $test . "<td>".$row['ISIN']."</td>"; 
			$test = $test . "<td>".$row['HTM_AFS']."</td>"; 
			$test = $test . "<td>".$row['Investment_Particulars']."</td>"; 
			$test = $test . "<td>".$row['Face_Value']."</td>"; 
			$test = $test . "<td>".$row['Purchase_Value']."</td>"; 
			}
			echo"</table>";
			$test = $test . "</table>";
			}
		else{
			echo "<CENTER><h1>No records to display</h1>";
			}
	?>
		</div> 
	</div>

</body>
</html>