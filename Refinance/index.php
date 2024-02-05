
<!DOCTYPE html>
 <?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);

 
?>


<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>REFINANCE DATA</title>

<!-- 	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<!-- <link rel="stylesheet" href="css/css1.css"> -->
	<link rel="stylesheet" href="css/css2.css">
	<link rel="stylesheet" href="css/font.css">
	<link rel="stylesheet" href="css/boot.css">
	<link rel="stylesheet" href="css/table.css">
	<script src="js/jquery_latest.js"></script>
	<script src="js/boot.js"></script>
	<script src="js/datatable.js"></script>


	
<script>

</script>
		
		
    </head>
    <body>
	<?php
	include 'RefMainMenu.php';
	?>
      				
    </body>
</html>   
