
<!DOCTYPE html>
 

<html>
    <head>
        <meta charset="UTF-8">
        <title>sample</title>
		
		
	
<script>
	
function validateForm() {
    var x = document.forms["entry"]["refinace"].value;
    if (x == "") {
        alert("please fill Refinance agenecy name");
        return false;
    }
	
	var y = document.forms["entry"]["type"].value;
    if (y == "") {
        alert("please fill type of refinance");
        return false;
    }
	var z = document.forms["entry"]["date"].value;
    if (z == "") {
        alert("please fill date of sanction");
        return false;
    }
	var regEx = /^\d{4}-\d{2}-\d{2}$/;
  if(z.match(regEx) == null){	
	 alert("Please enter the correct date format for refinance date"); 
      return false;	 
  }
  var z1 = new Date(z);
  if(Number.isNaN(z1.getTime())) {
	  alert("Please enter the correct refinance date"); 
	   return false; // Invalid date
  }
	 
  
	
	var d = document.forms["entry"]["intstdate"].value;
    if (d == "") {
        alert("please fill first Intrest payment date");
        return false;
    }
	 if(d.match(regEx) == null){	
	 alert("Please enter the correct date format for Intrest payment date"); 
      return false;	 
  }
  var d1 = new Date(d);
  if(Number.isNaN(d1.getTime())) {
	  alert("Please enter the correct Intrest payment date"); 
	   return false; // Invalid date
  }
  
	if(d<z){
		alert("Intrest payment date shouldn't be less than Refinance date");
        return false;
	}
	
	var a = document.forms["entry"]["interest"].value;
    if (a == "") {
        alert("please fill interest rate");
        return false;
    }
	
	var b = document.forms["entry"]["amount"].value;
    if (b == "") {
        alert("please fill amount sanctioned");
        return false;
    }
	
	var e = document.forms["entry"]["finstallment"].value;
    if (e == "") {
        alert("please fill first Installment payment date");
        return false;
    }
	if(e.match(regEx) == null){	
	 alert("Please enter the correct date format for Installment date"); 
      return false;	 
  }
  var e1 = new Date(e);
  if(Number.isNaN(e1.getTime())) {
	  alert("Please enter the correct Installment date"); 
	   return false; // Invalid date
  }
	if(e<z){
		alert("Installment payment date shouldn't be less than Refinance date");
        return false;
	}
	
	var c = document.forms["entry"]["numInst"].value;
    if (c == "") {
        alert("please fill No of installments");
        return false;
    }
}


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
    
  
   
  
     
     <!--<div class="column" id="enrtyDiv">
	   <form action="" method="post" id="NewForm" name="entry">
	      
           <div id="entryForm">  
		   
           
			 
			 <div  class='form-group' style=" display: flex;justify-content: center;">
			 <div   style="background-color:#aaa; 	" >
	  <h2>New Entry </h2><br>
			 
             <table ><tr><td>
             Refinance From: </td><td>
             <input name="refinace"  type="text"  style="height: 19px;" size="30"> <br><br>
              </td></tr>
			  <tr><td>
             Type:</td><td>
             <input name="type"  type="text"  style="height: 19px;" size="30"><br><br>
             </td></tr>
			 <tr><td>
             Refinance Date: </td><td>
             <input name="date" type="date" style="height: 19px; "size="30" placeholder="yyyy-mm-dd" /><br><br>
			  </td></tr>
			  
			  <tr><td>
             Interest Rate:</td><td>
              <input name="interest"  type="text"  style="height: 19px;" size="30" ><br><br>            
			  </td></tr>
			    
			  <tr><td>
             Released/Sanctioned Amount:</td><td>
             <input name="amount" id="amt" type="text" style="height: 19px;" size="30" maxlength="30" ><br><br>
			 </td></tr>
               <tr><td>			   
             First Principal Installment Start From:</td><td>
             <input id="finstallment" name="finstallment" type="date" style="height: 19px;" size="30" maxlength="30" placeholder="yyyy-mm-dd" ><br><br>
               </td></tr>
			   <tr><td>
             Repayment Periodicity:</td><td>
             <select name="p_cycle" style="" style="height: 19px;" id="timeGap">
                 <option  value="1">Monthly</option>
                 <option  value="3">Quarterly</option>
                 <option  value="6">Half-yearly</option>
                 <option  value="12">Yearly</option>
              </select><br><br>
			 </td></tr>
               <tr><td>
             No of installment:</td><td>
             <input id="numInst" name="numInst" type="text" style="height: 19px;" size="30" maxlength="30" ><br><br>
              </td></tr><tr><input type='text' id="valUse" name='valUse' value='0' style='display:none'/></tr>
              </table>
			  
			  </div>
			  </div>
			  
             <button type ="submit" onclick="return validateForm()" name="generateDates" >Generate Dates</button>
			 
			  
           </div>
 
                

 
        </form>
     </div>-->
	           				
    </body>
	<br>
<div class="row" >
<div class="col-sm-3"></div>

<div class="col-sm-6" style="background-color: #dcdcdc">
<form action="" class="form-horizontal" method="post" style="border:2px solid BLACK; padding:10px;font-family:initial">

<div class='form-group'>
<label class="control-label col-sm-6"> Refinance From:</label><div class="col-sm-6"><input type='text' name='refinace' class='form-control'></input></div>
</div>
							
