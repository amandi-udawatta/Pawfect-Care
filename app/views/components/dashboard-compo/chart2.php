<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {

var dps = []; // dataPoints
var chart = new CanvasJS.Chart("chartContainer", {
	title :{
		text: "Dynamic Data"
	},
	data: [{
		type: "line",
		dataPoints: dps
	}]
});

var xVal = 0;
var yVal = 100; 
var updateInterval = 1000;
var dataLength = 20; // number of dataPoints visible at any point

var updateChart = function (count) {

	count = count || 1;

	for (var j = 0; j < count; j++) {
		yVal = yVal +  Math.round(5 + Math.random() *(-5-5));
		dps.push({
			x: xVal,
			y: yVal
		});
		xVal++;
	}

	if (dps.length > dataLength) {
		dps.shift();
	}

	chart.render();
};

updateChart(dataLength);
setInterval(function(){updateChart()}, updateInterval);

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width:100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>