
<!DOCTYPE html>
 
<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);

$Insta_count=0;


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Closed Record Details</title>
		
	
	
	
<script>



</script>
		
		
    </head>
    <body>	 
	
    <?php
	include 'RefMainMenu.php';
	?>
   				
    </body>
	
	
	
	<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);

$Insta_count=0;


    $refinance   = $_GET['RefID'];   	
    $pendingCnt=0;			
	$query5 = ("SELECT *  FROM refinance.closedinstallmentrecords WHERE RefID='$refinance' order by Installment_No");
	    $resource5 = mysqli_query($dbconn,$query5);
	    $count5 = mysqli_num_rows($resource5);
		if($count5<1)
		   die("No Installment History Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource5);
	   echo "<table  border='1'  class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   echo "<td><b>Principle payment schedule</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource5);
		   echo "<th>$fieldName->name</th>";  
       } 	
       echo "<th>Edit</th>";  	   
       echo "</tr>";

				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource5))
                   {
					 
                     echo "<tr>";
					 $colCnt=0;
					 foreach ($row as $cell)
					 {
						$colCnt=$colCnt+1;
                           					
						  echo "<td align='center'>$cell</td>";
					 }
					 
						 echo "<td></td>";
                     echo "</tr>";
					 
                   }
                 
				   
                 echo "</table>";
				 
				 

	
				 				 

 
?>

</html>   
