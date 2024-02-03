<!DOCTYPE HTML>
<html lang="en">
<head><title> CA-Settlement A/Cs | ALM </title></head>

<body>

<?php
	
		include 'index.php';
?>

<h2>Settlement Accounts (CA)</h2>
<?php    

	 	$query = "select * from investments.alm_ca_settlement order by entry_id desc";

		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);

		$test = $test . "<table border=1>";
		$test = $test . "<tr><th><b>S.No.</b></th>";
		$test = $test . "<th><b>Segment_Name</b></th>";
		$test = $test . "<th><b>CA_AccNo</b></th>";
		$test = $test . "<th><b>DailyLimit</b></th>";
		$test = $test . "<th><b>BGL_AccNo</b></th>";
		$test = $test . "<th><b>AccType</b></th>";

		?>

<?php
//include 'bond_feed.php';
?>
		<div style="display:flex;flex-direction: column-reverse;">
			<div>
			<table class='table table-hover table-bordered' id="my_filter_table" >
			<thead>
			<tr>				
				<th style="text-align: center;"><b>Sl.</b></th>
				<th style="text-align: center;"><b>Segment_Name  </b></th> 
				<th style="text-align: center; "><b>CA_AccNo  </b></th> 
				<th style="text-align: center;"><b>DailyLimit  </b></th> 
				<th style="text-align: center;"><b>BGL_AccNo  </b></th> 
				<th style="text-align: center;"><b>AccType  </b></th> 
				
			</tr>
			</thead>
			<tbody>
<?php if ($editId) { ?>
			<tr style="height: 35px; background-color:  #DDFFFF; vertical-align:middle">
				<form class="form-inline" method="post" action="">
					<td style="text-align: right;">Add New</td> 
					<td style="text-align: left;"><textarea class="form-control" name="Segment_Name" required="required" style="height: 37px; width:100%; padding-bottom:0"></textarea> </td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="CA_AccNo" required="required" style="height: 30px" /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="DailyLimit" required="required" style="height: 30px" /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="BGL_AccNo" required="required" style="height: 30px" /></td> 
					<td style="text-align: left;"><input type="text"  class="form-control" name="AccType" required="required" style="height: 30px;" /></td> 
					<td style="text-align: left;"><input class="btn btn-primary" name="addAcc" type="submit" value="Add A/C" /></td> 
				</form>
				</tr>
<?php } ?>
		<?php
		
		if ($count > 0)
		{
			$rowcnt=0;
			while($row_acc=mysqli_fetch_assoc($result)){
			$rowcnt=$rowcnt+1;
		?>

<script>
function enableEdit(i,j)
{
//alert(i);
for(i1=1;i1<=j;i1++)
 {
 var edit="edit_" + i1;
 var tr="tr_" + i1;
 document.getElementById(edit).style.display="none";
document.getElementById(tr).style.backgroundColor="transparent";
 }

var edit="edit_" + i;
var tr="tr_" + i;
document.getElementById(edit).style.display="Block";
document.getElementById(tr).style.backgroundColor=" #DDFFFF";
}
</script>
<?php if ($editId) { ?>
				<tr id="tr_<?php echo $rowcnt; ?>"  ondblclick="enableEdit('<?php echo $rowcnt; ?>','<?php echo $count; ?>')"  title="Double Click for EDIT"   >
				<form id="frm_<?php echo $rowcnt; ?>" method="post" action="" readonly="readonly">
					<td style="text-align: left;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><textarea class="form-control" name="Segment_Name" required="required" style="height: 37px; width:100%; padding-bottom:0;border:none; background: none"><?php echo $row_acc['Segment_Name']; ?></textarea> </td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="CA_AccNo" required="required" style="height: 30px;border:none; background: none" value="<?php echo $row_acc['CA_AccNo']; ?>" /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="DailyLimit" required="required" style="height: 30px;border:none; background: none" value="<?php echo $row_acc['DailyLimit']; ?>" /></td> 
					<td style="text-align: left;"><input type="number" step="0.01" class="form-control" name="BGL_AccNo" required="required" style="height: 30px;border:none; background: none" value="<?php echo $row_acc['BGL_AccNo']; ?>" /></td> 
					<td style="text-align: left;"><input type="text"  class="form-control" name="AccType" required="required" style="height: 30px;border:none; background: none" value="<?php echo $row_acc['AccType']; ?>" /></td> 
					<td id="edit_<?php echo $rowcnt; ?>" style="text-align: left; display: none">
					<div style="display: flex">
						<input class="form-control btn btn-primary" name="updateAcc" type="submit" value="Update" style="width: 100%; vertical-align:middle" /> 
						<button class="form-control btn btn-primary" name="deleteAcc"  style="width: 100%; vertical-align:middle" onclick="confirmDelete('<?php echo $rowcnt; ?>');" >Delete</button>
						<input id="deleteAccSttId_<?php echo $rowcnt; ?>" class="form-control" name="deleteAccStt" type="hidden"  /> 
						<input class="form-control" name="Entry_ID" type="hidden" value="<?php echo $row_acc['Entry_ID']; ?>"  />
					</div>
					</td> 
				</form>
				</tr>
				<?php 
				}
				else
				{
				?>
				<tr>
					<td style="text-align: left;"><?php echo $rowcnt; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['Segment_Name']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['CA_AccNo']; ?> </td> 
					<td style="text-align: left;"><?php echo $row_acc['DailyLimit']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['BGL_AccNo']; ?></td> 
					<td style="text-align: left;"><?php echo $row_acc['AccType']; ?></td> 
				</tr>
				<?php
				}
			   ?>
		<?php 

			}
			echo"</tbody></table>";
			}
		else{
			echo "<CENTER><h1>No records to display</h1>";
			}
	?>
		</div>
		<!-- <div style="display: flex;height: 30px;justify-content: space-around;align-items: center;height: auto;">
			<form method='post' action='export.php'><p><label for='data'></label>
			<input type='text' id='data' name='data' value="<?php echo $test ?>" style='display: none' />
			<input type='text' id='data1' name='data1' value="<?php echo $file ?>" style='display: none' />
			<input type='submit' value='&#x2193; Save to Excel' style="font-size: 15px;" /></form>
		</div> -->
	</div>

