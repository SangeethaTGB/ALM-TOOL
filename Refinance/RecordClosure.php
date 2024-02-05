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

             $RefID   = $_POST['RefID_1'];
			 
			 $queryfetchrec = ("select Refinance_agency, Scheme, Refi_date, Interest, Amount, First_installment, Payment_cycle, No_installments from refinance.refinance_test where RefID='$RefID'");
	            $fetchrec = mysqli_query($dbconn,$queryfetchrec);
				
				while($row = mysqli_fetch_row($fetchrec)){
				$Refinance_agency=$row[0];
				$Scheme=$row[1];	
				$Refi_date=$row[2];
				$Interest=$row[3];
				$Amount=$row[4];
				//$IntrestPaydate=$row[5];
				//$IntrestPayperiod=$row[6];
				$First_installment=$row[5];
				$Payment_cycle=$row[6];
				$No_installments=$row[7];
				
				 $queryInsrt = ("INSERT INTO refinance.closed_records (RefID,Refinance_agency, Scheme, Refi_date, Interest, Amount, First_installment, Payment_cycle, No_installments ) VALUES ('$RefID','$Refinance_agency', '$Scheme', '$Refi_date', '$Interest', '$Amount', '$First_installment', '$Payment_cycle', '$No_installments')");
				 $insrt = mysqli_query($dbconn,$queryInsrt);
				 echo $queryInsrt;
				 if(!$insrt)				 
				 die("Record Closure failed"); 
			 
			    
				}
			    
	            $query3 = ("DELETE FROM refinance.refinance_test WHERE RefID='$RefID'");	 
	            $resource3 = mysqli_query($dbconn,$query3);
				
				//$queryfetchinstRec = ("select RefID, Refinance_agency, Scheme, Amount_Sanctioned, Interest, Inst_date, Inst_amt, Installment_NO, outStanding from refinance.inst_table where RefID='$RefID'");
	           // $fetchinstRec = mysqli_query($dbconn,$queryfetchinstRec);
				$queryInsrtInstRec = ("INSERT INTO refinance.closedinstallmentrecords (RefID,Refinance_agency, Scheme, Amount_Sanctioned, Interest, Inst_date, Inst_amt, Installment_NO, outStanding ) select RefID, Refinance_agency, Scheme, Amount_Sanctioned, Interest, Inst_date, Inst_amt, Installment_NO, outStanding from refinance.inst_table where RefID='$RefID' ");
				 $insrt = mysqli_query($dbconn,$queryInsrtInstRec);
				 echo $queryInsrtInstRec;
				 if(!$insrt){				 
				 die("Installment Record insertion failed");
				 }else{
					$query4 = ("DELETE FROM refinance.inst_table WHERE RefID='$RefID'");	 
	            $resource4 = mysqli_query($dbconn,$query4); 
				 }
				//while($row1 = mysqli_fetch_row($fetchinstRec)){
				//$RefID=$row1[0];
				//$Refinance_agency=$row1[1];	
				//$Scheme=$row1[2];
				//$Amount_Sanctioned=$row1[3];
				//$Interest=$row1[4];
				//$Inst_date=$row1[5];
				//$Inst_amt=$row1[6];
				//$Installment_NO=$row1[7];
				//$outStanding=$row1[8];
					//}
				
				
			
			
				
				
	           if($resource3 and $resource4)
				 header("location:displayAll.php?Delstatus=1");
               else
				 die("deletetion after closure failed");   
	
			   
			
	

	   
	 
	 
	 
	 
	 
	

	  
?>


	
</body>
</html>

