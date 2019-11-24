var showPrice_close = [];
var showPrice_open = [];
var vol = []; //volume in usd
var volcoin = []; //volume in crypto
var i;




var yMax = 0;





//All data
for(i = 0; i < (jArray.length-1); i++){
	showPrice_close.push([jArray[i].timestamp*1000,jArray[i].price_close]);
	showPrice_open.push([jArray[i].timestamp*1000,parseInt(jArray[i].price_open)]);
	vol.push([jArray[i].timestamp*1000,parseInt(jArray[i].volume24)]);
	volcoin.push([jArray[i].timestamp*1000,parseInt(jArray[i].volume24/jArray[i].price_close)]);

}

var all_dat = 0; //All year
var month12_dat = Date.now() - 31556952000; //12 months (1year)
var month3_dat = Date.now() - 7889238000; //3 months
var month1_dat = Date.now() - 2629746000; //1 month
var day7_dat = Date.now() - 828718250; //7 days
var daily_dat = Date.now() - 118388321;

var newvol;
var newvolcoin;
var newshowPrice_open;
var newshowPrice_close;
var chartData;



var drawchart = function() {
  nv.addGraph(function() {
	   if ($(window).width() <= 970) {
			var chart = nv.models.stackedAreaChart()
						  .margin({right: 10})
						  .margin({left: 10})
						  .x(function(d) { return d[0] })   //We can modify the data accessor functions...
						  .y(function(d) { return d[1] })   //...in case your data is formatted differently.
						  .useInteractiveGuideline(true)    //Tooltips which show all data points. Very nice!
						  .rightAlignYAxis(true)      //Let's move the y-axis to the right side.
						  .duration(500)
						  .showControls(true)       //Allow user to choose 'Stacked', 'Stream', 'Expanded' mode.
						  .color(['#00c7ff','#2fabce','#3a90a8'])
						  .showYAxis(false)
						  .tooltips(true)
						  .showLegend(false)
						  .clipEdge(true);
	   }
	   else {
	   	var chart = nv.models.stackedAreaChart()
						  .margin({right: 100})
						  .x(function(d) { return d[0] })   //We can modify the data accessor functions...
						  .y(function(d) { return d[1] })   //...in case your data is formatted differently.
						  .useInteractiveGuideline(true)    //Tooltips which show all data points. Very nice!
						  .rightAlignYAxis(true)      //Let's move the y-axis to the right side.
						  .tooltips(true)
						  .showLegend(false)
						  .duration(500)
						  .showControls(true)       //Allow user to choose 'Stacked', 'Stream', 'Expanded' mode.
						  .color(['#00c7ff','#2fabce','#3a90a8']) 
						  .clipEdge(true);
	   }

    //Format x-axis labels with custom function.
    chart.xAxis
        .tickFormat(function(d) { 
          return d3.time.format('%x')(new Date(d)) 
    });

    chart.yAxis.tickFormat(d3.format(','));
	
	chart.interactiveLayer.tooltip.contentGenerator(function (d) {
          var html = "<table><tr><td colspan='2'>" + d.value + "</td></tr>";

          d.series.forEach(function(elem){
			  if(elem.key === "Close" || elem.key === "Open" || elem.key === "Daily Volume (USD)"){
				html += "<tr><td>" + elem.key + "</td> <td>$" + elem.value.toLocaleString('en', {maximumSignificantDigits : 21}) + "</td></tr>";
			  }
			  else{
				html += "<tr><td>" + elem.key + "</td> <td>" + elem.value.toLocaleString('en', {maximumSignificantDigits : 21}) + "</td></tr>";
			  }
          })
		  
		  html+= "</table>";
          return html;
        })
	
	chart.yAxis.showMaxMin(false);

	
	//chart.tooltip.valueFormatter(d3.format('.8f'));
	//chart.interactiveLayer.tooltip.valueFormatter(function(d) { return d.toFixed(8) });
	//chart.interactiveLayer.tooltip.valueFormatter(d3.format(',.8f'));
	

		var ydomain = yMax*1.2;
		chart.yDomain([0,ydomain]);

	
    d3.select('#chart svg')
      .datum(chartData)
      .call(chart);
	

    nv.utils.windowResize(chart.update);
	
		chart.stacked.dispatch.on('areaClick.toggle', null);
	chart.stacked.dispatch.on('areaClick', null);
	
    return chart;
  });
}

