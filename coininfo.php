<!DOCTYPE html>  
<html ng-app="plunker">
<head>
<title>StatsStockMarket - Stock Information</title>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="300">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/scrollingText.css">
  <link rel="stylesheet" type="text/css" href="css/graphmod.css">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <link rel="stylesheet" type="text/css" href="css/sort-table.css" title="">
  
  <link rel="stylesheet" type="text/css" href="css/nv.d3.css">
  <link rel="stylesheet" type="text/css" href="css/graphCustom.css">
   <script type="text/javascript" src="js/framework/d3.v3.min.js"></script>
   <script type="text/javascript" src="js/framework/nv.d3.min.js"></script>
	
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
	//sort table if not mobile or tablet view
	if ($(window).width() > 970) {
		document.write('<\/script type="text/javascript" src="js/sort-table.js"><\/script>');
	}
   </script>
</head>

<body >  
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<a href="javascript:" id="return-to-bottom"><i class="fa fa-chevron-down"></i></a>

<?php
ini_set('memory_limit','512M');



// Function which saves the data if you didn't do a request in the past 60 seconds
function cache()
{	
    return json_decode(file_get_contents('./json/stocklist.json'), true);
}

// Function to get the data and use it whenever you need it
function getData ()
{
    return cache();
}


	

$data = getData();
$totalpages = 1;

$message = "";

?>

<div class="sticky">
  <div id="txtitle" style="background-color:#0b1116; padding: 4px;" >
		<a href="market"><img  src="img/banner.png" width="280" height="45"></a>
	 <div id="seachboxy" class="navbar-form navbar-right" style="margin-top: 5px !important;">
            <div class="input-group">
                <input id="getinput" type="text" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button id="" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </div>
  </div>

	<ul class="nav nav-tabs nav-justified" id="myTab" style="border-bottom:0px">
			  <li ><a href="market"  ><span class="glyphicon glyphicon glyphicon glyphicon-stats carty" aria-hidden="true"></span> Market</i></a></li>
			  <li><a href="news"  ><span class="glyphicon glyphicon glyphicon-globe carty" aria-hidden="true"></span> News</a></li>
			  <li><a href="about"  ><span class="glyphicon glyphicon glyphicon glyphicon-question-sign carty" aria-hidden="true"></span> About</a></li>
			</ul>
	

	
</div>
	

	<div id="fillertop">
	</div>
	
<?php

echo "<div class=\"wrapper\">";
$max_10 = 1;

	foreach($data['data'] as $value) {
			if($max_10 < 10){
				$rank = $max_10; 
				$name = $value["quote"]["symbol"]; 
				$usdpricetop = $value["quote"]["latestPrice"]; 
				$percentchangetop = $value["quote"]["changePercent"]; 
				
				$logo = $value["quote"]["symbol"]; 
				$str = strtolower($logo);
					if((float)$percentchangetop > 0){
						$message =  $message . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "<img class=\"ico_img\" src=\"logos/" . $str . ".png\" class=\"logo-sprite\" style=\"width:20px; height:16px;\">" . $rank . "." . $name . " <span class='positive_growth4'>$" . number_format($usdpricetop,2) . "<i class='glyphicon glyphicon-chevron-up' ></i></span> ";
					}
					else{
						$message =  $message . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . "<img class=\"ico_img\" src=\"logos/" . $str . ".png\" class=\"logo-sprite\" style=\"width:20px; height:16px;\">" . $rank . "." . $name . " <span class='negative_growth4'>$" . number_format($usdpricetop,2) . "<i class='glyphicon glyphicon-chevron-down' ></i></span> ";
					}
				
				$max_10 = $max_10 + 1;
			}
			else{
				break;
			}
	}

	echo "<p>" . $message . "</p>";
echo "</div>";

// Function which saves the data if you didn't do a request in the past 60 seconds
function cacheGetStockIntraday()
{
    return json_decode(file_get_contents('./json/intradaystats.json'), true);
}

// Function to get the data and use it whenever you need it
function getGetStockIntraday ()
{
    return cacheGetStockIntraday();
}


$getintradaystats = getGetStockIntraday();
$notionalval = $getintradaystats["data"]["notional"]["value"];
$mkvol = $getintradaystats["data"]["volume"]["value"];
$marketShare = $getintradaystats["data"]["marketShare"]["value"];
$routedvol = $getintradaystats["data"]["routedVolume"]["value"];
$tottradedstocks = $getintradaystats["data"]["symbolsTraded"]["value"];
?>


