<html>
<head>
</head>
<body>
<script>
function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete?");
  if (x)
      return true;
  else
    return false;
}
function Closure()
{
  var x = confirm("Are you sure you want to Close the record?");
  if (x)
      return true;
  else
    return false;
}

function Edit()
{
  var x = confirm("Are you sure you want to Edit the record?");
  if (x)
      return true;
  else
    return false;
}

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


   if($_GET['Delstatus']==1) 
	 echo "<script>alert('Deleted sucessfully');</script>"; 
 ?>
 
 
 <div class="container" style="width: 100%;border:1px solid black; padding:0px">
		
	<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
    
	
	<?php
			
			
	            $query = ("SELECT RefID as 'Refinance-Id', Refinance_agency as 'Sanctioned Agency', Scheme, Refi_date as 'Sanction Date', Interest, Amount as 'Sanctioned Amount', First_installment as 'Installment Start Date',Payment_cycle as 'Payment cycle in months', No_installments as 'No of installments' FROM REFINANCE.refinance_test order by Refinance_agency,RefID");
	 
	            $resource2 = mysqli_query($dbconn,$query);
				$count = mysqli_num_rows($resource2);
	   if($count<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource2);
	   echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'>LIST OF REFINANCES </font></h4>";
	 echo "<table  border='1' class='table table-bordered' style='FONT-FAMILY: INITIAL;' >";
	 echo "<tr class='warning'>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource2);
		   echo "<th style='background-color:lightsalmon;'>$fieldName->name</th>";  
       } 
          echo "<th style='background-color:lightsalmon;'>Delete</th>"; 
          echo "<th style='background-color:lightsalmon;'>Closure</th>";
		  echo "<th style='background-color:lightsalmon;'>Edit</th>"; 		  
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
						  echo "<td><a href='ListDetails.php?RefID=$cell'>$cell</a></td>";
						 $RefID=$cell;}
                         else{
                              if($colCnt==6){
								  $cell=indian_money_format($cell);
							  echo "<td align='right'>$cell</td>"; 
						         }else	{						 
						       echo "<td>$cell</td>";
						   }
						 }
					 }
					 echo "<td>
					 <form action='DeleteEntry.php' method='post'>
					 <input type='text' name='RefID' value='$RefID' style='display:none'/>
					 <input type='submit' Onclick='return ConfirmDelete()' value='Delete'/>
					 </form></td>";
					 echo "<td>
					 <form action='RecordClosure.php' method='post'>
					 <input type='text' name='RefID_1' value='$RefID' style='display:none'/>
					 <input type='submit' Onclick='return Closure()' value='Close Record'/>
					 </form></td>";
					 echo "<td>
					 <form action='EditRecord.php' method='post'>
					 <input type='text' name='RefID_edit' value='$RefID' style='display:none'/>
					 <input type='submit' Onclick='return Edit()' name='EditRecord' value='Edit Record'/>
					 </form></td>";
                     echo "</tr>";
					 
                   }

                 echo "</table>";
				 

?>

</div>
<div class="col-sm-1"></div>
</div>
	
</body>
</html>