var drawchartdaily = function() {
  nv.addGraph(function() {
	   if ($(window).width() <= 970) {
			var chart = nv.models.stackedAreaChart()
						  .margin({right: 10})
						  .margin({left: 10})
						  .x(function(d) { return d[0] })   //We can modify the data accessor functions...
						  .y(function(d) { return d[1] })   //...in case your data is formatted differently.
						  .useInteractiveGuideline(true)    //Tooltips which show all data points. Very nice!
						  .rightAlignYAxis(true)      //Let's move the y-axis to the right side.
						  .duration(500)
						  .showControls(true)       //Allow user to choose 'Stacked', 'Stream', 'Expanded' mode.
						  .color(['#00c7ff','#2fabce','#3a90a8'])
						  .showYAxis(false)
						  .tooltips(true)
						  .showLegend(false)
						  .clipEdge(true);
	   }
	   else {
	   	var chart = nv.models.stackedAreaChart()
						  .margin({right: 100})
						  .x(function(d) { return d[0] })   //We can modify the data accessor functions...
						  .y(function(d) { return d[1] })   //...in case your data is formatted differently.
						  .useInteractiveGuideline(true)    //Tooltips which show all data points. Very nice!
						  .rightAlignYAxis(true)      //Let's move the y-axis to the right side.
						  .tooltips(true)
						  .duration(500)
						  .showLegend(false)
						  .showControls(true)       //Allow user to choose 'Stacked', 'Stream', 'Expanded' mode.
						  .color(['#00c7ff','#2fabce','#3a90a8']) 
						  .clipEdge(true);
	   }

    //Format x-axis labels with custom function.
    chart.xAxis
        .tickFormat(function(d) { 
          return new Date(d).toLocaleTimeString()
    });
	
	chart.interactiveLayer.tooltip.contentGenerator(function (d) {
          var html = "<table><tr><td colspan='2'>" + d.value + "</td></tr>";

          d.series.forEach(function(elem){
			  if(elem.key === "Close" || elem.key === "Open" || elem.key === "Daily Volume (USD)"){
				html += "<tr><td>" + elem.key + "</td> <td>$" + elem.value.toLocaleString('en', {maximumSignificantDigits : 21}) + "</td></tr>";
			  }
			  else{
				html += "<tr><td>" + elem.key + "</td> <td>" + elem.value.toLocaleString('en', {maximumSignificantDigits : 21}) + "</td></tr>";
			  }
          })
		  
		  html+= "</table>";
          return html;
        })

    chart.yAxis.tickFormat(d3.format(','));
	
	chart.yAxis.showMaxMin(false);
	


		var ydomain = yMax*1.5;
		chart.yDomain([0,ydomain]);

	
	/*
		 maxValue = Math.max.apply(Math,data[0].values.map(function(o){return o[1];}));
	 minValue = Math.min.apply(Math,data[0].values.map(function(o){return o[1];}));
	 margin = 0.1 * (maxValue - minValue);
	 options.chart.yDomain = [minValue, maxValue+margin];

	*/
	
	//chart.tooltip.valueFormatter(d3.format('.8f'));
	//chart.interactiveLayer.tooltip.valueFormatter(function(d) { return d.toFixed(8) });
	//chart.interactiveLayer.tooltip.valueFormatter(d3.format(',.8f'));
	
	
	
    d3.select('#chart svg')
      .datum(chartData)
      .call(chart);
	

    nv.utils.windowResize(chart.update);
	
		chart.stacked.dispatch.on('areaClick.toggle', null);
	chart.stacked.dispatch.on('areaClick', null);
	
    return chart;
  });
}

var showwhichdat = 0;

