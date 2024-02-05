
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
</head>
<body>

<style>
#headerDiv{
	text-align: center;
	height: auto;
	padding: 10px;	
	background-color :#7FFFD4;
	font-size: 15px;
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
#InstForm{
	text-align: center;
	height: auto;
}

#InstDiv{
	text-align: center;
	height: auto;
}

</style>

<script>
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
	
    <?php
	include 'RefMainMenu.php';
	?>

	<!--<div id="InstDiv" style="background-color:#aaa;">
	
	<form action="RefSanction.php" method="post" id="InstForm" name="instForm">
                    Date From:&nbsp; &nbsp; &nbsp; 
                   <input name="Fromdate" type="date" style="height: 19px; " placeholder="yyyy-mm-dd" required /><br><br>
		            Date To:&nbsp; &nbsp; &nbsp; 
                   <input name="Todate" type="date" style="height: 19px;" placeholder="yyyy-mm-dd" required /><br><br>	

				   Search For: &nbsp; &nbsp; &nbsp;</td><td><select name="refinace"> 
            <?php
			//$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
			//echo "<option value ='All'>All Schemes</option>";
            // while($row1 = mysqli_fetch_row($getRefId))
            //      echo "<option value = '$row1[0]'>$row1[0] </option>";
			?></select>
				   
		           <button type ="submit" name="generateRef" >Generate Refinance schedule</button>
		 
                </form>
	</div>-->
	
	
	
	<div class='col-sm-12'  style='padding-top:0%;border:1px solid green'>
				<center><div style='padding-top:1%;width:50%'>
							<form action="RefSanction.php" class="form-horizontal" id="InstForm" name="instForm" method="post" style="">
							<div class="form-group">
								<label class="control-label col-sm-2">Date From:</label> 
								<div class="col-sm-3"> <input type='date' name="Fromdate" class="form-control" required /></div> 
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2">Date To:</label> 
								<div class="col-sm-3"> <input type='date' name="Todate" class="form-control" required /></div> 
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2">Search For:</label> 
								<div class="col-sm-3"> <select name="refinace"> 
								<?php
								$getRefId=mysqli_query($dbconn,"SELECT Refinance_agency FROM refinance_test group by Refinance_agency");
								echo "<option value ='All'>All Schemes</option>";
								 while($row1 = mysqli_fetch_row($getRefId))
									  echo "<option value = '$row1[0]'>$row1[0] </option>";
								?></select></div> 
							</div>
							
							<div class="form-group">								
							<div class="col-sm-2"> </div> <div class="col-sm-2"> <button type ="submit" name="generateRef" class='btn btn-info'>Generate Refinance schedule</button></div> 
						
							</div>
									
							</form>	
				</div></center>	</div>	
	
		
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
	 if (isset($_POST['generateRef'])){

                $refinance   = $_POST['refinace']; 
                $fromDate   = $_POST['Fromdate'];
                $toDate  = $_POST['Todate'];
			    if($refinance=='All'){
				$query = ("SELECT * FROM refinance_test WHERE Refi_date between '$fromDate' and '$toDate'");
				}else
	            $query = ("SELECT * FROM refinance_test WHERE Refi_date between '$fromDate' and '$toDate' and 	Refinance_agency='$refinance' ");
	 
	            $resource2 = mysqli_query($dbconn,$query);
				$count = mysqli_num_rows($resource2);
	   	     //echo "$fromDate";
			// echo " to ";
			// echo "$toDate";
	   if($count<1)
		   die("No Records Found");
	   
	   echo "<font size='6pt'> Refinance Sanctioned from '$fromDate' to '$toDate'</font>";
	   $fieldCnt=mysqli_num_fields($resource2);
	    echo "<table  border='1' id='sanctionTable' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   echo "<td><b>Refinance Sanctioned data</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource2);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                  $total1=0;
				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource2))
                   {
					 
                     echo "<tr>";
					 $colCnt1=0;
					 foreach ($row as $cell)
					 {
						 	$colCnt1=$colCnt1+1; 	
                          if($colCnt1==6) {  
						$total1=$total1+$cell;  }				 
						  echo "<td align='right'>$cell</td>";
					 }
                     echo "</tr>";
                   }
				   echo "<td></td>";
				   echo "<td></td>";
                 echo "<td></td>";
                 echo "<td></td>";				 
                echo "<td><b>Total Amount</b></td>";
				echo "<td align='right'>$total1</td>";

                 echo "</table>";
				 
				 
				 
		//Total Installments
	if($refinance=='All'){
	$query3=("SELECT Refinance_agency,SUM(Amount) Total FROM refinance_test where Refi_date BETWEEN '$fromDate' AND '$toDate' GROUP BY Refinance_agency ");
	$resource3 = mysqli_query($dbconn,$query3);
	  $count3 = mysqli_num_rows($resource3); 
	   if($count3<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource3);
	  
	    echo "<table  border='1' id='TotalOutstandingTable' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   echo "<td><b>Total Refinance</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource3);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                 
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource3))
                   {
					 
                     echo "<tr>";
					 $colCnt1=0;
					 foreach ($row as $cell)
					 {						 	
                      echo "<td align='right'>$cell</td>";
					 }
                     echo "</tr>";
                   }
				   				

                 echo "</table>";
	}
	
	   
	 }
	 
	  	

	  
?>
</div>
<div class='col-sm-2'></div>
</div>

<div>	            		 
		           <button type ="button" onClick="exportTableToExcel('sanctionTable','sanctioned-data')" name="outstanding" >Export</button>              
	       </div>
	
</body>
</html>

