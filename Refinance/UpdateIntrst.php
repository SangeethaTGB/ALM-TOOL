
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
        <title>sample</title>
		
	<style>

/* Create two equal columns that floats next to each other */
.column {
    float: center;
    width: 100%;
    padding: 10px;
    height: auto; /* Should be removed. Only for demonstration */
}

.column1 {
    float: center;
    width: 100%;
    padding: 10px;
    height: auto; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
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


#NewForm {
    float: center;
    width: 60%;
    padding: 10px;
    height: auto; /* Should be removed. Only for demonstration */
}

#headerDiv{
	text-align: center;
	height: auto;
	padding: 10px;	
	background-color :#7FFFD4;
	font-size: 15px;
}

#enrtyDiv{
	text-align: center;
	height: auto;
}
#InstDiv{
	text-align: center;
	height: auto;
}


</style>	
	
<script>




  
	
	


</script>
		
		
    </head>
    <body>	 
	
    <?php
	include 'RefMainMenu.php';
	?>
    
  
   
  
     
     <div class="column" id="enrtyDiv" style="background-color:#dcdcdc;">
	   <form action="" method="post" id="NewForm" name="entry">
	      
           <div id="entryForm">  
		   
             <br>
             <table align="center" ><tr><td>
             Refinance Id: &nbsp; &nbsp; &nbsp;</td><td><select name="refinaceId"> 
            <?php
			$getRefId=mysqli_query($dbconn,"SELECT RefID,Scheme,Refinance_agency FROM refinance_test ORDER BY RefID ASC");
             while($row = mysqli_fetch_row($getRefId))
                  echo "<option value = '$row[0]'>$row[0] - $row[1] - $row[2]</option>";
			?>
            </select></td></tr>
			 
              </table>         
			 
			    <button type ="submit" id="view" name="view" align="center" value="view" > View</button>	 
		        <button type ="submit" id="submit" name="UpdateInterest" align="center" value="Update Interest" > Update</button>	 
			 
           </div>
 
                

 
        </form>
     </div>
	                		 
 				
    </body>
	
	
	
	<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);

$Insta_count=0;


 if (isset($_POST['UpdateInterest']))
{
    $refinance   = $_POST['refinaceId'];  	
    $pendingCnt=0;			
	$query5 = ("SELECT Scheme,Refinance_agency FROM refinance_test WHERE RefID='$refinance'");
	   $resource5 = mysqli_query($dbconn,$query5);
	    $res = mysqli_fetch_row($resource5);
	  // echo $query5;
		echo "<h3 align='center'>Update Interest Payment</h3>";
        //echo $res[1];   
		echo "<form action='' method='post'>";
		echo "<table align='center' class='' border='1' >";
		echo "<tr><td>RefID: </td><td><input type='text' name='refId' value='$refinance' readonly/></td></tr>";
		echo "<tr><td>Scheme: </td><td><input type='text' name='Scheme' value='$res[1]' readonly/></td></tr>";
		echo "<tr><td>Refinance_agency: </td><td><input type='text' name='Refinance_agency' value='$res[0]' readonly/></td></tr>";
		echo "<tr><td>Paid Amount: </td><td><input type='text' name='Amount_paid'/></td></tr>";
		echo "<tr><td>Paid_Date: </td><td><input type='date' name='Paid_Date' /></td></tr>";
		echo "<tr><td>UTR: </td><td><input type='text' name='utr'/></td></tr>";
		echo "<tr><td></td><td><input type='submit' name='add' value='Add'/></td></tr>";
		echo "</tr></table>";
		echo "</form>";
		}		 				 


		
		
		
if (isset($_POST['add']))
{
    $refinance   = $_POST['refId']; 
	$Scheme   = $_POST['Scheme']; 
	$Refinance_agency   = $_POST['Refinance_agency']; 
	$Amount_paid   = $_POST['Amount_paid']; 
	$Paid_Date   = $_POST['Paid_Date']; 
	$utr   = $_POST['utr'];  	
    $pendingCnt=0;			
	$query5 = ("Insert Into interest_payment_history (RefID,Refinance_agency,Scheme,Amount_paid,Paid_Date,UTR_No) values ('$refinance','$Refinance_agency','$Scheme','$Amount_paid','$Paid_Date','$utr')");
	   $resource5 = mysqli_query($dbconn,$query5);
	   
	   //echo $query5;
	   
	   
	   if($resource5){
		   echo "<script>alert('inserted sucessfully')</script>";
	   }else{
		 echo "<script>alert('insertion failed')</script>" ; 
	   }
		
		}

if (isset($_POST['view']))
{
    $refinance   = $_POST['refinaceId'];  
	//$scheme   = $_POST['scheme'];  
		
    $pendingCnt=0;			
	$query5 = ("SELECT RefID,Refinance_agency,Scheme,Amount_paid,Paid_Date,UTR_No  FROM  interest_payment_history WHERE RefID='$refinance' order by Paid_Date");
	    $resource5 = mysqli_query($dbconn,$query5);
	    $count5 = mysqli_num_rows($resource5);
		//echo $query5;
		if($count5<1){
		die ("No Payment History recorded");
		}else{
	   
	   $fieldCnt=mysqli_num_fields($resource5);
	   echo "<table border='1'><tr>";
	   echo "<td><b>Intrest Pay History</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource5);
		   echo "<th>$fieldName->name</th>";  
       } 	
       echo "<th>Delete</th>";  	   
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
                        if($colCnt==5) 
						{                        							
						  echo "<td align='center'>$cell</td>";
						$amountPaidDate=$cell;
						}else if($colCnt==6)
						{    	 					 
						  echo "<td align='center'>$cell</td>";
						  $UtrNO=$cell;
						}else
							echo "<td align='center'>$cell</td>";
					 }
					 
										
						
				   echo "<td>
					 <form action='' method='post'>
					 <input type='hidden' name='RefID' value='$refinance' />
					 <input type='hidden' name='Paid_Date' value='$amountPaidDate'/>
					 <input type='hidden' name='utrNo' value='$UtrNO' />
					 <br><input type='submit' name='delete' value='Delete' />
					 </form></td>";
					 $pendingCnt=1;
				     
					
                     echo "</tr>";
					 
                   }
                 
				   
                 echo "</table>";
}		 				 
}
if (isset($_POST['delete']))
{
    $refinance   = $_POST['RefID']; 
	$Paid_Date   = $_POST['Paid_Date']; 
	$utr   = $_POST['utrNo'];  	
    $pendingCnt=0;			
	$querydel = ("delete from interest_payment_history where Paid_Date='$Paid_Date' and UTR_No='$utr'");
	   $resourceDel = mysqli_query($dbconn,$querydel);
	   
	 //  echo $querydel;
	   
	   
	   if($resourceDel){
		   echo "<script>alert('deleted sucessfully')</script>";
	   }else{
		 echo "<script>alert('deleted failed')</script>" ; 
	   }
		
		}

 
?>

</html>   
