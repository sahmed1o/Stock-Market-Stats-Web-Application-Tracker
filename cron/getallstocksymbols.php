<?php

/* =============================================== GET ALL STOCK SYMBOLS ================================================ */

//  Function to check if you already did a request within the assigned time period
function checkStateGetStockSymbolsy ()
{
    $array2 = json_decode(file_get_contents("../json/allstocksymbols.json"),true);
    if ((time() - $array2['lastCheck']) > 300)
        return true;
    return false;
}

// Get investor exchange intraday stats from iExtrading
function cacheGetStockSymbols()
{
    if (checkStateGetStockSymbolsy()) {
        $array2['lastCheck'] = time();
		//grab all stock symbols from IEx
        $array2['data'] = json_decode(file_get_contents('https://cloud.iexapis.com/stable/ref-data/symbols?token=YOUR_API_KEY'), true);
		if ($array2['data'] === null && json_last_error() !== JSON_ERROR_NONE) {
						echo "json cacheGetStockSymbols cmmk is incorrect";
		}
		else{					
			file_put_contents("../json/allstocksymbols.json", json_encode($array2));
		}
	}
}

// Function to get the data and use it whenever you need it
function getStockSymbols ()
{
    return cacheGetStockSymbols();
}


/* =============================================== GET ALL STOCK SYMBOLS ================================================ */


/* =============================================== GET ALL STOCK LOGOS ================================================ */
function getStockLogos(){
	$data = json_decode(file_get_contents('../json/stocklist.json'), true);
	foreach($data['data'] as $value) {
		$array['data'] = json_decode(file_get_contents('https://cloud.iexapis.com/stable/stock/' . strtolower($value["quote"]["symbol"]) . '/logo?token=YOUR_API_KEY'), true);
		$url_to_logo = $array['data']['url'];
		file_put_contents("../logos/" . $value["quote"]["symbol"] . ".png", file_get_contents($url_to_logo));
	}
}

/* =============================================== GET ALL STOCK LOGOS ================================================ */

//call functions
getStockSymbols(); //create intraday json data
getStockLogos(); //create intraday json data


echo "finished";

?>