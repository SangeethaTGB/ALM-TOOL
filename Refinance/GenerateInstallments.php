
<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);




?>
<html>
<head>
</head>
<body>

<style>
#headerDiv{
	text-align: center;
	height: auto;
	padding: 10px;	
	background-color :#7FFFD4;
	font-size: 15px;
}

#mydiv{  
    position:relative;
	padding: 10px;
	background-color: #E6E6FA;
    margin:0 auto;
    clear:left;
    height:auto;
    z-index: 0;
    text-align:center;/* Add This*/
}​
#InstForm{
	text-align: center;
	height: auto;
}

#InstDiv{
	text-align: center;
	height: auto;
}

</style>


	
    <?php
	include 'RefMainMenu.php';
	?>

	<!--<div id="InstDiv" style="background-color:#aaa;">
	
	<form action="GenerateInstallments.php" method="post" id="InstForm" name="instForm">
                    Date From:&nbsp; &nbsp; &nbsp; 
                   <input name="Fromdate" type="date" style="height: 19px; " placeholder="yyyy-mm-dd" required /><br><br>
		            Date To:&nbsp; &nbsp; &nbsp; 
                   <input name="Todate" type="date" style="height: 19px;" placeholder="yyyy-mm-dd" required /><br><br>	

				   Search For: &nbsp; &nbsp; &nbsp;</td><td><select name="refinace"> 
            <?php
			//$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
			//echo "<option value ='All'>All Schemes</option>";
            // while($row1 = mysqli_fetch_row($getRefId))
            //      echo "<option value = '$row1[0]'>$row1[0] </option>";
			?></select>
				   
		           <button type ="submit" name="generate" >Generate payment schedule</button>
		 
                </form>
	</div>-->
	
	
	
	<div class='col-sm-12'  style='padding-top:0%;border:1px solid green'>
				<center><div style='padding-top:1%;width:50%'>
							<form action="GenerateInstallments.php" class="form-horizontal" id="InstForm" name="instForm" method="post" style="">
							<div class="form-group">
								<label class="control-label col-sm-2">Date From:</label> 
								<div class="col-sm-3"> <input type='date' name="Fromdate" class="form-control" required /></div> 
							
								<label class="control-label col-sm-2">Date To:</label> 
								<div class="col-sm-3"> <input type='date' name="Todate" class="form-control" required /></div> 
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2">Search For:</label> 
								<div class="col-sm-3"> <select name="refinace"> 
								<?php
								$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
								echo "<option value ='All'>All Schemes</option>";
								 while($row1 = mysqli_fetch_row($getRefId))
									  echo "<option value = '$row1[0]'>$row1[0] </option>";
								?></select></div> 
							</div>
							
							<div class="form-group">								
							<div class="col-sm-2"> </div> <div class="col-sm-2"> <button type ="submit" class='btn btn-info' name="generate" >Generate Interest Accumilation</button></div> 
						
							</div>
									
							</form>	
				</div></center>	</div>	
                
	<div class='row'>
		<div class='col-sm-2'></div>
	<div class='col-sm-8'  style='padding-top:0%;border:0px solid green'>
	
	<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

     $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
     mysqli_select_db($dbconn,$db);
	 if (isset($_POST['generate'])){

                $refinance   = $_POST['refinace']; 
                $fromDate   = $_POST['Fromdate'];
                $toDate  = $_POST['Todate'];
			    if($refinance=='All'){
				$query = ("SELECT * FROM refinance.inst_table WHERE Inst_date between '$fromDate' and '$toDate' order by  Refinance_agency");
				}else
	            $query = ("SELECT * FROM refinance.inst_table WHERE Inst_date between '$fromDate' and '$toDate' and 	Refinance_agency='$refinance' ");
	 
	            $resource2 = mysqli_query($dbconn,$query);
				$count = mysqli_num_rows($resource2);
		
				echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'>Payments from '$fromDate' to '$toDate' </font></h4>";
	   	     //echo "$fromDate";
			 //echo " to ";
			// echo "$toDate";
	   if($count<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource2);
	  echo "<table  border='1'  class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   //echo "<td><b>Installment data</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource2);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                  $total1=0;
				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource2))
                   {
					 
                     echo "<tr>";
					 $colCnt1=0;
					 foreach ($row as $cell)
					 {
						 	$colCnt1=$colCnt1+1; 	
                          if($colCnt1==7) {  
						$total1=$total1+$cell;  }

						if($colCnt1==4 || $colCnt1==7){
							$cell=indian_money_format($cell);
							echo "<td align='right'>$cell</td>";
						}else{
							echo "<td align='right'>$cell</td>";
						}	
							 			 
						  
					 }
                     echo "</tr>";
                   }
                   $total2=indian_money_format($total1);
				   echo "<td></td>";
				   echo "<td></td>";
                 echo "<td></td>";
                 echo "<td></td>";
				 echo "<td></td>";
                echo "<td><b>Total Amount</b></td>";
				echo "<td align='right'>$total2</td>";

                 echo "</table>";
				 
				 
				 
		//Total Installments
	if($refinance=='All'){
	$query3=("SELECT Refinance_agency,SUM(Inst_amt) TotalDue FROM refinance.inst_table where Inst_date BETWEEN '$fromDate' AND '$toDate' GROUP BY Refinance_agency ");
	$resource3 = mysqli_query($dbconn,$query3);
	  $count3 = mysqli_num_rows($resource3); 
	  	echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'>TOTAL INSTALLMENTS DUE</font></h4>";
	   if($count3<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource3);
	   
	   echo "<table  border='1' id='TotalOutstandingTable' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	  // echo "<td><b>Total Installment Due</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource3);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                 
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource3))
                   {
					 
                     echo "<tr>";
					 $colCnt1=0;
					 foreach ($row as $cell)
					 {						 	
                      echo "<td align='right'>$cell</td>";
					 }
                     echo "</tr>";
                   }
				   				

                 echo "</table>";
	}
	   //Intrest schedule
	   
	   
	// Total Intrest due
	// if($refinance=='All'){
	// $query4=("SELECT Refinance_agency,SUM(Intrest_Amount) TotalDue FROM interest_table where IntrestPaydate BETWEEN '$fromDate' AND '$toDate' GROUP BY Refinance_agency ");
	// $resource4 = mysqli_query($dbconn,$query4);
	  // $count4 = mysqli_num_rows($resource4); 
	   // if($count4<1)
		   // die("No Records Found");
	   
	   
	   // $fieldCnt=mysqli_num_fields($resource4);
	   // echo "<table id='TotalOutstandingTable' border='1'><tr>";
	   // echo "<td><b>Total Intrest Due</b></td>";
					 // echo "</tr>";
					 // echo "<tr>";
	   // for($i=0;$i<$fieldCnt;$i++)
	   // {
		   // $fieldName=mysqli_fetch_field($resource4);
		   // echo "<th>$fieldName->name</th>";  
       // } 		   
       // echo "</tr>";
                 
				  // $TotalPayment="Total_payment";
                  // while($row    = mysqli_fetch_row($resource4))
                   // {
					 
                     // echo "<tr>";
					 // $colCnt1=0;
					 // foreach ($row as $cell)
					 // {						 	
                      // echo "<td align='right'>$cell</td>";
					 // }
                     // echo "</tr>";
                   // }
				   				

                 // echo "</table>";
	   
	// }  
	   
	  }
	 
	  	

	  
?>

</div>
<div class='col-sm-2'></div>
</div>
	
</body>
</html>