function alldat(){
	
showwhichdat = 0;

$("#gr1").removeClass("graphclick");
$("#gr2").removeClass("graphclick");
$("#gr3").removeClass("graphclick");
$("#gr4").removeClass("graphclick");
$("#gr5").removeClass("graphclick");
$("#gr6").addClass("graphclick");
$(".nvtooltip").remove();
$("#chart svg").empty();

	if(graphtype == 0){
		
		newvol = vol.filter(function(data) {
			return data[0] >= all_dat;
		});
		
		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= all_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= all_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= all_dat;
		});
		
		
		chartData = [ 
				
			{ 
			  key : "Open (USD)" , 
			  values : newshowPrice_open 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));
		
		var yMaxshowPrice_open = Math.max.apply(null,
                        Object.keys(newshowPrice_open).map(function(e) {
                                return newshowPrice_open[e][1];
                        }));
						
								
		yMax = yMaxPrice + yMaxshowPrice_open;
		
		drawchart(); //draw graph
		
	}
	else{
		 newvol = vol.filter(function(data) {
			return data[0] >= all_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= all_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= all_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= all_dat;
		});
		
		chartData = [ 
				
			{ 
			  key : "Daily Volume (" + coinnamie + ")" , 
			  values : newvolcoin 
			} ,
			
			{ 
			  key : "Daily Volume (USD)" , 
			  values : newvol 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];

		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));

		var yMaxDailyVol = Math.max.apply(null,
                        Object.keys(newvolcoin).map(function(e) {
                                return newvolcoin[e][1];
                        }));
						
		var yMaxnewvol = Math.max.apply(null,
                        Object.keys(newvol).map(function(e) {
                                return newvol[e][1];
                        }));
								
		yMax = yMaxDailyVol + yMaxnewvol + yMaxPrice;
		
		drawchart(); //draw graph
	}
	
}

function month12year(){
	
showwhichdat = 1;

$("#gr1").removeClass("graphclick");
$("#gr2").removeClass("graphclick");
$("#gr3").removeClass("graphclick");
$("#gr4").removeClass("graphclick");
$("#gr5").addClass("graphclick");
$("#gr6").removeClass("graphclick");
$(".nvtooltip").remove();
$("#chart svg").empty();

if(graphtype == 0){
		
		newvol = vol.filter(function(data) {
			return data[0] >= month12_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= month12_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= month12_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= month12_dat;
		});
		
		
		chartData = [ 
				
			{ 
			    key : "Open (USD)" , 
			  values : newshowPrice_open 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		

		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));
		
		var yMaxshowPrice_open = Math.max.apply(null,
                        Object.keys(newshowPrice_open).map(function(e) {
                                return newshowPrice_open[e][1];
                        }));
						
		yMax = yMaxPrice + yMaxshowPrice_open;
		
		drawchart(); //draw graph
		
	}
	else{
		 newvol = vol.filter(function(data) {
			return data[0] >= month12_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= month12_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= month12_dat;
		});

		 newshowPrice_close = showPrice.filter(function(data) {
			return data[0] >= month12_dat;
		});
		
		
		chartData = [ 
					
			{ 
			  key : "Daily Volume (" + coinnamie + ")" , 
			  values : newvolcoin 
			} ,
			
			{ 
			  key : "Daily Volume (USD)" , 
			  values : newvol 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		

		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));

		var yMaxDailyVol = Math.max.apply(null,
                        Object.keys(newvolcoin).map(function(e) {
                                return newvolcoin[e][1];
                        }));
						
		var yMaxnewvol = Math.max.apply(null,
                        Object.keys(newvol).map(function(e) {
                                return newvol[e][1];
                        }));
								
		yMax = yMaxDailyVol + yMaxnewvol + yMaxPrice;
		
		drawchart(); //draw graph
	}

}

function month3(){
	
showwhichdat = 2;

$("#gr1").removeClass("graphclick");
$("#gr2").removeClass("graphclick");
$("#gr3").removeClass("graphclick");
$("#gr4").addClass("graphclick");
$("#gr5").removeClass("graphclick");
$("#gr6").removeClass("graphclick");
$(".nvtooltip").remove();
$("#chart svg").empty();

if(graphtype == 0){
		
		newvol = vol.filter(function(data) {
			return data[0] >= month3_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= month3_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= month3_dat;
		});

		 newshowPrice_close = showPrice.filter(function(data) {
			return data[0] >= month3_dat;
		});
		
		
		chartData = [ 
				
			{ 
			  key : "Open (USD)" , 
			  values : newshowPrice_open 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];

		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));
		
		var yMaxshowPrice_open = Math.max.apply(null,
                        Object.keys(newshowPrice_open).map(function(e) {
                                return newshowPrice_open[e][1];
                        }));
						
		yMax = yMaxPrice + yMaxshowPrice_open;
		
		drawchart(); //draw graph
		
	}
	else{
		 newvol = vol.filter(function(data) {
			return data[0] >= month3_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= month3_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= month3_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= month3_dat;
		});
		
		
		chartData = [ 
						
			{ 
			  key : "Daily Volume (" + coinnamie + ")" , 
			  values : newvolcoin 
			} ,
			
			{ 
			  key : "Daily Volume (USD)" , 
			  values : newvol 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];

		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));

		var yMaxDailyVol = Math.max.apply(null,
                        Object.keys(newvolcoin).map(function(e) {
                                return newvolcoin[e][1];
                        }));
						
		var yMaxnewvol = Math.max.apply(null,
                        Object.keys(newvol).map(function(e) {
                                return newvol[e][1];
                        }));
								
		yMax = yMaxDailyVol + yMaxnewvol + yMaxPrice;
		
		drawchart(); //draw graph
	}
	
}

