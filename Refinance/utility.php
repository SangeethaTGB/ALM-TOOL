<?php 

		function indian_money_format($amt){			
			if( is_null($amt)) return "0.00";
			$check = explode(".",$amt);
			$dec = isset($check [1])?substr($check[1],0,2):"00";
			$decimal_100_place = strpos($amt,".")-3;
			
			if($decimal_100_place > 0){
			$last = substr($amt, $decimal_100_place  ,3);
			$first_phase = substr($amt, 0   ,$decimal_100_place);
			$first_phase = strlen($first_phase) ? $first_phase.",":"";
			}else{
					$last = $check[0];
					$first_phase = "";
				
			}
			
			$final_num =   preg_replace("/\B(?=(\d{2})+(?!\d))/" ,",",$first_phase) .$last.".".$dec ;
			return $final_num;
			
		}


?>


<style type="text/css">
	


@media print{
	input {
		background: white !important;
		border:0 !important;
		padding: 0.2em;
	}
	center {
		zoom:60%;
	}

.no_print{
	display: none;
}

}

</style>