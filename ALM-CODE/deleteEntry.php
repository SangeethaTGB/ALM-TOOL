<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}ser
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Delete</title>
</head>
<body>


<?php
include $_SERVER['DOCUMENT_ROOT'] . '\mis\Dep.php';

$msgid=$_GET['msgid'];


$q1="delete from mis.tgbforum where MsgId=$msgid";
$q1="UPDATE mis.tgbforum SET MSG_STATUS=0 where MsgId=$msgid";
$query=mysqli_query($conn,$q1);

echo "<script>window.opener.window.location.reload(1);window.close();</script>";
?>


</body>
</html>

     
     