function month1(){
	
showwhichdat = 3;

$("#gr1").removeClass("graphclick");
$("#gr2").removeClass("graphclick");
$("#gr3").addClass("graphclick");
$("#gr4").removeClass("graphclick");
$("#gr5").removeClass("graphclick");
$("#gr6").removeClass("graphclick");
$(".nvtooltip").remove();
$("#chart svg").empty();

if(graphtype == 0){
		
		newvol = vol.filter(function(data) {
			return data[0] >= month1_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= month1_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= month1_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= month1_dat;
		});
		
		
		chartData = [ 
				
			{ 
			  key : "Open (USD)" , 
			  values : newshowPrice_open 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];

		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));
		
		var yMaxshowPrice_open = Math.max.apply(null,
                        Object.keys(newshowPrice_open).map(function(e) {
                                return newshowPrice_open[e][1];
                        }));
						
		yMax = yMaxPrice + yMaxshowPrice_open;
		
		drawchart(); //draw graph
		
	}
	else{
		 newvol = vol.filter(function(data) {
			return data[0] >= month1_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= month1_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= month1_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= month1_dat;
		});
		
		
		chartData = [ 
						
			{ 
			  key : "Daily Volume (" + coinnamie + ")" , 
			  values : newvolcoin 
			} ,
			
			{ 
			  key : "Daily Volume (USD)" , 
			  values : newvol 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));

		var yMaxDailyVol = Math.max.apply(null,
                        Object.keys(newvolcoin).map(function(e) {
                                return newvolcoin[e][1];
                        }));
						
		var yMaxnewvol = Math.max.apply(null,
                        Object.keys(newvol).map(function(e) {
                                return newvol[e][1];
                        }));
								
		yMax = yMaxDailyVol + yMaxnewvol + yMaxPrice;
		
		drawchart(); //draw graph
	}

}

function day7dat(){
	
showwhichdat = 4;

$("#gr1").removeClass("graphclick");
$("#gr2").addClass("graphclick");
$("#gr3").removeClass("graphclick");
$("#gr4").removeClass("graphclick");
$("#gr5").removeClass("graphclick");
$("#gr6").removeClass("graphclick");
$(".nvtooltip").remove();
$("#chart svg").empty();

if(graphtype == 0){
		
		newvol = vol.filter(function(data) {
			return data[0] >= day7_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= day7_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= day7_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= day7_dat;
		});
		
		
		chartData = [ 
				
			{ 
			   key : "Open (USD)" , 
			  values : newshowPrice_open 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		

		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));
		
		var yMaxshowPrice_open = Math.max.apply(null,
                        Object.keys(newshowPrice_open).map(function(e) {
                                return newshowPrice_open[e][1];
                        }));
						
			yMax = yMaxPrice + yMaxshowPrice_open;
		
		drawchart(); //draw graph
		
	}
	else{
		 newvol = vol.filter(function(data) {
			return data[0] >= day7_dat;
		});

		newvolcoin = volcoin.filter(function(data) {
			return data[0] >= day7_dat;
		});

		 newshowPrice_open = showPrice_open.filter(function(data) {
			return data[0] >= day7_dat;
		});

		 newshowPrice_close = showPrice_close.filter(function(data) {
			return data[0] >= day7_dat;
		});
		
		
		chartData = [ 
						
			{ 
			  key : "Daily Volume (" + coinnamie + ")" , 
			  values : newvolcoin 
			} ,
			
			{ 
			  key : "Daily Volume (USD)" , 
			  values : newvol 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));

		var yMaxDailyVol = Math.max.apply(null,
                        Object.keys(newvolcoin).map(function(e) {
                                return newvolcoin[e][1];
                        }));
						
		var yMaxnewvol = Math.max.apply(null,
                        Object.keys(newvol).map(function(e) {
                                return newvol[e][1];
                        }));
								
		yMax = yMaxDailyVol + yMaxnewvol + yMaxPrice;
		
		drawchart(); //draw graph
	}

}

