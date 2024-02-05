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
$db = 'refinance';

     $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
     mysqli_select_db($dbconn,$db);	

             $RefID   = $_POST['RefID'];
			
	            $query3 = ("DELETE FROM refinance.refinance_test WHERE RefID='$RefID'");	 
	            $resource3 = mysqli_query($dbconn,$query3);
				echo $query3;
				
                $query4 = ("DELETE FROM refinance.inst_table WHERE RefID='$RefID'");	 
	            $resource4 = mysqli_query($dbconn,$query4);
				echo $query4;
			    $query5 = ("DELETE FROM refinance.refinance_interest_daywise WHERE RefID='$RefID'");	 
	            $resource5 = mysqli_query($dbconn,$query5);
				echo $query5;
				
	           if($resource3 and $resource4 and $resource5)
				 header("location:displayAll.php?Delstatus=1");
               else
				 die("delete failed");   
	
	  
?>


	
</body>
</html>

