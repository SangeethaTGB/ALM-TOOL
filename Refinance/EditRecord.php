
<!DOCTYPE html>
 

<html>
    <head>
        <meta charset="UTF-8">
        <title>sample</title>
		
	<style>


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

#updateDiv {
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
#UpdateForm{
	text-align: center;
	height: auto;
}
#InstDiv{
	text-align: center;
	height: auto;
}


	 
</style>	
	
<script>
function val(){

    var uname = document.getElementById('valUse').value;
    if(uname==0){
        alert("please generate dates");
        return false;
    }
    else{
        return true;
    }
}

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
	           				
    </body>
	
	
	
<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'REFINANCE';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);

$Insta_count=0;
$stat9=false;
	
 ?>  
   
	      
     
	<?php
	
	if (isset($_POST['EditRecord']))
{	
     echo "<form action='EditRecord.php' method='post'>";
	
	  $refinanceId   = $_POST['RefID_edit'];
	  //$tempselect=("select Installment_NO,inst_date, inst_amt from refinance.inst_table where RefID=$refinanceId order by inst_date");
	  //$tempselectstatus = mysqli_query($dbconn,$tempselect);
	  //$tempselectcount = mysqli_num_rows($tempselectstatus);
		//echo $tempselect;
	   $delTemp=("delete from refinance.TEMP_FLAG3_DATES");
	   $statusdel = mysqli_query($dbconn,$delTemp);
		//echo $delTemp;
					
		//$instTemp=("insert into refinance.TEMP_FLAG3_DATES select REFID,INST_DATE,INST_AMT,OUTSTANDING,INSTALLMENT_NO from refinance.inst_table where RefID='$refinanceId' ");
		//echo $instTemp;
		//$status21 = mysqli_query($dbconn,$instTemp);		
	
	
	
		$sqlQuery=("select Installment_NO,inst_date, inst_amt from refinance.inst_table where RefID=$refinanceId order by Installment_NO");
		//echo $sqlQuery;
		$status21 = mysqli_query($dbconn,$sqlQuery);
		$count2 = mysqli_num_rows($status21);
		//echo $count2;
		if($count2<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($status21);
	   
	   echo "<table align='center' border='1'><tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   
		   $fieldName=mysqli_fetch_field($status21);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr><br>";

				  $totalCount=0;
				  $TotalPayment="Total_payment";
				   $row_count=1;
                  while($row    = mysqli_fetch_row($status21))
                   {
                     echo "<tr>";
					 $colCnt=0;
					
					
					 foreach ($row as $cell)
					 { 
						if($colCnt==0)				 
						 echo "<td align='center' ><input type='text' value='$cell' name='instNo_$row_count' readonly /></td> ";
						if($colCnt==1)				 
							echo "<td align='center' ><input type='date' value='$cell' name='date_$row_count' /></td> ";
						elseif($colCnt==2)				 
							echo "<td align='center' ><input type='text' value='$cell' name='inst_$row_count'/></td> ";
					
							$colCnt=$colCnt+1;
					}
                     echo "</tr>";
					 
					 
					 	 $row_count=$row_count+1;
                   }

                 echo "</table>";
		echo "<input type='hidden' value='$count2' name='installments' />";

	
		echo "<input type ='input' name='RefId'  value='$refinanceId' style='display:none'></input>";
		echo "<button type ='submit' id='submit' name='updateDates' align='center'> Save </button>";	


		echo "</form>";
       
}
?>
 
	 
<?php	
if (isset($_POST['updateDates']))
{	 
		$numInst=$_POST['installments'];
        $RefId=$_POST['RefId'];	
		$inst_count=1;
	
		$datevar=$_POST["date_".$inst_count];
 // while($inst_count<=$numInst){		
		 // for ($i=1; $i<=$numInst; $i++)	{
		 // echo $_POST["date_".$i];
		  // echo "-";
         // echo $_POST["date_".$inst_count];
		// echo "<br>";
			// if(strtotime($_POST["date_".$i])> strtotime($_POST["date_".$inst_count] )){
				// echo (strtotime($_POST["date_".$i])- strtotime($_POST["date_".$inst_count] ));
				// die ("installment date should be increasing in order Please check");
			// } 
		 // }
 // $inst_count=$inst_count+1;		 
 // }
	
//echo $numInst;
//echo $RefId;		
	$inst_cnt=1;
    while($inst_cnt<=$numInst){
		$INST_NUM=$_POST["instNo_".$inst_cnt];
		$datevar=$_POST["date_".$inst_cnt];		
		$instvar=$_POST["inst_".$inst_cnt];			
		$instUpdate=("insert into refinance.TEMP_FLAG3_DATES (RefID,INST_AMT,INST_DATE,INST_NUM) values ('$RefId','$instvar','$datevar','$INST_NUM')");
		//echo $instUpdate;
		$status21 = mysqli_query($dbconn,$instUpdate);		
	
	 $inst_cnt=$inst_cnt+1;
	 }
	//$instUpdate=("DELETE FROM refinance.refinance_interest_daywise where RefID='$RefID'");
	//$query3 = ("SELECT MAX(RefID) FROM refinance.refinance_test");
		//	$status3=mysqli_query($dbconn,$query3);
		//	$row3=mysqli_FETCH_ROW($status3);
     $sql1 = "call refinance.GENERATE_DATES($RefId,3);";
			$result1 = mysqli_query($dbconn,$sql1);

    }
	
	?>
</html>   