<div class='form-group'>
<label class="control-label col-sm-6"> Type:</label><div class="col-sm-6"><input  name="type"  type="text" class='form-control'></input></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6"> Refinance Date:</label><div class="col-sm-6"><input type='date' name="date"  class='form-control'></input></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6"> Interest Rate:</label><div class="col-sm-6"><input type='text' name="interest" class='form-control'></input></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6">  Released/Sanctioned Amount:</label><div class="col-sm-6"><input name="amount" id="amt" type="text"  class='form-control'></input></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6">   First Principal Installment Start From:</label><div class="col-sm-6"><input id="finstallment" name="finstallment" type="date"  class='form-control'></input></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6">   Repayment Periodicity:</label><div class="col-sm-6"><select name="p_cycle" style="" style="height: 19px;" id="timeGap">
                 <option  value="1">Monthly</option>
                 <option  value="3">Quarterly</option>
                 <option  value="6">Half-yearly</option>
                 <option  value="12">Yearly</option>
              </select></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6">   No of installment:</label><div class="col-sm-6"><input id="numInst" name="numInst" type="text"   class='form-control'></input></div>
</div>

<div class='form-group'>
<label class="control-label col-sm-6"></label><div class="col-sm-6"><button class='btn btn-warning' type ="submit" onclick="return validateForm()" name="generateDates" >Generate Dates</button></div>
</div>



</form>
</div>
<div class="col-sm-3"></div>

</div>
	
	
<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'refinance';

$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass);
mysqli_select_db($dbconn,$db);

$Insta_count=0;
$stat9=false;



if (isset($_POST['updateDates']))
{	 
		$numInst=$_POST['installments'];		
	$inst_cnt=1;
    while($inst_cnt<=$numInst){
		$datevar=$_POST["date_".$inst_cnt];		
		$instvar=$_POST["inst_".$inst_cnt];			
		$instUpdate=("update refinance.temp_generate_dates set inst_amt='$instvar',inst_date='$datevar' where INST_NUM=$inst_cnt");	   
		$status21 = mysqli_query($dbconn,$instUpdate);
	 $inst_cnt=$inst_cnt+1;
	 }
	$query3 = ("SELECT MAX(RefID) FROM refinance.refinance_test");
			$status3=mysqli_query($dbconn,$query3);
			$row3=mysqli_FETCH_ROW($status3);
     $sql1 = "call refinance.GENERATE_DATES($row3[0],2);";
			$result1 = mysqli_query($dbconn,$sql1);

    }
	
	

	
if (isset($_POST['generateDates']))
{	

$refinance   = $_POST['refinace'];
    $type  = $_POST['type'];
	$date   = $_POST['date'];
    $interest  = $_POST['interest'];
	$amount   = $_POST['amount'];
    $finstallment  = $_POST['finstallment'];
	$p_cycle  = $_POST['p_cycle'];
	$numInst  = $_POST['numInst'];
	//$intstdate  = $_POST['intstdate'];
	//$I_cycle  = $_POST['I_cycle'];
	

	if($numInst>0){
	$query = ("INSERT INTO refinance.refinance_test (Refinance_agency, Scheme, Refi_date, Interest, Amount, First_installment, Payment_cycle, No_installments ) VALUES ('$refinance', '$type', '$date','$interest', '$amount','$finstallment', '$p_cycle', '$numInst' )");
	$status1=mysqli_query($dbconn,$query);
		if ($status1)
		{
			$query2 = ("SELECT MAX(RefID) FROM refinance.refinance_test");
			$status2=mysqli_query($dbconn,$query2);
			$row=mysqli_FETCH_ROW($status2);
			$sql1 = "call refinance.GENERATE_DATES($row[0],1);";
			$result1 = mysqli_query($dbconn,$sql1);
		}
	}
	
	?>
	
	 <div class="column" id="UpdateForm" style="background-color:#aaa;">
	   <form action="" method="post" id="UpdateForm" name="entry">
	      
            

	 
	 
	<?php
		$sqlQuery=("select inst_date, inst_amt from refinance.temp_generate_dates where RefID=$row[0]");
		$status21 = mysqli_query($dbconn,$sqlQuery);
		$count2 = mysqli_num_rows($status21);
		if($status21<1)
		   die("No Records Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($status21);
	   
	   echo "<table align='center' border='1'><tr>";
	   echo "<th>Installment_NO</th>";
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
					
					 echo "<td align='center' ><input type='text' value='$row_count' name='instNo' readonly /></td> ";
					 foreach ($row as $cell)
					 { 
						
						if($colCnt==0)				 
							echo "<td align='center' ><input type='date' value='$cell' name='date_$row_count' /></td> ";
						elseif($colCnt==1)				 
							echo "<td align='center' ><input type='text' value='$cell' name='inst_$row_count'/></td> ";
					
							$colCnt=$colCnt+1;
					}
                     echo "</tr>";
					 
					 
					 	 $row_count=$row_count+1;
                   }

                 echo "</table>";
		echo "<input type='hidden' value='$count2' name='installments' />";
	}		
		?>
 
<div style="text-align:center;padding-top:5px;">
		<button type ="submit" id="submit" name="updateDates"  value="send to database" > Save </button>	 
		

</div>	 
       
		</form>
	 </div>
</html>   
