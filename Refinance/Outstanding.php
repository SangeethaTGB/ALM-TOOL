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

	<!--<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
	<form action="Outstanding.php" class="form-horizontal" method="post" id="outstandingForm" name="outstandingForm">
                   <div class='form-group'><label class="control-label col-sm-6"> Outstanding On:</label> 
                  <div class="col-sm-6"> <input name="OutstndDate" type="date" style="height: 19px; " placeholder="yyyy-mm-dd" required /><div>
		           </div> 		 
		           <button type ="submit" name="outstanding" >Show Outstanding</button>
		 
		 
		 
                </form>
	</div>
	<div class="col-sm-3"></div>
	</div>-->
	
	
	
	<div class='col-sm-12'  style='padding-top:0%;border:1px solid green'>
				<center><div style='padding-top:1%;width:50%'>
							<form action="Outstanding.php" class="form-horizontal" id="outstandingForm" name="outstandingForm" method="post" style="">
							<div class="form-group">
								<label class="control-label col-sm-3">Outstanding as On:</label> 
								<div class="col-sm-3"> <input type='date' name="OutstndDate" class="form-control" value="<?php echo date("Y-m-d") ?>" required /></div> 
							
															
							<div class="col-sm-3">  <button type="submit" name="outstanding" class="form-control btn btn-primary btn-block btn-danger"  >Show Outstanding</button></div> 
						
							</div>
									
							</form>	
				</div></center>	</div>	
	
	
	
	
	<div class="container" style="width: 100%;border:1px solid black; padding:0px">
		
	<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
	<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

     $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
     mysqli_select_db($dbconn,$db);
	 // if (isset($_POST['outstanding'])){


                $fromDate   = (isset($_POST['outstanding']))? $_POST['OutstndDate'] : date("Y-m-d") ;                
			
	            $query1=("SELECT a.Refinance_agency,a.Scheme,a.Interest,a.RefID,a.Inst_amt+a.outStanding as outStanding FROM inst_table a, (SELECT min( Inst_date ) mindate,`RefID` rid FROM inst_table  WHERE Inst_date >= '$fromDate' GROUP BY RefID) b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid");
				$query11=("INSERT INTO tempforoutstanding(Refinance_agency,Scheme,Interest,RefID,TotalDue)SELECT a.Refinance_agency,a.Scheme,a.Interest,a.RefID,a.Inst_amt+a.outStanding as outStanding FROM inst_table a, (SELECT min( Inst_date ) mindate,`RefID` rid FROM inst_table  WHERE Inst_date >= '$fromDate' GROUP BY RefID) b where a.`Inst_date` = b.mindate and a.`RefID` = b.rid");
				//$query1=("SELECT t1.RefID,t1.Refinance_agency,t1.Scheme, t1.outStanding FROM inst_table t1 INNER JOIN (SELECT max( Inst_date ) Inst_date,RefID FROM inst_table WHERE Inst_date >= '$fromDate' GROUP BY RefID )t2 ON t1.RefID = t2.RefID and t1.Inst_date=t2.Inst_date");
	            //echo "$query1";
	            $resource1 = mysqli_query($dbconn,$query1);
				$resource11 = mysqli_query($dbconn,$query11);
				$count = mysqli_num_rows($resource1);
	   	        //echo $resource1;
				//echo $count;
	   if($count<1)
		   die("No Records Found");
	   
	  echo "<h4 style='TEXT-ALIGN: CENTER; background-color: #b0b7dc; padding: 8px;'><font color='black'> PRINCIPLE OUTSTANDING AS ON '$fromDate' </font></h4>";
	   
	   $fieldCnt=mysqli_num_fields($resource1);
	  
	   echo "<table  border='1' id='OutstandingTable' style='FONT-FAMILY: INITIAL;' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource1);
		   echo "<th style='background-color:lightsalmon;'>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                 
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource1))
                   {
					 
                     echo "<tr>";
					 $colCnt1=0;
					 foreach ($row as $cell)
					 {
                        $colCnt1=$colCnt1+1;
						 if($colCnt1==5){
						 	 $cell=indian_money_format($cell);
							  echo "<td align='right'>$cell</td>"; 
						         }else						 
                      echo "<td>$cell</td>";
					 }
                     echo "</tr>";
                   }
				   				

                 echo "</table>";
				 
	$query12=("SELECT Refinance_agency,SUM(TotalDue) TotalDue FROM tempforoutstanding GROUP BY Refinance_agency");
	$resource12 = mysqli_query($dbconn,$query12);
	  $count12 = mysqli_num_rows($resource12); 
	   if($count12<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource12);
	   
	    echo "<table  border='1' id='TotalOutstandingTable' style='FONT-FAMILY:INITIAL' class='table table-bordered' >";
	 echo "<tr class='warning'>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource12);
		   echo "<th style='background-color:lightsalmon;'>$fieldName->name</th>";  
       } 		   
       echo "</tr>";
                 
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource12))
                   {
					 
                     echo "<tr>";
					 $colCnt1=0;
					 foreach ($row as $cell)
					 {$colCnt1=$colCnt1+1;
						 if($colCnt1==2){
						 	 $cell=indian_money_format($cell);
							  echo "<td align='right'>$cell</td>"; 
						         }else						 	
                      echo "<td>$cell</td>";
					 }
                     echo "</tr>";
                   }
				   				

                 echo "</table>";
	   
	   $query13=("TRUNCATE tempforoutstanding");
	   $resource13 = mysqli_query($dbconn,$query13);
	 // }
	 
	  	

	  
?>
</div>
<div class="col-sm-2"></div>
</div>
           <div>
	   
		          <center><br>	 <button type ="button" onClick="exportTableToExcel('OutstandingTable','members-data')" name="outstanding" >Export</button>    </center>          
	       </div>
	
</body>
</html>