function dailydat(){
	
showwhichdat = 5;

$("#gr1").addClass("graphclick");
$("#gr2").removeClass("graphclick");
$("#gr3").removeClass("graphclick");
$("#gr4").removeClass("graphclick");
$("#gr5").removeClass("graphclick");
$("#gr6").removeClass("graphclick");
$(".nvtooltip").remove();
$("#chart svg").empty();
	
if(graphtype == 0){
		
		newvol = voldaily.filter(function(data) {
			return data[0] >= daily_dat;
		});

		newvolcoin = volcoindaily.filter(function(data) {
			return data[0] >= daily_dat;
		});

		 newshowPrice_open = showPrice_opendaily.filter(function(data) {
			return data[0] >= daily_dat;
		});

	
		
		chartData = [ 
				
			{ 
			  key : "Open (USD)" , 
			  values : newshowPrice_open 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));
		
		var yMaxshowPrice_open = Math.max.apply(null,
                        Object.keys(newshowPrice_open).map(function(e) {
                                return newshowPrice_open[e][1];
                        }));
						
		yMax = yMaxPrice + yMaxshowPrice_open;

		
		drawchartdaily(); //draw graph
		
	}
	else{
		 newvol = voldaily.filter(function(data) {
			return data[0] >= daily_dat;
		});

		newvolcoin = volcoindaily.filter(function(data) {
			return data[0] >= daily_dat;
		});

		 newshowPrice_open = showPrice_opendaily.filter(function(data) {
			return data[0] >= daily_dat;
		});

		
		
		
		chartData = [ 
						
			{ 
			  key : "Daily Volume (" + coinnamie + ")" , 
			  values : newvolcoin 
			} ,
			
			{ 
			  key : "Daily Volume (USD)" , 
			  values : newvol 
			} ,
			
			{ 
			  key : "Close (USD)" , 
			  values : newshowPrice_close 
			} 

		];
		
		var yMaxPrice = Math.max.apply(null,
                        Object.keys(newshowPrice_close).map(function(e) {
                                return newshowPrice_close[e][1];
                        }));

		var yMaxDailyVol = Math.max.apply(null,
                        Object.keys(newvolcoin).map(function(e) {
                                return newvolcoin[e][1];
                        }));
						
		var yMaxnewvol = Math.max.apply(null,
                        Object.keys(newvol).map(function(e) {
                                return newvol[e][1];
                        }));
								
	
		yMax = yMaxDailyVol + yMaxnewvol + yMaxPrice;

		
		drawchartdaily(); //draw graph
	}
	
}

function whichdat(){
	if(showwhichdat == 0){
		alldat();
	}
	else if(showwhichdat == 1){
		month12year();
	}
	else if(showwhichdat == 2){
		month3();
	}
	else if(showwhichdat == 3){
		month1();
	}
	else if(showwhichdat == 4){
		day7dat();
	}
	else if(showwhichdat == 5){
		dailydat();
	}
}

function changegraphtype(){
		graphtype = 1;
		whichdat();
		$("#graphchoice").addClass("graphclick");
		$("#graphchoice2").removeClass("graphclick");
}

function changegraphtype2(){
		graphtype = 0;
		whichdat();
		$("#graphchoice").removeClass("graphclick");
		$("#graphchoice2").addClass("graphclick");
}

//for exchange chart
var hideexchangedt = 0;

function showall(){
		if(hideexchangedt == 0){
			$("#shall").text("Hide");
			$("#showall").css('background-color','#d42020');
			$("#showall").css('border-color','#9e3838');
			$(".hidetr").show();
			hideexchangedt = 1;
		}
		else{
			$("#shall").text("Show All");
			$("#showall").css('background-color','#337ab7');
			$("#showall").css('border-color','#2e6da4');
			$(".hidetr").hide();
			hideexchangedt = 0;
		}
		$("#graphchoice").addClass("graphclick");
		$("#graphchoice2").removeClass("graphclick");
}

changegraphtype2();

