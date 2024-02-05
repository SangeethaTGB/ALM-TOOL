<html>
<head>
</head>
<body>

	
	    <?php
	include 'RefMainMenu.php';
	?>

	
	<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'REFINANCE';

     $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
     mysqli_select_db($dbconn,$db);	

	 ?>
     <h1> Interest and Installment payment schedule</h1>
	
	<?php

              $RefID   = $_GET['RefID'];
			
	            $query1 = ("SELECT * FROM REFINANCE.inst_table where RefID='$RefID' order by Installment_NO");
	 
	            $resource1 = mysqli_query($dbconn,$query1);
				$count1 = mysqli_num_rows($resource1);
	   if($count1<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource1);
	   echo "<table border='1'><tr>";
	   echo "<td><b>Installment Schedule</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource1);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";

				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource1))
                   {
					 
                     echo "<tr>";
					 $colCnt=0;
					 foreach ($row as $cell)
					 {
						 $colCnt=$colCnt+1;
						if($colCnt==4 || $colCnt==7 ||$colCnt==9){
							  echo "<td align='right'>$cell</td>"; 
						         }else 					 
						  echo "<td align='center' >$cell</td>";
					 }
                     echo "</tr>";
                   }

                 echo "</table>";
				 

	   //intrest table
	   
	   
	   $query2 = ("SELECT RefID,Refinance_agency,Scheme	Interest,dailydate,outstanding,Intrest_Amount FROM  REFINANCE.refinance_interest_daywise where RefID='$RefID' order by dailydate");
	 
	            $resource2 = mysqli_query($dbconn,$query2);
				$count2 = mysqli_num_rows($resource2);
	   if($count2<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource2);
	   echo "<table border='1'><tr>";
	   echo "<td><b>Interest Schedule</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource2);
		   echo "<th>$fieldName->name</th>";  
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
						 if($colCnt==6){
							  echo "<td align='right'>$cell</td>"; 
						         }else					 
						  echo "<td align='center' >$cell</td>";
					 }
                     echo "</tr>";
                   }

                 echo "</table>";
				 
	  
?>


	
</body>
</html>

