<?php

/* =============================================== GET ALL STOCK SYMBOLS ================================================ */

//  Function to check if you already did a request within the assigned time period
function checkStateGetStocknews ()
{
    $array2 = json_decode(file_get_contents("../json/stocknews.json"),true);
    if ((time() - $array2['lastCheck']) > 300)
        return true;
    return false;
}

// Get stock news from iEX
function cacheGetStockNews()
{
    if (checkStateGetStocknews()) {
        $array2['lastCheck'] = time();
		//grab all stock symbols from IEx
        $array2['data'] = json_decode(file_get_contents('https://cloud.iexapis.com/stable/stock/market/news/last/50?token=YOUR_API_KEY'), true);
		if ($array2['data'] === null && json_last_error() !== JSON_ERROR_NONE) {
						echo "json cacheGetStockNews cmmk is incorrect";
		}
		else{					
			file_put_contents("../json/stocknews.json", json_encode($array2));
		}
	}
}

// Function to get the data and use it whenever you need it
function getStockNews ()
{
    return cacheGetStockNews();
}


/* =============================================== GET ALL STOCK SYMBOLS ================================================ */


//call functions
getStockNews(); //call function to grab stock news

echo "finished";

?>