<div id="cryptinflun">
	<div id="innercrypt">
		<div id="marg">
			<p style="display:inline; color:#b7b7b7;">Stocks: <strong><a class="infcolor"><?php echo number_format($tottradedstocks) ?></a></strong></p>
			<p style="display:inline;  color:#b7b7b7;">/ Routed Volume: <strong><a class="infcolor"><?php echo number_format($routedvol) ?></a></strong></p>
			<p style="display:inline;  color:#b7b7b7;">Notional: <strong><a class="infcolor"><?php echo '' . number_format($notionalval) ?></a></strong></p>
			<p style="display:inline;  color:#b7b7b7;"> / 24h Vol: <strong><a class="infcolor"><?php echo '' . number_format($mkvol) ?></a></strong> / Market Share: <strong><a class="infcolor"><?php echo number_format($marketShare,4) . '%' ?></a></strong></p>
		</div>
	</div>
</div>

<?php

// Search for the stock in the json file and grab its information
function searchcoinbyid($ids)
{
				global $results;
				$num_stock = 0;
				$tempdata = json_decode(file_get_contents('./json/stocklist.json'), true);
				foreach($tempdata['data'] as $value) {
						
						$num_stock = $num_stock + 1;
						
					if ($value["quote"]["symbol"] == $ids){
						$results["rank"] =  $num_stock;
						$results["companyName"] =  $value["quote"]["companyName"];
						$results["symbol"] =  $value["quote"]["symbol"];
						$results["latestPrice"] =  $value["quote"]["latestPrice"];
						$results["latestVolume"] =  $value["quote"]["latestVolume"];
						$results["calculationPrice"] =  $value["quote"]["calculationPrice"];
						$results["change"] =  $value["quote"]["change"];
						$results["changePercent"] =  $value["quote"]["changePercent"];
						$results["volume"] =  $value["quote"]["volume"];
						$results["open"] =  $value["quote"]["open"];
						$results["close"] =  $value["quote"]["close"];
						$results["previousClose"] =  $value["quote"]["previousClose"];
						$results["previousVolume"] =  $value["quote"]["previousVolume"];
						$results["high"] =  $value["quote"]["high"];
						$results["low"] =  $value["quote"]["low"];
						$results["extendedPrice"] =  $value["quote"]["extendedPrice"];
						$results["extendedChange"] =  $value["quote"]["extendedChange"];
						$results["extendedChangePercent"] =  $value["quote"]["extendedChangePercent"];
						$results["delayedPrice"] =  $value["quote"]["delayedPrice"];
						$results["marketCap"] =  $value["quote"]["marketCap"];
						$results["avgTotalVolume"] =  $value["quote"]["avgTotalVolume"];
						$results["week52High"] =  $value["quote"]["week52High"];
						$results["week52Low"] =  $value["quote"]["week52Low"];
						$results["ytdChange"] =  $value["quote"]["ytdChange"];
						$results["primaryExchange"] =  $value["quote"]["primaryExchange"];
						$results["peRatio"] =  $value["quote"]["peRatio"];
					}						
				}
			
}
	
	//grab the sent id
	if(!isset($_GET['id'])){
		$getid = "AA";
	}
	else{
		$getid = $_GET['id'];
	}
	
	//setup variable to hold all information on the stock grabbed from the stocklist.json file
	$results = array();
	searchcoinbyid($getid);

		$name = $results["companyName"]; 
		$symbol = $results["symbol"];
		$logo = $results["symbol"];
		$str = strtolower($logo);
		$ifExists = "logos/" . $str . ".png";
		echo "<div style=\"border-bottom: 1px solid #2d3849;\">";
		echo "<div  style=\"width: 100%; height: 50px;  background: #0e1116; \">";
		echo "<p style=\" font-size: 16px; font-style: italic; text-align: center; color: white; line-height: 50px; vertical-align: middle; \">";
				
		if (@getimagesize($ifExists)) {
			echo "<img class=\"ico_img\" src=\"logos/" . $str . ".png\" class=\"logo-sprite\" style=\"width:20px; height:16px;\">";
		}
		else{	
			echo "<img class=\"ico_img\" src=\"logos/NA.png\" class=\"logo-sprite\" style=\"width:24px; height:20px;\">";
		}
		echo $name . " (" . $symbol . ")";
		echo "</p>";
		echo	"</div>";
		echo "</div>";
		
