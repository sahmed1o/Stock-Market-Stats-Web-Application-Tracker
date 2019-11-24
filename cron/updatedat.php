<?php

/* ============= STOCK STATS TRACKED ============================ */

//  Function to check if you already did a request within the assigned time period
function checkState ()
{
    $array = json_decode(file_get_contents("../json/stocklist.json"),true);
    if ((time() - $array['lastCheck']) > 240){ //prevent users from running the script
       	return true;
	}
	else{
		echo '<script language="javascript">';
		echo 'alert("Restricted Access")';
		echo '</script>';
		return false;
	}
}

// Function that generates the json files holding the stock information
function cache()
{
		//grab the first 100 stock symbols from the json filed generated from getallstocksymbols
		$allstocksymbols =	json_decode(file_get_contents('../json/allstocksymbols.json'), true)['data'];
		//echo json_encode($allstocksymbols[0]["symbol"], JSON_PRETTY_PRINT); //grab individual symbol
		$allstocksymbols_string = "";
		for($i = 1; $i < 100; $i++){
			$allstocksymbols_string = $allstocksymbols_string . json_encode($allstocksymbols[$i]["symbol"], JSON_PRETTY_PRINT);
			$allstocksymbols_string = $allstocksymbols_string . ",";			
		}
		
		$allstocksymbols_string = str_replace("\"","",$allstocksymbols_string);
		
		
    if (checkState()) {
		
        $array['lastCheck'] = time();
        $array['data'] = json_decode(file_get_contents('https://cloud.iexapis.com/stable/stock/market/batch?symbols=' . $allstocksymbols_string . '&types=quote&token=YOUR_API_KEY'), true);
		//check if we are able to get the data from iEx, if not then show error
		if ($array['data'] === null && json_last_error() !== JSON_ERROR_NONE) {
			echo "json data cache1 cmmk is incorrect";
		}
		else{
			//dont include this in for loop, we can issue 1 less request with this segment
			file_put_contents("../json/stocklist.json", json_encode($array));
		}
		
	}
	else{
		echo "failed to retrieve data";
	}
	
}

// Function to get the stock data and use it whenever you need it
function getData ()
{
    return cache();
}

/* ============= END OF STOCK STATS TRACKED ============================ */


/* ============= INTRADAY STATS ============================ */

// Function to check if you already did a request within the assigned time period
function checkStateGetStockIntraday ()
{
    $array2 = json_decode(file_get_contents("../json/intradaystats.json"),true);
    if ((time() - $array2['lastCheck']) > 300)
        return true;
    return false;
}

// Get investor exchange intraday stats from iExtrading
function cacheGetStockIntraday()
{
    if (checkStateGetStockIntraday()) {
        $array2['lastCheck'] = time();
        $array2['data'] = json_decode(file_get_contents('https://cloud.iexapis.com/stable/stats/intraday?token=YOUR_API_KEY'), true);
		if ($array2['data'] === null && json_last_error() !== JSON_ERROR_NONE) {
						echo "json cacheGetStockIntraday cmmk is incorrect";
		}
		else{					
			file_put_contents("../json/intradaystats.json", json_encode($array2));
		}
	}
}

// Function to get the data and use it whenever you need it
function getStockIntraday ()
{
    return cacheGetStockIntraday();
}


/* =============  END OF INTRADAY STATS ============================ */

//update stock information by calling the functions
//getStockIntraday(); //create intraday json data
getData();

echo "finished";

?>