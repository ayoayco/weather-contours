<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/ico" href="noah-favicon.ico"/>
	<link rel="stylesheet" href="css/reset.css"/>
	<link rel="stylesheet" href="css/style.css"/>
	<title>Contour Archive | Project NOAH</title>
	<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
	<script src="jquery-ui/jquery-1.11.2.min.js"></script>
	<script src="jquery-ui/jquery-ui.js"></script>
	<script>
		$(function() {
		  $( "#slider-range" ).slider({
		    range: true,
		    min: 0,
		    max: 500,
		    values: [ 75, 300 ],
		    slide: function( event, ui ) {
		      $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		    }
		  });
		  $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
		    " - " + $( "#slider-range" ).slider( "values", 1 ) );
		});
	</script>
</head>

<body>

	<h1>Project NOAH Contours</h1>
	<form>
		<label for="contourtype">Contour Type: </label>
		<select id="contourtype">
			<option value="temp">Temperature</option>
			<option value="pres">Pressure</option>
			<option value="humi">Humidity</option>
			<option value="rain">Rainfall</option>
			<option value="3-ho">3-Hour Rainfall</option>
			<option value="6-ho">6-Hour Rainfall</option>
			<option value="12-h">12-Hour Rainfall</option>
			<option value="24-h">24-Hour Rainfall</option>
		</select><br />
		<label for="fromdate">From: </label>

		<br />
		<label for="todate">To: </label>

		<br />

	</form>

	<p>
	  <label for="amount">Range:</label>
	  <input type="text" id="amount" readonly style="border:0; font-weight:bold;">
	</p>
	 
	<div id="slider-range"></div>

</body>

</html>