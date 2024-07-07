"use strict";
jQuery(document).ready(function() {
	jQuery('#chart_for').on('change', function() {
		document.forms['chartfor'].submit();
	});
});
console.log(recordfit_data.user_chart_string);
var chart;
var graph;
var chartData =JSON.parse(JSON.stringify(recordfit_data.user_chart_string));
jQuery(document).ready(function () {
	chart = new AmCharts.AmSerialChart();
	chart.pathToImages = recordfit_data.imagepath;
	chart.dataProvider = chartData;
	chart.marginLeft = 10;
	chart.categoryField = "udate";
	chart.dataDateFormat = "YYYY-MM-DD";
	chart.addListener("dataUpdated", zoomChart);
	var categoryAxis = chart.categoryAxis;
	categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
	categoryAxis.minPeriod = "DD"; // our data is yearly, so we set minPeriod to YYYY
	categoryAxis.dashLength = 3;
	categoryAxis.minorGridEnabled = true;
	categoryAxis.minorGridAlpha = 0.1;
	// value
	var valueAxis = new AmCharts.ValueAxis();
	valueAxis.axisAlpha = 0;
	valueAxis.inside = true;
	valueAxis.dashLength = 3;
	chart.addValueAxis(valueAxis);
	// GRAPH
	graph = new AmCharts.AmGraph();
	graph.type = "smoothedLine"; // this line makes the graph smoothed line.
	graph.lineColor = "#d1655d";
	graph.negativeLineColor = "#637bb6"; // this line makes the graph to change color when it drops below 0
	graph.bullet = "round";
	graph.bulletSize = 8;
	graph.bulletBorderColor = "#FFFFFF";
	graph.bulletBorderAlpha = 1;
	graph.bulletBorderThickness = 2;
	graph.lineThickness = 2;
	graph.valueField = "value";
	chart.addGraph(graph);
	// CURSOR
	var chartCursor = new AmCharts.ChartCursor();
	chartCursor.cursorAlpha = 0;
	chartCursor.cursorPosition = "mouse";
	chartCursor.categoryBalloonDateFormat =  "DD";
	chart.addChartCursor(chartCursor);
	// SCROLLBAR
	var chartScrollbar = new AmCharts.ChartScrollbar();
	chart.addChartScrollbar(chartScrollbar);
	chart.creditsPosition = "bottom-right";
	// WRITE
	chart.write("chart-line");
});
// this method is called when chart is first inited as we listen for "dataUpdated" event
function zoomChart() {
	// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues               
}