?>

      
                  <div class="row coininfo">
                      <div class="panel panel-default">
                      <div class="panel-heading">  <h4>Market Information</h4></div>
                       <div class="panel-body">
                      <div class="col-md-2 col-xs-6 col-sm-3 col-lg-2">
					      <div class="text-center">
								<img alt="ranking" src="img/medal2.png" id="profile-image1" class="img-responsive"> 
								 <div class="caption">
									<p class="text_over_image">Rank</p>
									<p class="text_over_image2"><?php echo "#" . $results["rank"]; ?></p>
								</div>
							</div>
                      </div>
                      <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8" >
                          <div class="" >
                            <h2><?php echo $results["companyName"]; ?></h2>
                            <p>symbol:   <b> (<?php echo $results["symbol"];?>)</b></p>
                      
						
                          </div>
                           <hr>
                          <ul class=" details" >
                            <li > <?php echo "Price (USD): <span class=\"blue_text\"> $" . $results["latestPrice"] . "</span>"; ?> </li>
                            <li> <?php echo "Market Cap (USD): <span class=\"blue_text\"> $" . $results["marketCap"] . "</span>"; ?> </li>
                            <li><?php echo "Volume (24hr): <span class=\"blue_text\"> " . $results["latestVolume"] . "</span>"; ?> </li>
                            <li><?php echo "Average Total Volume: <span class=\"blue_text\"> " . $results["avgTotalVolume"] . "</span>"; ?> </li>
                            <li> <?php echo "HIGH: <span class=\"blue_text\"> " . $results["high"] . "</span>"; ?> </li>
                            <li> <?php echo "LOW: <span class=\"blue_text\"> " . $results["low"] . "</span>"; ?> </li>
                            <li> <?php echo "Week 52 HIGH: <span class=\"blue_text\"> " . $results["week52High"] . "</span>"; ?> </li>
                            <li> <?php echo "Week 52 LOW: <span class=\"blue_text\"> " . $results["week52Low"] . "</span>"; ?> </li>
                            <li> <?php echo "Calculation Price: <span class=\"blue_text\"> " . $results["calculationPrice"] . "</span>"; ?> </li>
                            <li> <?php echo "Change: <span class=\"blue_text\"> " . $results["change"] . "</span>"; ?> </li>
                            <li> <?php echo "OPEN: <span class=\"blue_text\"> " . $results["open"] . "</span>"; ?> </li>
                            <li> <?php echo "CLOSE: <span class=\"blue_text\"> " . $results["close"] . "</span>"; ?> </li>
                            <li> <?php echo "Previous CLOSE: <span class=\"blue_text\"> " . $results["previousClose"] . "</span>"; ?> </li>
                            <li> <?php echo "Previous Volume: <span class=\"blue_text\"> " . $results["previousVolume"] . "</span>"; ?> </li>
                            <li > <?php echo "Extended Price (USD): <span class=\"blue_text\"> $" . $results["extendedPrice"] . "</span>"; ?> </li>
                            <li> <?php echo "Extended Change: <span class=\"blue_text\"> " . $results["extendedChange"] . "</span>"; ?> </li>
                            <li > <?php echo "Delayed Price (USD): <span class=\"blue_text\"> $" . $results["delayedPrice"] . "</span>"; ?> </li>
							<li>
							<?php
									echo "Change (1h): ";
									$percentchange = $results["changePercent"]; 
									if((float)$percentchange > 0){
										echo "<span class=\"positive_growth3\">";
											echo "+" . number_format($percentchange,2) . "% ";
													echo "<i class='fa fa-chevron-up'></i>";
										echo "</span>";
									}
									else{
										echo "<span class=\"negative_growth3\">";
											echo number_format($percentchange,2) . "% " . " ";
													echo "<i class='fa fa-chevron-down'></i>";
										echo "</span>";
									}
							?>
							</li>
							<li>
							<?php
									echo "Extended Change Percent: ";
									$percentchangeext = $results["extendedChangePercent"]; 
									if((float)$percentchangeext > 0){
										echo "<span class=\"positive_growth3\">";
											echo "+" . number_format($percentchangeext,2) . "% ";
													echo "<i class='fa fa-chevron-up'></i>";
										echo "</span>";
									}
									else{
										echo "<span class=\"negative_growth3\">";
											echo number_format($percentchangeext,2) . "% " . " ";
													echo "<i class='fa fa-chevron-down'></i>";
										echo "</span>";
									}
							?>
							</li>
							<li>
							<?php
									echo "Change (YTD): ";
									$percentchange24 = $results["ytdChange"]; 
									if((float)$percentchange24 > 0){
										echo "<span class=\"positive_growth3\">";
											echo "+" . number_format($percentchange24,2) . "% ";
													echo "<i class='fa fa-chevron-up'></i>";
										echo "</span>";
									}
									else{
										echo "<span class=\"negative_growth3\">";
											echo number_format($percentchange24,2) . "% " . " ";
													echo "<i class='fa fa-chevron-down'></i>";
										echo "</span>";
									}
							?>
							</li>
							<li>
							<?php
									echo "P/E Ratio: ";
									$percentchange7d = $results["peRatio"]; 
									if((float)$percentchange7d > 0){
										echo "<span class=\"positive_growth3\">";
											echo "+" . number_format($percentchange,2) . " ";
													echo "<i class='fa fa-chevron-up'></i>";
										echo "</span>";
									}
									else{
										echo "<span class=\"negative_growth3\">";
											echo number_format($percentchange7d,2) . " " . " ";
													echo "<i class='fa fa-chevron-down'></i>";
										echo "</span>";
									}
							?>
							</li>
                          </ul>
                          <hr>
                          <div class="col-sm-5 col-xs-6 tital " >Date: <?php echo "<span class=\"blue_text\">" . date("F j, Y") . "</span>"; ?></div>
                      </div>
                </div>
            </div>
            </div>