<script>
function confirmDelete(i)
{
var txt;
var x=confirm("Are You Sure! You want to DELETE Sl.No. - " + i + "?");
if (x)
 {
 var frm="frm_" + i;
 var deleteBondSttId="deleteAccSttId_" + i;
 document.getElementById('deleteAccSttId_'+i).value=x;
 windows.document.forms[frm].submit();
 }
}
</script>

	<?php 
		if($_POST["deleteAccStt"]=="true")
		{	  
			$Entry_ID = $_POST['Entry_ID'];
			$sql_del="delete from investments.alm_ca_settlement where Entry_ID=$Entry_ID";
			//echo "<script>alert('$sql_del');</script>";
			$res_del=mysqli_query($conn,$sql_del);
			if($res_del) header("location:CA_DISPLAY.php");
		
		}


				


		if(isset($_POST["updateAcc"]))
		{	  
			$Segment_Name= $_POST['Segment_Name'];
			$CA_AccNo= $_POST['CA_AccNo'];
			$DailyLimit= $_POST['DailyLimit'];
			$BGL_AccNo= $_POST['BGL_AccNo'];
			$AccType= $_POST['AccType'];
			$Entry_ID = $_POST['Entry_ID'];
			$sql3 = "update investments.alm_ca_settlement set 
													Updated_By='$pid',
													Segment_Name=NULLIF('$Segment_Name',''),
													CA_AccNo=NULLIF('$CA_AccNo',''),
													DailyLimit=NULLIF('$DailyLimit',''),
													BGL_AccNo=NULLIF('$BGL_AccNo',''),
													AccType=NULLIF('$AccType','') 
					where Entry_ID=$Entry_ID";
					
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);

			if ($result3)
			{
				header("location:CA_DISPLAY.php");
			}
			else
			{
				echo "<br>Data Incorrect. Try again."; 
			}
		}

		if(isset($_POST["addAcc"]))
		{	  
			$Segment_Name= $_POST['Segment_Name'];
			$CA_AccNo= $_POST['CA_AccNo'];
			$DailyLimit= $_POST['DailyLimit'];
			$BGL_AccNo= $_POST['BGL_AccNo'];
			$AccType= $_POST['AccType'];
			$Entry_ID = $_POST['Entry_ID'];

			$sql3 = "INSERT INTO investments.alm_ca_settlement( 
													Entry_Date,
													Updated_By,
													Updated_On,
													Segment_Name,
													CA_AccNo,
													DailyLimit,
													BGL_AccNo,
													AccType 
													) 
					values (
							CURRENT_DATE(),
							'$pid',
							now(),
							NULLIF('$Segment_Name',''), 
							NULLIF('$CA_AccNo',''), 
							NULLIF('$DailyLimit',''), 
							NULLIF('$BGL_AccNo',''), 
							NULLIF('$AccType','')  
						 )";
			echo $sql3;
			$result3 = mysqli_query($conn,$sql3);

			if ($result3)
			{
				header("location:CA_DISPLAY.php");
			}
			else
			{
				echo "<br>Data Incorrect. Try again."; 
			}
		}
	?>


</body>
</html>