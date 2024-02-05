
<!DOCTYPE html>
 
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


function isValidDate(dateString) {
	//alert("please generate dates");
	var m=false;
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  if(dateString.match(regEx) != null){
	alert("correct dates"); 
   m= true;	
  }else{
	 alert("wrong dates"); 
      m= false;	 
  }
  return m;
}



</script>
		
		
    </head>
    <body>	 
	
    <?php
	include 'RefMainMenu.php';
	?>
    
  
   
  
     
   <!--  <div class="column" id="enrtyDiv" style="background-color:#aaa;">
	   <form action="InterestProvision.php" method="post" id="InstForm" name="instForm">
                    Date From:&nbsp; &nbsp; &nbsp; 
                   <input name="Fromdate" type="date" style="height: 19px; " placeholder="yyyy-mm-dd" required /><br><br>
		            Date To:&nbsp; &nbsp; &nbsp; 
                   <input name="Todate" type="date" style="height: 19px;" placeholder="yyyy-mm-dd" required /><br><br>	

				   Interest For: &nbsp; &nbsp; &nbsp;</td><td><select name="refinace"> 
            <?php
			//$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
			//echo "<option value ='All'>All Schemes</option>";
           //  while($row1 = mysqli_fetch_row($getRefId))
           //       echo "<option value = '$row1[0]'>$row1[0] </option>";
			?></select>
				   
		           <button type ="submit" name="generateIntrestProv" >Generate Interest Accumilation</button>
		 
                </form>
     </div>-->
	        
	
        
<div class='col-sm-12'  style='padding-top:0%;border:1px solid green'>
				<center><div style='padding-top:1%;width:50%'>
							<form action="InterestProvision.php" class="form-horizontal" id="InstForm" name="instForm" method="post" style="">
							<div class="form-group">
								<label class="control-label col-sm-2">Date From:</label> 
								<div class="col-sm-3"> <input type='date' name="Fromdate" class="form-control" required /></div> 
							
								<label class="control-label col-sm-2">Date To:</label> 
								<div class="col-sm-3"> <input type='date' name="Todate" class="form-control" required /></div> 
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2">Interest For:</label> 
								<div class="col-sm-3"> <select name="refinace"> 
								<?php
								$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
								echo "<option value ='All'>All Schemes</option>";
								 while($row1 = mysqli_fetch_row($getRefId))
									  echo "<option value = '$row1[0]'>$row1[0] </option>";
								?></select></div> 
							</div>
							
							<div class="form-group">								
							<div class="col-sm-2"> </div> <div class="col-sm-2"> <button type ="submit" class='btn btn-info' name="generateIntrestProv" >Generate Interest Accumilation</button></div> 
						
							</div>
									
							</form>	
				</div></center>	</div>	
                
	
		 
 				
    </body>
	
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

$Insta_count=0;
$stat9=false;
if (isset($_POST['generateIntrestProv']))
{
        $refinance   = $_POST['refinace']; 
        $fromDate   = $_POST['Fromdate'];
        $toDate  = $_POST['Todate'];
	    $date1=$fromDate;
	    $date2=$toDate;
		
	//calculating intrest payment
	
	if($refinance =='All'){
		$query=("SELECT RefID,Refinance_agency,Scheme,Interest FROM refinance_test group by RefID" );
    $status = mysqli_query($dbconn,$query);
	}
	else
	{
	$query=("SELECT RefID,Refinance_agency,Scheme,Interest FROM refinance_test where Refinance_agency='$refinance' group by RefID" );
    $status = mysqli_query($dbconn,$query);	}
	if(mysqli_num_rows($status)>0){
	while($row6= mysqli_fetch_row($status)){
		$refId=$row6[0];
		$Refinance_agency=$row6[1];
		$Scheme=$row6[2];
		$Interest=$row6[3];
		//echo " id: $refId";
		//echo "d1t-$row6[1]--";
		//echo "d2t-$row6[2]<br>";
		$queryInstDate=("SELECT SUM(intrest_amount),count(*), Date_add(Min(Dailydate),interval -1 day) FROM refinance.refinance_interest_daywise rid WHERE rid.RefID='$refId' and rid.dailydate <= '$toDate' AND rid.dailydate >= '$fromDate'");
		$statusInstDate = mysqli_query($dbconn,$queryInstDate);
		//echo $queryInstDate;
		$rowk= mysqli_fetch_row($statusInstDate);
		if($rowk[0]!= '' && $rowk[0]!= null){
		$query2 = ("INSERT INTO IntProvTable (RefID,Intrest_Amount,Refinance_agency,Scheme,Interest,IntrestPeriod) VALUES ('$refId','$rowk[0]','$row6[1]','$row6[2]','$row6[3]','$rowk[1]')");
		$status2 = mysqli_query($dbconn,$query2);
		}
		
	}
	}

	$query3 = ("SELECT RefID,Refinance_agency,Scheme,Interest,Intrest_Amount,IntrestPeriod FROM  intprovtable");
	 
	            $resource3 = mysqli_query($dbconn,$query3);
				$count3 = mysqli_num_rows($resource3);

				echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'>Interest provision form '$fromDate' to '$toDate'</font></h4>";
	   if($count3<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource3);
	  
	   echo "<table  border='1' id='provTable' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	  // echo "<td><b>Interest provision</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource3);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                  $total=0;
				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource3))
                   {
					 
                     echo "<tr>";
					 $colCnt=0;
					 
					 foreach ($row as $cell)
					 {
						 $colCnt=$colCnt+1;
						 if($colCnt==5){
							  $cell=indian_money_format($cell);  	
						$total=$total+$cell;  	
							  echo "<td align='right'>$cell</td>"; 
						         }else					 
						  echo "<td align='center'>$cell</td>";
					 }
                     echo "</tr>";
                   }
                echo "<td></td>";
                 echo "<td></td>"; 
				 echo "<td></td>";                				 
                echo "<td><b>Total Amount</b></td>";
				echo "<td align='right'>$total</td>";
                 echo "</table>";
	
	
	
		$query4 = ("Truncate intprovtable");
	 
	            $resource3 = mysqli_query($dbconn,$query4);
	 
	
	
	
		
	
	
}
	
 
 

 
?>
</div>
<div class='col-sm-2'></div>
</div>	
	
</html>   