<?php
//generate graph
$js_array = array();


// generate the historical graph data
function generateGraph()
{
			
			$gethistoricdat;
			global $getid;
			global $results;
			
			$array = array();
			$num = 0;
	
						$gethistoricdat = json_decode(file_get_contents('./historicaldat/' . strtolower($results["symbol"]) . 'histdata.json'), true);	
					
						foreach($gethistoricdat['data'] as $stats) {						
								$array[$num]["price_close"] = $stats["close"];				
								$array[$num]["price_open"] = $stats["open"];				
								$array[$num]["price_high"] = $stats["high"];			
								$array[$num]["price_low"] = $stats["low"];
								$array[$num]["volume24"] = $stats["volume"];
								$array[$num]["timestamp"] = strtotime($stats["date"]);
								$num = $num + 1;
								
								//used to debug and check if all values are correct
								//echo " data " . ($num-1) . " price = " . $array[$num-1]["price"] . " date = " . $array[$num-1]["timestamp"]; 
						}

		return $array;

}




?>

  <div id="gads" style="margin: 10px auto 10px auto; display: flex; justify-content: center; align-items: center; text-align:center; background-color: #161d24; width: 100%; height: 0;">
	
 </div>
 
 
 <div  id="searchtitle2" style="border-bottom: 1px solid #2d3849;">
	<div  style="width: 100%; height: 50px;  background: #0e1116;">
		<p style=" font-size: 16px; font-style: italic; text-align: center; color: white; line-height: 50px; vertical-align: middle; ">OHLC Historical Pricing Data (USD) </p>
	</div>
</div>
 
<div id="chart">
	<svg></svg>
</div>
 
 <div class="graphbutton">
	
	<div class="btngraph" >
		<div class="btn-group">
		  <button type="button" class="gr1 btn btn-primary graphbtn" onclick="dailydat()">1d</button>
		  <button type="button" class="gr2 btn btn-primary graphbtn" onclick="day7dat()">7d</button>
		  <button type="button" class="gr3 btn btn-primary graphbtn" onclick="month1()">1m</button>
		  <button type="button" class="gr4 btn btn-primary graphbtn" onclick="month3()">3m</button>
		  <button type="button" class="gr5 btn btn-primary graphbtn" onclick="month12year()">1y</button>
		  <button type="button" class="gr6 btn btn-primary graphbtn" onclick="alldat()">All</button>
		  
		   <button type="button" class="graphchoice btn btn-primary graphbtn" style="margin-left: 20px;" onclick="changegraphtype()">Volume</button>
		  <button type="button" class="graphchoice2 btn btn-primary graphbtn" onclick="changegraphtype2()">Price</button>
		</div>
	</div>
	
	<div class="btngraph2">
		<div class="btn-group">
		   <button type="button" class="gr1 btn btn-primary graphbtn" onclick="dailydat()">1d</button>
		  <button type="button" class="gr2 btn btn-primary graphbtn" onclick="day7dat()">7d</button>
		  <button type="button" class="gr3 btn btn-primary graphbtn" onclick="month1()">1m</button>
		  <button type="button" class="gr4 btn btn-primary graphbtn" onclick="month3()">3m</button>
		  <button type="button" class="gr5 btn btn-primary graphbtn" onclick="month12year()">1y</button>
		  <button type="button" class="gr6 btn btn-primary graphbtn" onclick="alldat()">All</button>
		</div>
		
		<div class="btn-group">
			<button type="button" class="graphchoice btn btn-primary graphbtn" style="margin-top: 10px;" onclick="changegraphtype()">Volume</button>
			<button type="button" class="graphchoice2 btn btn-primary graphbtn" style="margin-top: 10px;" onclick="changegraphtype2()">MkCap</button>
		 </div>
	</div>
	 
