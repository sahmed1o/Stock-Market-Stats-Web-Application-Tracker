<!DOCTYPE html>  
<html>
<head>
<title>StatsStockMarket - About Us</title>
<meta name="description" content="Our website is dedicated to providing live stocks market data. For more information see our about page.">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/scrollingText.css">
  <link rel="stylesheet" type="text/css" href="css/graphmod.css">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <link rel="stylesheet" type="text/css" href="css/sort-table.css" title="">
  <link rel="stylesheet" type="text/css" href="css/nv.d3.css">
  <link rel="stylesheet" type="text/css" href="css/newsc.css">
    <!-- lightbox-->
    <link rel="stylesheet" href="css/lightbox.min.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
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
			  <li  ><a href="market"  ><span class="glyphicon glyphicon glyphicon glyphicon-stats carty" aria-hidden="true"></span> Market</i></a></li>
			  <li><a href="news"  ><span class="glyphicon glyphicon glyphicon-globe carty" aria-hidden="true"></span> News</a></li>
			  <li class="active"><a href="about"  ><span class="glyphicon glyphicon glyphicon glyphicon-question-sign carty" aria-hidden="true"></span> About</a></li>
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


<div class="jumbotron main-jumbotron" >
      <div class="container">
        <div class="content">
          <h1>About</h1>
          <p class="margin-bottom">Multi-Platform site providing stats for stocks on both desktop &amp; mobile browsers. View market data, prices, charts, rankings, and more.</a></p>
          <p><a class="btn btn-white" href="market">Market</a></p>
        </div>
      </div>
    </div>
    <section>
      <div id="txtcolor" class="container">
        <h2>Why StatsStockMarket?</h2>
        <p class="lead">Our website is dedicated to providing live stocks market data. We provide users with the latest news in the stocks world along with the latest stocks prices, market capitalizations, historical pricing, supported stock exchanges, &amp; more.</p>
       <p class="lead">StatsStockMarket.com allows users to create their own stocks portfolio without creating an account. The data is stored via local storage and can be accessed only by the user. Users may view our Stock website on both mobile and desktop browsers.</p> 
		<p>For any questions / comments / bug reports, please contact us via our contact us page, or send us a message using the stated email.</p>
        <p><a href="contact" class="btn btn-ghost">Contact</a></p>
      </div>
    </section>
    <section style="background: #222222 !important; border-top: 2px solid #ddd !important;">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="post" >
              <div class="image"><a href=""><img src="img/blog1.jpg" alt="" class="img-responsive"></a></div>
              <h3 ><a href="" style="color: #f1cb05 !important;">StatsStockMarket</a></h3>
              <p class="post__intro" style="color: white !important;">View other apps by our publisher here, including StatsStockMarket's app</p>
              <p class="read-more"><a href="" class="btn btn-ghost">Read More</a></p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="post">
              <div class="image"><a href="privacypolicy"><img src="img/privacypoli.jpg" alt="" class="img-responsive"></a></div>
              <h3><a href="privacypolicy" style="color: #f1cb05 !important;">Privacy Policy</a></h3>
              <p class="post__intro" style="color: white !important;">View what information we collect &amp; more via our privacy policy page</p>
              <p class="read-more"><a href="privacypolicy" class="btn btn-ghost">Read More</a></p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="post">
              <div class="image"><a href="contact"><img src="img/contactus.jpg" alt="" class="img-responsive"></a></div>
              <h3><a href="contact" style="color: #f1cb05 !important;">Contact US</a></h3>
              <p class="post__intro" style="color: white !important;">Get a hold of us via contact page for any questions/comments/bug reports</p>
              <p class="read-more"><a href="contact" class="btn btn-ghost">Contact</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>


	<script> var totalpaget = 0;  var ok = <?php echo intval(isset($_GET['page'])); ?>;</script>
 <script src="js/newsjs.js" type="text/javascript"></script>

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