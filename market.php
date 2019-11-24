<!DOCTYPE html>  
<html>
<head>
<title>StatsStockMarket - Stocks Market Data</title>
<meta name="description" content="Multi-Platform site that provides stocks market caps & prices through live charts & rankings.">
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="300">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/scrollingText.css">
  <link rel="stylesheet" type="text/css" href="css/tablemod.css">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <link rel="stylesheet" type="text/css" href="css/portfolio.css">
  <link rel="stylesheet" type="text/css" href="css/sort-table.css" title="">
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
<body>  

<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<a href="javascript:" id="return-to-bottom"><i class="fa fa-chevron-down"></i></a>


<?php



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
			  <li  class="active"><a href="market"  ><span class="glyphicon glyphicon glyphicon glyphicon-stats carty" aria-hidden="true"></span> Market</i></a></li>
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


<div id="indicatory" class="blink_me" style="width: 100%; position: fixed; margin-top: 100px; pointer-events:none;">
	<img id="tabpic" style="float:right; clear:right;" src="img/arrows.png" width="20" height="130">
</div>



<div id="imgtop">
	<img id="navpic" src="img/topimgbtext.png" width="1880" height="600">
</div>



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


 <div id="gads2" style="margin: 0 auto; text-align:center; background-color: #0e1116; width: 100%; height: 0;">

	<!-- Main Banner AD 1 -->
	
 </div>
	
<div id="tabletitle" style="border-bottom: 1px solid #2d3849; border-top: 1px solid #2d3849;">
	<div id="tabletitlexvg" style="width: 100%; height: 100px;  background: #0e1116; ">
		<p style=" font-size: 24px; font-style: italic; text-align: center; color: white; line-height: 100px; vertical-align: middle; ">Stocks Market Capitalizations</p>
	</div>
</div>

 <div id="gads" style="float:none;margin:0px 0 0px 0;text-align:center;  background-color: #0e1116;  width: 100%; height: 0;">
	
	<!-- Main Banner AD 1 -->
	
 </div>


 
<div id="outtertable" class="table-responsive gdgadg">
<table id="customers3" class="js-sort-table table borderless table-hover table-condensed">
		<thead > 
		  <tr id="myHeader" class="tablecellttun" style="z-index: 99;   display: none;">
			<th class="js-sort-number pinned lockx" style="cursor: pointer;" >#</th>
			<th class="js-sort-string headercellClass pinned lockx2" style="cursor: pointer;">Name</th>
			
		  </tr>
		  </thead>
		  <tbody>
		  </tbody>
</table>
</div>

<div id="outtertable" class="table-responsive gdgadg">
<table id="customers3" class="js-sort-table table borderless table-hover table-condensed adfadfa">
		<thead > 
		  <tr id="myHeader" class="fixorder" style="z-index: 999999;   display: none;">
			<th   onclick="sortrank()" class=" pinned lockx" style="cursor: pointer;" >#</th>
			<th   onclick="sortname()" class=" headercellClass pinned lockx2" style="cursor: pointer;">Name</th>
			<th   onclick="sortprice()" class="js-sort-number" style="cursor: pointer; ">USD</th>
			<th   onclick="sortchange()" class="js-sort-number" style="cursor: pointer; ">%</th>
			<th   style="cursor: pointer; "><span class="glyphicon glyphicon glyphicon-level-up" style='font-size:16px;' aria-hidden="true"></span></th>
			<th   onclick="sortvol()" class="js-sort-number" style="cursor: pointer; ">Volume</th>
			<th   onclick="sortmkcap()" class="js-sort-number" style="cursor: pointer; ">Market Cap USD</th>
			<th   onclick="sortavsuppl()" class="js-sort-number" style="cursor: pointer; ">HIGH</th>
			<th   onclick="sorttotsup()" class="js-sort-number" style="cursor: pointer; ">LOW</th>
			<th   onclick="sortchangehr()" class="js-sort-number" style="cursor: pointer; ">Change (1h)</th>
			<th   onclick="sortchangehrtwent()" class="js-sort-number" style="cursor: pointer; ">Change (YTD)</th>
			<th   onclick="sortchangeday()" class="js-sort-number" style="cursor: pointer; ">P/E Ratio</th>
			
		  </tr>
		  </thead>
		  <tbody>
		  </tbody>
</table>
</div>


