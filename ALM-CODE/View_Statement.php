<!DOCTYPE HTML>
<html lang="en">

<head>
<?php
$fnameTitle=basename($_SERVER['SCRIPT_NAME'],".php");
echo "<title> $fnameTitle | ALM </title>";
?>
</head>


<body>

<?php
include 'index.php';


$asondate1 = date("Y-m-d",strtotime("-1 day"));
$asondate = isset($_POST['asondate']) ? $_POST['asondate'] : $asondate1;
?>

<h2>Appendix-I - Statement of Structural Liquidity</h2>
<form class="form-inline text-center" action="" method="post">
	<label class="form-control control-label">Position as on</label>
	<input name="asondate" class='form-control' type="date" value="<?php echo $asondate; ?>" max="<?php echo $asondate1; ?>" />
	<input name="showAsondate" class='form-control btn btn-info' type="submit" value="Show Statement" />
</form>



<?php
// if (isset($_POST['showAsondate']))
//  $asondate=$_POST['asondate'];
 include 'alm_show.php';

?>



<br><br>
</body>

</html>
