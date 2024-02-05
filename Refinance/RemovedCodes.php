SELECT Inst_date,outStanding,Inst_amt FROM inst_table WHERE Inst_date=(SELECT max(Inst_date)FROM inst_table WHERE Inst_date <= '2016-12-02' and RefID='139') and RefID='139'


//Removed codes


//Installment Update	   
	   
	   $query3 = ("SELECT * FROM  installmentpayhistory where RefID='$RefID'");
	 
	            $resource3 = mysqli_query($dbconn,$query3);
				$count3 = mysqli_num_rows($resource3);
	   if($count3<1)
		   die("No Installment History Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource3);
	   echo "<table border='1'><tr>";
	   echo "<td><b>Installment Payment History </b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource3);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";

				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource3))
                   {
					 
                     echo "<tr>";
					 $colCnt=0;
					 foreach ($row as $cell)
					 {
						 					 
						  echo "<td>$cell</td>";
					 }
                     echo "</tr>";
					 echo "<tr>";
					 echo "<td></td>";
					 
					 echo "</tr>";
                   }
				   echo "<tr>";
				   echo "<td>
					 <form action='DeleteInstallmentEntry.php' method='post'>
					 <input type='text' name='RefID' value='$RefID' style='display:none'/>
					 <input type='submit' value='Delete last entry'/>
					 </form></td>";
				   echo "</tr>";

                 echo "</table>";
				 
				 
				 
				 
//Intrest Update	   
	   
	   $query4 = ("SELECT * FROM  intrestpayhistory where RefID='$RefID'");
	 
	            $resource4 = mysqli_query($dbconn,$query4);
				$count4 = mysqli_num_rows($resource4);
	   if($count4<1)
		   die("No Intrest History Found");
	   
	   
	   $fieldCnt=mysqli_num_fields($resource4);
	   echo "<table border='1'><tr>";
	   echo "<td><b>Interest Payment History</b></td>";
					 echo "</tr>";
					 echo "<tr>";
	   for($i=0;$i<$fieldCnt;$i++)
	   {
		   $fieldName=mysqli_fetch_field($resource4);
		   echo "<th>$fieldName->name</th>";  
       } 		   
       echo "</tr>";

				  $totalCount=0;
				  $TotalPayment="Total_payment";
                  while($row    = mysqli_fetch_row($resource4))
                   {
					 
                     echo "<tr>";
					 $colCnt=0;
					 foreach ($row as $cell)
					 {
						 					 
						  echo "<td>$cell</td>";
					 }
                     echo "</tr>";
                   }
                 echo "<tr>";
				   echo "<td>
					 <form action='DeleteIntrestEntry.php' method='post'>
					 <input type='text' name='RefID' value='$RefID' style='display:none'/>
					 <input type='submit' value='Delete last entry'/>
					 </form></td>";
				   echo "</tr>";
				   
                 echo "</table>";