</div>

 <div id="gads2" style="margin: 10px auto 10px auto; text-align:center;  display: flex; justify-content: center; align-items: center; background-color: #161d24; width: 100%; height: 0;">

 </div>

 <div  id="searchtitle2" style="border-bottom: 1px solid #2d3849;">
	<div  style="width: 100%; height: 50px;  background: #0e1116;">
		<p style=" font-size: 16px; font-style: italic; text-align: center; color: white; line-height: 50px; vertical-align: middle; "> <?php echo $name . " (" . $symbol . ")"; ?> Markets </p>
	</div>
</div>

<div id="outtertable" class="table-responsive" >
	<table id="customers" class=" table borderless table-hover table-condensed">
		<thead > 
		  <tr id="myHeader" class="fixorder" style="z-index: 999999;">
			<th id="startclk" class=" pinned lockx" style="cursor: pointer;" >#</th>
			<th  style="cursor: pointer; ">Exchanges</th>
		  </tr>
		</thead>
		
		<tbody > 

 <?php



//show supported exchanges
	echo "<tr>";
		echo "<td>";
			echo $results["rank"];
		echo "</td>";
		echo "<td>";
			echo $results["primaryExchange"];
		echo "</td>";
	echo "</tr>";
						
?>
 </tbody> 
	</table>
</div>

	
   
<script>var jArray = <?php echo json_encode(generateGraph()); ?>;  var coinnamie = "<?php echo $symbol; ?>";</script>
 <script src="js/graphicaldatnw.js" type="text/javascript"></script>
<script src="js/graphscroll.js" type="text/javascript"></script>
<script src="js/searchgforgraphs.js" type="text/javascript"></script>



<hr class="liner">
<div id="navtabbtn">
		<button  id="homebtn" class="navbuttontable" >Back</button>
</div>

<div id="slidebottommenu" class="bottomNav turnback">
<button id="" onclick="bottombarslideup()"  class="slideupmenu" ><span class="glyphicon glyphicon-triangle-top"></span></button>
  <div  style="display: table; margin: 0 auto;">
			<button  id="homebtn2" class="navbuttontable2" ><span class="glyphicon glyphicon-align-left"></span> Home </button>
			<div id="" class="navbar-form navbar-right">
            <div class="input-group">
                <input id="getinput2" type="text" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button id="" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </div>
		</div>
</div>

<footer id="feett" class="nb-footer">
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="about">

	<div class="social-media">
		<ul class="list-inline">
			<li><a href="" title=""><i class="fa fa-facebook"></i></a></li>
			<li><a href="" title=""><i class="fa fa-twitter"></i></a></li>
			<li><a href="" title=""><i class="fa fa-google-plus"></i></a></li>
			<li><a href="" title=""><i class="fa fa-instagram"></i></a></li>
		</ul>
	</div>
</div>
</div>

<div class="col-md-3 col-sm-6">
<div class="footer-info-single">
	<h2 class="title">Navigation</h2>
	<ul class="list-unstyled">
		<li><a href="market" title=""><i class="fa fa-angle-double-right"></i> Market</a></li>
		<li><a href="news" title=""><i class="fa fa-angle-double-right"></i> News</a></li>
		<li><a href="about" title=""><i class="fa fa-angle-double-right"></i> About</a></li>
	</ul>
</div>
</div>

<div class="col-md-3 col-sm-6">
<div class="footer-info-single">
	<h2 class="title">Information</h2>
	<ul class="list-unstyled">
		<li><a href="contact" title=""><i class="fa fa-angle-double-right"></i> Contact</a></li>
		<li><a href="" title=""><i class="fa fa-angle-double-right"></i> App Publisher</a></li>
	</ul>
</div>
</div>

<div class="col-md-3 col-sm-6">
<div class="footer-info-single">
	<h2 class="title">Security & privacy</h2>
	<ul class="list-unstyled">
		<li><a href="privacypolicy" title=""><i class="fa fa-angle-double-right"></i> Privacy Policy</a></li>
	</ul>
</div>
</div>

<div class="col-md-3 col-sm-6">
<div class="footer-info-single">
	<h2 class="title">Downloads &amp; Tools</h2>
	
</div>
</div>
</div>
</div>

<section class="copyright">
<p>Copyright © 2018. StatsStockMarket.</p>
</section>
</footer>

</body>
</html>