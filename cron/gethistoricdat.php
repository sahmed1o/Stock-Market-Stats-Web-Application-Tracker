<?php

function historicalcache()
{
	//--------------------- used to get historical data on all stocks -------------------
	$gethistoricdat;
	$results = array();
		$tempdata = json_decode(file_get_contents('../json/stocklist.json'), true);
			foreach($tempdata['data'] as $value) {	

						$checkLink = @file_get_contents('https://cloud.iexapis.com/stable/stock/'. strtolower($value["quote"]["symbol"]) . '/chart/5y?token=YOUR_API_KEY');
						if ( $checkLink !== false ){
								$gethistoricdat['data'] = json_decode($checkLink, true);	
								$results = $gethistoricdat;
								file_put_contents("../historicaldat/" . strtolower($value["quote"]["symbol"]) . "histdata.json", json_encode($results));
						}
							
						$results = array(); 
						sleep(5);
							
			}		
}
			

// Function to get the data and use it whenever you need it
function getData ()
{
    return historicalcache();
}
	

getData();

echo "finished";

?>