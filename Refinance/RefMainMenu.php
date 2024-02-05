<html>

<body>


 <?php



	include 'utility.php';
	?>

<style type="text/css">
	
	
</style>

<link rel="stylesheet" href="css/css2.css">
	<link rel="stylesheet" href="css/font.css">
	<link rel="stylesheet" href="css/boot.css">
	<link rel="stylesheet" href="css/table.css">
	<script src="js/jquery_latest.js"></script>
	<script src="js/boot.js"></script>
	<script src="js/datatable.js"></script>




<div class="container" style="width: 100%;border:2px solid grey; padding:5px;background-color:#66a078;">
			
	<div style="display: flex;justify-content: space-between;margin-top: 4px;padding: 0 5px;">
			<img src="TGB_LOGO.png" align="left" style="height: 50px;border-radius: 50px;margin: 2px 2px 0 10px;"/>
			<h3  style="margin-top:10px;margin-bottom: 10px; "><b><font style="color:BLACK;FONT-FAMILY: initial">REFINANCE DASHBOARD</font> </b>
				<?php
					
				?>		
			</h3> 
			<h4><b align="right" style="color:BLACK;FONT-FAMILY: initial;padding: 3px 7px 0 0;"></b> 
			</h4>
		</div>
	
	
	</div>

	
	
	
	
	<!--<div id="mydiv">
	<table>	<tr>
	<td><button type="button" onclick="location.href = 'EntryForm-Edited.php';">New entry</button></td>
	<td><button type="button" onclick="location.href = 'displayAll.php?Delstatus=0';">Display all Refinance Schemes</button></td>	
	<td><button type="button" onclick="location.href = 'Outstanding.php';">Complete Outstanding Summary</button> </td>
	<td><button type="button" onclick="location.href = 'RefSanction.php';">Refinance Sanctioned Summary</button> </td>
	<td><button type="button" onclick="location.href = 'intrestPrvOnDate.php';">Interest Provision till given date</button> </td>
	<td><button type="button" onclick="location.href = 'interestProvision.php';">Interest Provision between dates</button> </td>	
	<td><button type="button" onclick="location.href = 'GenerateInstallments.php';">Check Installment Dates</button> </td>
	<td><button type="button" onclick="location.href = 'UpdateIntrst.php';">Interest Payment History </button> </td>
	<td><button type="button" onclick="location.href = 'ShowClosedRecords.php';">Closed Records</button> </td>
	</tr></table>   
    </div> -->
	
	<div class="container" style="width: 100%;border:2px solid grey; padding:0px;background-color:white;">
	<nav class="navbar navbar-default" style="margin-bottom:0px">
		<div class="navbar-header">
		<a class="navbar-brand" href="displayAll.php?Delstatus=0" style='background-color: #337ab7;color:black'>REFINANCES LIST</a>
		</div>
			<ul class="nav navbar-nav">	
					
			<li><a href="EntryForm-Edited.php" style='background-color: #a6babb;color:black'>INSERT NEW</a></li>
			<li><a href="Outstanding.php" style='background-color: #d2d0b6;color:black' >OUTSTANDINGS</a></li>
			<li><a href="RefSanction.php" style='background-color: #a6babb;color:black'>SANCTIONS</a></li>
			<li><a href="intrestPrvOnDate.php" style='background-color: #d2d0b6;color:black'>INTEREST PROVISION TILL DATE</a></li>			
			<li><a href="interestProvision.php" style='background-color: #a6babb;color:black'>INTEREST PROV BETWEEN DATES</a></li>
			<li><a href="GenerateInstallments.php" style='background-color: #d2d0b6;color:black'>INSTALLMENTS</a></li>
			<li><a href="UpdateIntrst.php" style='background-color: #a6babb;color:black'>PAYMENT HISTORY</a></li>			
			<li><a href="ShowClosedRecords.php" style='background-color: #d2d0b6;color:black'>CLOSED RECORDS</a></li>
			
			</ul>
	</nav>
	</div>
	
	
	</body>
	</html>