<div id="outtertable" class="table-responsive thistablu">
	<table id="customers" class="js-sort-table table tabulart borderless table-hover table-condensed">
		<thead > 
		  	<!-- Fixes X width for table header -->
		 <tr  id="myHeader2" class="afas" style="z-index: 999; ">
			<th  id="startclk"  class="js-sort-number  pinned lockx" style="cursor: pointer;" >#</th>
			<th  id="startclkname" class="js-sort-string headercellClass pinned lockx2" style="cursor: pointer;">Name</th>
			<th  id="startclkprice" class="js-sort-number" style="cursor: pointer; ">USD</th>
			<th  id="startclkchange" class="js-sort-number" style="cursor: pointer; ">%</th>
			<th  class="js-sort-number" style="cursor: pointer; "><span class="glyphicon glyphicon glyphicon-level-up" style='font-size:16px;' aria-hidden="true"></span></th>
			<th  id="startclkvol" class="js-sort-number" style="cursor: pointer; ">Volume</th>
			<th  id="startclkmkcap" class="js-sort-number" style="cursor: pointer; ">Market Cap USD</th>
			<th  id="startclkavsupply" class="js-sort-number" style="cursor: pointer; ">HIGH</th>
			<th  id="startclktotsupply" class="js-sort-number" style="cursor: pointer; ">LOW</th>
			<th  id="startclkchangehr" class="js-sort-number" style="cursor: pointer; ">Change (1h)</th>
			<th  id="startclkchangehrtwent" class="js-sort-number" style="cursor: pointer; ">Change (YTD)</th>
			<th  id="startclkchangeday" class="js-sort-number" style="cursor: pointer; ">P/E Ratio</th>
			
		  </tr>
		</thead>
		
		<tbody > 
	
		<?php
		
		
				
				
		$num = 0;
		
		foreach ($data['data'] as $value) {
			
			echo "<tr>";
			$num = $num+1;
			$rank = $num; 
			echo "<td class=\"pinned\">";
			echo $rank;
			echo "</td>";
			
			$name = $value["quote"]["companyName"]; 
			$symbol = $value["quote"]["symbol"]; 
			$logo = $value["quote"]["symbol"];
			$str = strtolower($logo);
			$ifExists = "logos/" . $str . ".png";
			echo "<td class=\"cellClass pinned\">";
			if (@getimagesize($ifExists)) {
				echo "<img class=\"ico_img\" src=\"logos/" . $str . ".png\" class=\"logo-sprite\" style=\"width:20px; height:16px;\">";
			}
			else{	
				echo "<img class=\"ico_img\" src=\"logos/NA.png\" class=\"logo-sprite\" style=\"width:24px; height:20px;\">";
			}
			
			echo "<a href=\"coininfo?id=" .  $value["quote"]["symbol"] . "\">";
			echo $name . " (" . $symbol . ")";
			echo "</a>";
			echo "</td>";


			$price_usd = $value["quote"]["latestPrice"]; 
			echo "<td>";
			echo "$" . number_format($price_usd,4);
			echo "</td>";
			
			$percentchange2 = $value["quote"]["changePercent"]; 
			if((float)$percentchange2 > 0){
				echo "<td class=\"positive_growth3\">";
					echo "+" . number_format($percentchange2,5) . "% ";
							echo "<i class='fa fa-chevron-up'></i>";
			}
			else{
				echo "<td class=\"negative_growth3\">";
					echo number_format($percentchange2,5) . "% " . " ";
							echo "<i class='fa fa-chevron-down'></i>";
			}
			echo "</td>";

			echo "<td onclick=\"openprompt('" . $name . "','" . $price_usd . "','" . $rank . "','" . $symbol . "')\">";
			echo "<i class='fa fa-plus-circle' style='font-size:20px; cursor: pointer;'></i>";
			echo "</td>";

			$voltwent = $value["quote"]["previousVolume"]; 
			echo "<td class=\"yellow_text\">";
			echo number_format($voltwent);
			echo "</td>";

			$marketcap = $value["quote"]["marketCap"]; 
			echo "<td class=\"yellow_text\">";
			echo "$" . number_format($marketcap);
			echo "</td>";

			$availsupply = $value["quote"]["high"];
			echo "<td class=\"yellow_text\">";
			echo number_format($availsupply);
			echo "</td>";

			$totsupply = $value["quote"]["low"]; 
			echo "<td class=\"yellow_text\">";
			echo number_format($totsupply);
			echo "</td>";

			$percentchange = $value["quote"]["changePercent"]; 
			if((float)$percentchange > 0){
				echo "<td class=\"positive_growth\">";
					echo "+" . number_format($percentchange,5) . "%";
			}
			else{
				echo "<td class=\"negative_growth\">";
					echo number_format($percentchange,5) . "%";
			}
			echo "</td>";

			$percentchange24 = $value["quote"]["ytdChange"]; 
			if((float)$percentchange24 > 0){
				echo "<td class=\"positive_growth\">";
					echo "+" . number_format($percentchange24,5) . "%";
			}
			else{
				echo "<td class=\"negative_growth\">";
					echo number_format($percentchange24,5) . "%";
			}
			echo "</td>";
			
			$percentchange7 = $value["quote"]["peRatio"]; 
			if((float)$percentchange7 > 0){
				echo "<td class=\"positive_growth\">";
					echo "+" . number_format($percentchange7,2);
			}
			else{
				echo "<td class=\"negative_growth\">";
					echo number_format($percentchange7,2);
			}
			echo "</td>";

			
				echo "</tr>";
		} 

		?>
		</tbody> 
	</table>
		<div id="navtabbtn" style="margin-top: 20px !important;">
			<button id="backbtn" class="navbuttontable" >Back 100</button>
			<button id="nextbtn" class="navbuttontable" >Next 100</button>
		</div>

</div>




<script> var totalpaget = <?php echo $totalpages; ?>; var ok = <?php echo intval(isset($_GET['page'])); ?>; </script>
<script src="js/main.js" type="text/javascript"></script>
<script src="js/popupport.js" type="text/javascript"></script>

<div id="slidebottommenu" class="bottomNav turnback">
<button id="" onclick="bottombarslideup()"  class="slideupmenu" ><span class="glyphicon glyphicon-triangle-top"></span></button>
  <div  style="display: table; margin: 0 auto;">
			<button id="backbtn2" class="navbuttontable2" ><span class="glyphicon glyphicon-align-left"></span> Back 100</button>
			<button id="nextbtn2" class="navbuttontable2" >Next 100 <span class="glyphicon glyphicon-align-right"></span></button>
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