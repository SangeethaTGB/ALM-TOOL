<?php


$sql1="select * from balancesheet_2022_23_may.cgl_ar1_mapping";
$res1=mysqli_query($conn112,$sql1);
$row_ar1 = mysqli_fetch_all($res1,MYSQLI_ASSOC);
$row_ar1_values="";
foreach ($row_ar1 as $key) {
       $row_ar1_values = $row_ar1_values . "('". $key['cgl'] . "','". $key['level1_classification'] . "','". $key['ar1_mapping'] . "','". $key['ar1_sub_mapping'] . "'), ";    
}
$row_ar1_values=substr($row_ar1_values, 0,-2);
// var_dump($row_ar1_values);
$sql1="truncate investments.cgl_ar1_mapping";
$res1=mysqli_query($conn111,$sql1);
$sql1="insert into investments.cgl_ar1_mapping values $row_ar1_values";
// echo $sql1;
$res1=mysqli_query($conn111,$sql1);




$sql1="select * from balancesheet_2022_23_may.cgl_ar2_mapping";
$res1=mysqli_query($conn112,$sql1);
$row_ar2 = mysqli_fetch_all($res1,MYSQLI_ASSOC);
$row_ar2_values="";
foreach ($row_ar2 as $key) {
       $row_ar2_values = $row_ar2_values . "('". $key['cgl'] . "','". $key['level1_classification'] . "','". $key['ar2_mapping'] . "','". $key['ar2_sub_mapping'] . "'), ";    
}
$row_ar2_values=substr($row_ar2_values, 0,-2);
// var_dump($row_ar2_values);
$sql1="truncate investments.cgl_ar2_mapping";
$res1=mysqli_query($conn111,$sql1);
$sql1="insert into investments.cgl_ar2_mapping values $row_ar2_values";
// echo $sql1;
$res1=mysqli_query($conn111,$sql1);



$curmonth = date("Ym",strtotime($asondate));
$sql1="SELECT gl_acct, (cgl_add+cgl_ded) manual_bal FROM balancesheet_2022_23_jun.`cgl_add_ded` WHERE cgl_add !=0 OR cgl_ded !=0  AND curmonth>='$curmonth'";
$res1=mysqli_query($conn112,$sql1);
$row_ar2 = mysqli_fetch_all($res1,MYSQLI_ASSOC);
$row_ar2_values="";
foreach ($row_ar2 as $key) {
       $row_ar2_values = $row_ar2_values . "('". $key['gl_acct'] . "','". $key['manual_bal'] . "','". $curmonth . "'), ";    
}
$row_ar2_values=substr($row_ar2_values, 0,-2);
$sql1="truncate investments.cgl_add_ded";
$res1=mysqli_query($conn111,$sql1);
$sql1="insert into investments.cgl_add_ded values $row_ar2_values";
// echo $sql1;
$res1=mysqli_query($conn111,$sql1);
?>