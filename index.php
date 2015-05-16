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
        <script type="text/javascript">
            var chosenDate;
            var monthtext = new Array();
            monthtext[0] = "January";
            monthtext[1] = "February";
            monthtext[2] = "March";
            monthtext[3] = "April";
            monthtext[4] = "May";
            monthtext[5] = "June";
            monthtext[6] = "July";
            monthtext[7] = "August";
            monthtext[8] = "September";
            monthtext[9] = "October";
            monthtext[10] = "November";
            monthtext[11] = "December";

    		$(function() {
        	  $( ".datepicker" ).datepicker( {
                 dateFormat: "dd-mm-yy",
                  //dateFormat: "yy-mm-dd",
                  minDate: new Date("Mon Dec 18 2014"),
                  maxDate: new Date("Mon Dec 31 2014")
                });

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

            function formatDate(date){

                var datearr = date.split('-');
                var month = datearr[1];
                var day = datearr[0];
                var year = datearr[2];

                chosenDate = new Date(year,month-1,day);
                return chosenDate;
            }

            function FormatNumberLength(num, length) {
                var r = "" + num;
                while (r.length < length) {
                    r = "0" + r;
                }
                return r;
            }

            function capitalize(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            function listFiles(){
                var operationsHTML = XML.getFile('images').responseText;
                var linkStart = 0
                var linkEnd = 0
                while (linkStart <= linkEnd) {
                  linkStart = operationsHTML.indexOf('<a', linkEnd);
                    if (linkStart > -1) {
                        linkEnd = operationsHTML.indexOf('</a>', linkStart) + 4;
                        if (linkEnd > -1) {
                            var hvs = operationsHTML.indexOf('href="', linkStart) + 6;
                            var hve = operationsHTML.indexOf('"', hvs) - 1;
                            var tnvs = operationsHTML.indexOf('>', linkStart) + 1;
                            var tnve = operationsHTML.indexOf('<', tnvs) - 1;
                            if (operationsHTML.substring(hvs, hve) == operationsHTML.substring(tnvs, tnve)) {
                               alert(operationsHTML.substring(tnvs, tnve))
                               operations[operationsHTML.substring(tnvs, tnve)] = null;
                            }
                        }
                    }
                }
            }

            function updateImageByFilename(filename){

            }

            function updateDownloadLink(date){

                $('.downloadlink').remove();

                var datearr = date.split('-');
                var month = datearr[1];
                var day = datearr[0];
                var year = datearr[2];

                var foldername = "latest_contours_"+year+"-"+month+"-"+day;

                //show download link or archive file
                $('#downloaddiv').append("<a title='"+monthtext[month-1]+" "+day+", "+year+"' class='buttonlink downloadlink' href='archive/"+foldername+".tar.bz2'>Download Contours</a>");
            }

            function updateTimeDiv(type, date){
                //list all files in directory "yyyy-mm-dd"
                $('#linksplaceholder').append("<h2 class='timeh2'>Time</h2>");
                $('#linksplaceholder').append("<ul class='linklist'>");
                    for(i=0; i<24; i++){
                        var tempfilename = FormatNumberLength(i,2)+":20";
                        $('.linklist').append("<li><a href='#' onclick=\"updateImage('"+type+"', '"+date+"', '"+FormatNumberLength(i,2)+"-20-00')\">"+tempfilename+"</a></li>");
                    }
                $('#linksplaceholder').append("</ul>");

            }

            function updateImage(type, date, time){

                $('.timeh2').remove();
                $('.contourh1').remove();
                $('.contourh3').remove();
                $('.contourimage').remove();
                $('.linklist').remove();
                $('.errormessage').remove();

                var errormessage = "";

                if(type == ""){
                    errormessage = errormessage+"*Please choose a Contour Type first.<br />";
                }
                if(date == ""){
                    errormessage = errormessage+"*Please choose a Date first.<br />";
                }

                if(errormessage != ""){
                    $('#errordiv').append("<p class='errormessage'>"+errormessage+"</p>");
                    return 1;
                }

                var datearr = date.split('-');
                var month = datearr[1];
                var day = datearr[0];
                var year = datearr[2];

                chosenDate = new Date(year,month-1,day);

                var typearr = type.split('_');
                var timearr = time.split('-');
                var foldername = "latest_contours_"+year+"-"+month+"-"+day;
                var filename = foldername+"/"+type+"_"+date+"_"+time+".png";

                //alert(filename);
                // alert(type+"_"+date+"_"+FormatNumberLength(0,2)+"-20-00.png");

                $('#imageplaceholder').append("<h1 class='contourh1'>"+capitalize(typearr[0])+" "+capitalize(typearr[1])+" "+capitalize(typearr[2])+"</h1><h3 class='contourh3'>"+monthtext[month-1]+" "+day+", "+year+" | "+timearr[0]+":"+timearr[1]+"</h3>");
                $('#imageplaceholder').append("<img src='images/"+filename+"' class='contourimage' />");

                updateTimeDiv(type, date);

            }

        </script>
</head>

<body>


    <div id="sidemenu" class="float-left">
        <h1>Project NOAH Contours</h1>
    	<form action="index.php" method="get">
            <div id="inner-form">
        		<label for="contourtype">Contour Type: </label>
        		<select name="contourtype" id="contourtype">
        			<option></option>
        			<option value="air_temperature_contour">Temperature</option>
        			<option value="air_pressure_contour">Pressure</option>
        			<option value="air_humidity_contour">Humidity</option>
        			<option value="rain_value_contour">Rainfall</option>
        			<!--option value="3-ho">3-Hour Rainfall</option>
        			<option value="6-ho">6-Hour Rainfall</option>
        			<option value="12-h">12-Hour Rainfall</option>
        			<option value="24-h">24-Hour Rainfall</option-->
        		</select><br />
        		<label for="date" >Date: </label>
        		<input readonly="true" onchange="updateDownloadLink($(this).val())" type='text' name='date' id='date' class='datepicker' />
            </div>

    	  <!--label class="float-left" for="amount">Range:</label>
    	  <div class="float-left" id="slider-range"></div>
    	  <input class="float-left" type="text" id="amount" readonly style="border:0; font-weight:bold;">
    	  <div class="clear-both"></div-->
        </form>
        <div id="downloaddiv">
          <a class='buttonlink' id="loadbutton" href="#" onclick="updateImage($('#contourtype').val(), $('#date').val(), '00-20-00')">
              Load 
          </a>
        </div>
        <div id="errordiv"></div>
    </div>
    <div id="content" class="float-left">
        <div class="float-left" id="imageplaceholder"></div>
    </div>
    <div id="rightmenu" class="float-right">
        <div class="float-left" id="linksplaceholder"></div>
    </div>
</body>

</html>