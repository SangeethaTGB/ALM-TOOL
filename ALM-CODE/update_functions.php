<!DOCTYPE html >
<html lang="en">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>

<body>
<?php
function update_out_1($cap,$asondate)
{
$capital=$cap;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_OVER_5Y='$capital', RM_TOTAL='$capital' where OrderNo=1 and op_mode='Outflows' and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);
}

function update_out_2($rands,$asondate)
{
$reserves_surplus=$rands;
$sql2="update investments.alm_appendix1_maturity_profile_liquidity set RM_OVER_5Y='$reserves_surplus', RM_TOTAL='$reserves_surplus' where OrderNo=2 and op_mode='Outflows' and asondate='$asondate' ";
$res2=mysqli_query($conn,$sql2);
}

		function update_out_3.1($L01A,$asondate)
		{
		$L01A_1=$L01A*0.15;
		$L01A_2=$L01A*0.85;
		$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$L01A_1',RM_1Y_to_3Y='$L01A_2', RM_TOTAL='$L01A' where DisplayOrder=4 and asondate='$asondate' ";
		$res1=mysqli_query($conn,$sql1);
		}
		
		function update_out_3.2($L01D,$asondate)
		{
		$L01D_1=$L01D*0.10;
		$L01D_2=$L01D*0.90;
		$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$L01D_1',RM_1Y_to_3Y='$L01D_2', RM_TOTAL='$L01D' where DisplayOrder=5 and asondate='$asondate' ";
		$res1=mysqli_query($conn,$sql1);
		}
		
		function update_out_3.3($a,$b,$c,$d,$e,$f,$g,$h,$i,$asondate)
		{
		$sql1="update investments.alm_appendix1_maturity_profile_liquidity 
				set RM_1D_to_14D=if('$a'>0,'$a',RM_1D_to_14D), 
					RM_15D_to_28D=if('$b'>0,'$b',RM_15D_to_28D), 
					RM_29D_to_3M=if('$c'>0,'$c',RM_29D_to_3M),
					RM_3M_to_6M=if('$d'>0,'$d',RM_3M_to_6M), 
					RM_6M_to_1Y=if('$e'>0,'$e',RM_6M_to_1Y), 
					RM_1Y_to_3Y=if('$f'>0,'$f',RM_1Y_to_3Y), 
					RM_3Y_to_5Y=if('$g'>0,'$g',RM_3Y_to_5Y),
					RM_OVER_5Y=if('$h'>0,'$h',RM_OVER_5Y), 
					RM_TOTAL=if('$i'>0,'$i',RM_TOTAL)
				where DisplayOrder=6 and asondate='$asondate'"; 
		$res1=mysqli_query($conn,$sql1);
		}
		
		function update_out_3.4($L01A,$asondate)
		{
		$sql1="update investments.alm_appendix1_maturity_profile_liquidity 
				set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where DisplayOrder=7 and asondate='$asondate'"; 
		$res1=mysqli_query($conn,$sql1);
		}

function update_out_3($asondate)
{
$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (4,5,6,7) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=3 ";
$res1=mysqli_query($conn,$sql1);
}

		function update_out_4.1($,$asondate)
		{
		}
		
		function update_out_4.2($,$asondate)
		{
		}
		
		function update_out_4.3($,$asondate)
		{
		}
		
		function update_out_4.4($,$asondate)
		{
		}
		
function update_out_4($,$asondate)
{
}

		function update_out_5.1($,$asondate)
		{
		}
		
		function update_out_5.2($,$asondate)
		{
		}
		
		function update_out_5.3($,$asondate)
		{
		}
		
		function update_out_5.4($,$asondate)
		{
		}

function update_out_5($,$asondate)
{
}

		function update_out_6.1($,$asondate)
		{
		}
		
		function update_out_6.2($,$asondate)
		{
		}

function update_out_6($,$asondate)
{
}

function update_out_7($,$asondate)
{
}

function update_out_8($,$asondate)
{
}
function update_out_9($,$asondate)
{
}
function update_out_10($,$asondate)
{
}
function update_out_11($,$asondate)
{
}
function update_out_12($,$asondate)
{
}


$sql1="select sum(balance) from investments.dailyweekly_monthend where LEVEL2='FIXED ASSETS' and date_sub(run_date,'interval 1 day')='$asondate' ";
$res1=mysqli_query($conn,$sql1);
$tot_with_RBI=$excess_CRR+$ca_with_RBI;
$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$excess_CRR',RM_15D_to_28D='$ca_with_RBI', RM_TOTAL='$tot_with_RBI' where DisplayOrder=29 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);


$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (4,5,6,7) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=3 ";
$res1=mysqli_query($conn,$sql1);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24.25.26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity set RM_1D_to_14D='$rm_1d_14d',RM_15D_to_28D='$rm_15d_28d',RM_29D_to_3M='$rm_29d_3m',	RM_3M_to_6M='$rm_3m_6m',RM_6M_to_1Y='$rm_6m_1y',	
							RM_1Y_to_3Y='$rm_1y_3y',	RM_3Y_to_5Y='$rm_3y_5y',	RM_OVER_5Y='$rm_abv_5y',	RM_TOTAL='$rm_total' where DisplayOrder=6 and asondate='$asondate' ";
$res1=mysqli_query($conn,$sql1);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (4,5,6,7) 
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=3 ";
$res1=mysqli_query($conn,$sql1);

$sql1="update investments.alm_appendix1_maturity_profile_liquidity,  
		(
		select sum(RM_1D_to_14D) a, sum(RM_15D_to_28D) b, sum(RM_29D_to_3M) c, sum(RM_3M_to_6M) d, sum(RM_6M_to_1Y) e, sum(RM_1Y_to_3Y) f, sum(RM_3Y_to_5Y) g, sum(RM_OVER_5Y) h, sum(RM_TOTAL) i  
		from investments.alm_appendix1_maturity_profile_liquidity 
		where asondate='$asondate' and DisplayOrder in (1,2,3,8,13,18,21,22,23,24.25.26)
		) t1 
		set RM_1D_to_14D=a, RM_15D_to_28D=b, RM_29D_to_3M=c,RM_3M_to_6M=d, RM_6M_to_1Y=e, RM_1Y_to_3Y=f, RM_3Y_to_5Y=g,RM_OVER_5Y=h, RM_TOTAL=i where asondate='$asondate' and DisplayOrder=27 ";
$res1=mysqli_query($conn,$sql1);




?>
</body>

</html>
