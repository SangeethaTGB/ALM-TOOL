
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
		

<script>


function isValidDate() {
	//alert("please generate dates");
	var dateString=document.getElementById("Todate").value;
	var m=false;
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  console.log(dateString.match(regEx))
  if(dateString.match(regEx) != null){
   m= true;	
  }else{
	 alert(dateString); 
      m= false;	 
  } 
  return m;
}

function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}





</script>
		
		
    </head>
    <body>	 
	
    <?php
	include 'RefMainMenu.php';
	
	error_reporting(E_ALL);
	?>
    
  
   
  
     
     <!--<div class="column" id="enrtyDiv" style="background-color:#aaa;">
	   <form action="intrestPrvOnDate.php" method="post" id="InstForm" name="instForm">                   
		            Date To:&nbsp; &nbsp; &nbsp; 
                   <input name="Todate" id="Todate" type="date" style="height: 19px;" placeholder="yyyy-mm-dd" required /><br><br>	

				   Interest For: &nbsp; &nbsp; &nbsp;</td><td><select name="refinace"> 
            <?php
			//$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
			//echo "<option value ='All'>All Schemes</option>";
            // while($row1 = mysqli_fetch_row($getRefId))
            //      echo "<option value = '$row1[0]'>$row1[0] </option>";
			?></select>
				   
		           <button type ="submit" onclick="return isValidDate()" name="generateIntrestProv" >Generate Interest Accumilation</button>
		 
                </form>
     </div>-->
	        
	
        

     <div class='col-sm-12'  style='padding-top:0%;border:1px solid green'>
				<center><div style='padding-top:1%;width:50%'>
							<form action="intrestPrvOnDate.php" class="form-horizontal" method="post" id="InstForm" name="instForm">
							<div class="form-group">
								<label class="control-label col-sm-2">Date To:</label> 
								<div class="col-sm-3"> <input type='date' name="Todate" id="Todate" class="form-control" value="<?php echo date("Y-m-d") ?>" required /></div> 
						
								<label class="control-label col-sm-2"> Interest For:</label> 
								<div class="col-sm-3"> <select name="refinace"> 
								<?php
								$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
								echo "<option value ='All'>All Schemes</option>";
								 while($row1 = mysqli_fetch_row($getRefId))
									  echo "<option value = '$row1[0]'>$row1[0] </option>";
								?></select></div> 
							</div>
							
							<div class="form-group">								
							<div class="col-sm-2"> </div> <div class="col-sm-2"> <button type ="submit" onclick="return isValidDate()" name="generateIntrestProv" class='btn btn-info'>Generate Interest Accumilation</button></div> 
		 </div> 
						
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
	//echo "entering1";
        $refinance   = $_POST['refinace']; 
        //$fromDate   = $_POST['Fromdate'];
        $toDate  = $_POST['Todate'];
	    //$date1=$fromDate;
	    $date2=$toDate;
		
	//calculating intrest payment
	
	if($refinance =='All'){
		//echo "entering1";
		$query=("SELECT RefID,Refinance_agency,Scheme,Interest FROM refinance_test group by RefID" );
    $status = mysqli_query($dbconn,$query);
	}else{
		//echo "entering2";
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
		$queryInstDate=("SELECT SUM(intrest_amount),count(*), Date_add(Min(Dailydate),interval -1 day) FROM refinance.refinance_interest_daywise rid WHERE rid.RefID='$refId' and rid.dailydate <= '$toDate' AND rid.outstanding=(SELECT rid1.outstanding FROM refinance.refinance_interest_daywise rid1 WHERE rid1.RefID='$refId' AND rid1.dailydate='$toDate')");
		$statusInstDate = mysqli_query($dbconn,$queryInstDate);
		//echo $queryInstDate;
		$rowk= mysqli_fetch_row($statusInstDate);
		if($rowk[0]!= '' && $rowk[0]!= null){
		$query2 = ("INSERT INTO IntProvTable (RefID,Intrest_Amount,Refinance_agency,Scheme,Interest,IntrestPeriod,last_paid_date) VALUES ('$refId','$rowk[0]','$row6[1]','$row6[2]','$row6[3]','$rowk[1]','$rowk[2]')");
		$status2 = mysqli_query($dbconn,$query2);
		}
		//echo $query2;
		
		//echo "<br>";
		
		
		
		
		
		
		
	}
	}
	
	$query3 = ("SELECT * FROM  intprovtable");
	 
	            $resource3 = mysqli_query($dbconn,$query3);
				$count3 = mysqli_num_rows($resource3);
				
				echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'>Interest provision as on '$toDate'  </font></h4>";
	   if($count3<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource3);
	  
	   echo "<table  border='1' id='provTable' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   //echo "<td><b>Interest provision</b></td>";
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
							 
						$total=$total+$cell;
						  $cell=indian_money_format($cell);  	
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
<div>	            		 
		           <button type ="button" onClick="exportTableToExcel('provTable','intProvision-data')" name="outstanding" >Export</button>              
	       </div>	
</html>   
