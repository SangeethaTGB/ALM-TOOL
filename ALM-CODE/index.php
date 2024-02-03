
<!DOCTYPE HTML>
<html lang="en">
<head>
<!-- <title> Head Office | Toogle </title> -->
<style>
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: olive;
  display: flex;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.9s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #DEDEBE;color: olive;

}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #D7EBFF;color: olive;
  border-bottom:none;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
  background-color: #D7EBFF;
}
.tabcontent a{
	text-decoration:none;
	font-size:20px;
}
.tabcontent li{
	font-size:20px;
}
.tabcontent > div: hover{
background-color:orange;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button{
	-webkit-appearance: none;
	margin:0;
}

textarea:: -webkit-scrollbar{
	display: none;
}

input[type=number]{
	-moz-appearance: textfield;
}


.table table-hover table-bordered tr:nth-child(odd){
	background-color: #f2f2f2;
}
</style>

</head>
<body>

<?php
extract($_POST);
extract($_GET);

  // include $_SERVER['DOCUMENT_ROOT'] . '\mis\FooterNew.php';
$Flpath=$_SERVER['SCRIPT_NAME'];
//echo $Flpath;
if ($Flpath=="/mis/Departments/HeadOffice/alm/" || $Flpath=="/mis/Departments/HeadOffice/alm/index.php")
 header("location:Trend.php");

include 'alm_functions.php';

$heading=""; 
include 'CommonCssJs\index.php';
//include $_SERVER['DOCUMENT_ROOT'] . '\mis\DBConnect.php';

// include $_SERVER['DOCUMENT_ROOT'] . '\mis\FooterNew.php';

?>

</body>
</html>


