<html>
<head>
</head>
<body>
<script>

</script>
	
	    <?php
	include 'RefMainMenu.php';
	?>

	
	<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

     $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
     mysqli_select_db($dbconn,$db);	


   
 ?>
     
	
	<?php
			
			
	            $query = ("SELECT * FROM refinance.closed_records order by Refinance_agency,RefID");
	 
	            $resource2 = mysqli_query($dbconn,$query);
				$count = mysqli_num_rows($resource2);
	   echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'>CLOSED RECORDS</font></h4>";
	   if($count<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource2);
	  echo "<table  border='1'  class='table table-bordered' style='font-family:initial' >";
	 echo "<tr class='warning'>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource2);
		   echo "<th style='background-color:lightsalmon'>$fieldName->name</th>";  
       } 
          		  
       echo "</tr>";

				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource2))
                   {
					 
                     echo "<tr>";
					 $colCnt=0;
					 foreach ($row as $cell)
					 {
						 $colCnt=$colCnt+1;
						 if($colCnt==1){
						  echo "<td><a href='ClosedRecordDetails.php?RefID=$cell'>$cell</a></td>";
						 $RefID=$cell;}
						 else if($colCnt==6){
						 		 $cell=indian_money_format($cell); 
						 		  echo "<td align='right'>$cell</td>"; 	
						 }
                         else{
                             						 
						       echo "<td>$cell</td>";
						 }
					 }
					 
                     echo "</tr>";
					 
                   }

                 echo "</table>";
				 

	   
	 
	 
	 
	 
	 
	

	  
?>


	
</body>
</html>

