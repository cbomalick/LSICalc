<?
/*****Langelier Saturation Index Calculator*****/
/*****Written by Collin Bomalick****************/
/*****github.com/cbomalick**********************/

//Detect if page has been submitted. If so, sanitize input
if(!empty($_POST)){
	$pH = htmlentities($_POST['ph'], ENT_QUOTES);
	$Temperature = htmlentities($_POST['temperature'], ENT_QUOTES);
	$Calcium = htmlentities($_POST['calcium'], ENT_QUOTES);
	$Alkalinity = htmlentities($_POST['alkalinity'], ENT_QUOTES);
	$Solids = htmlentities($_POST['solids'], ENT_QUOTES);
	$RoundedLSI = '0';
		
		//Verify that submitted values are numeric
		if(is_numeric($pH) && is_numeric($Temperature) && is_numeric($Calcium) && is_numeric($Alkalinity) && is_numeric($Solids)){
			//Perform calculations on inputs
			$TemperatureCelcius = (($Temperature - 32) / 1.8);
			
			$A = ((log10($Solids) - 1) / 10);
			$B = (-13.12 * log10($TemperatureCelcius + 273) + 34.55);
			$C = (log10($Calcium) - 0.4);
			$D = log10($Alkalinity);

			//Calculate final value
			$FullLSI = ($pH - ((9.3 + $A + $B) - ($C + $D)));

			//Round long LSI value to 1 decimal place. Values are rounded away from 0, making 1.5 into 2 and -1.5 into -2
			$RoundedLSI = round($FullLSI, PHP_ROUND_HALF_UP);
		}
} else {
	$pH = '';
	$Temperature = '';
	$TemperatureCelcius = '';
	$Calcium = '';
	$Alkalinity = '';
	$Solids = '';
	$RoundedLSI = '0';
}

?>

<html>

<head>
<style>
body {
	min-height: 100%;
	background: #0074D9;
	font-family: "Open Sans", sans-serif;
	font-size: 14px;
	color: #6c717f;
}

.container {
	text-align: center;
}

.panel {
	display: inline-block;
	padding: 15px;
    background-color: #FFFFFF;
	border-radius: 15px;
	box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h2 {
	font-weight: bold;
	border-bottom: 1px solid #E6E6E6;
	padding-bottom: 5px;
}

p {
	text-align: left;
}

.header {
	font-weight: bold;
}

.button {
    position: relative;
    display: inline-block;
    box-sizing: border-box;
    border: none;
    border-radius: 4px;
    padding: 0 16px;
    min-width: 64px;
    height: 36px;
    vertical-align: middle;
    text-align: center;
    text-overflow: ellipsis;
    text-transform: uppercase;
    color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
    background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
    box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    font-family: var(--pure-material-font, "Roboto", "Segoe UI", BlinkMacSystemFont, system-ui, -apple-system);
    font-size: 14px;
    font-weight: 500;
    line-height: 36px;
    overflow: hidden;
    outline: none;
    cursor: pointer;
    transition: box-shadow 0.2s;
}

.button::-moz-focus-inner {
    border: none;
}

/* Overlay */
.button::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
    opacity: 0;
    transition: opacity 0.2s;
}

/* Ripple */
.button::after {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    border-radius: 50%;
    padding: 50%;
    width: 32px; /* Safari */
    height: 32px; /* Safari */
    background-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
    opacity: 0;
    transform: translate(-50%, -50%) scale(1);
    transition: opacity 1s, transform 0.5s;
}

/* Hover, Focus */
.button:hover,
.button:focus {
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12);
}

.button:hover::before {
    opacity: 0.08;
}

.button:focus::before {
    opacity: 0.24;
}

.button:hover:focus::before {
    opacity: 0.3;
}

/* Active */
.button:active {
    box-shadow: 0 5px 5px -3px rgba(0, 0, 0, 0.2), 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12);
}

.button:active::after {
    opacity: 0.32;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0s;
}

.button.red {
	background-color: #f53649;
}

input {
	width: 100%;
}

.requiredfield {
	color: red;
	font-weight: bold;
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
	
	//Required Field validations
	//pH
	$("#submit").click(function(e) {
	var counter = $("#ph").val();
	if ((!(counter == '')) && $.isNumeric($("#ph").val())) {
	$("#phwarning").empty();
	} else {
	e.preventDefault();
	$("#phwarning").empty();
	$("#phwarning").append(" Must be a number");
	}
	});
	
	//Temperature
	$("#submit").click(function(e) {
	var counter = $("#temperature").val();
	if ((!(counter == '')) && $.isNumeric($("#temperature").val())) {
	$("#temperaturewarning").empty();
	} else {
	e.preventDefault();
	$("#temperaturewarning").empty();
	$("#temperaturewarning").append(" Must be a number");
	}
	});
	
	//Calcium Hardness
	$("#submit").click(function(e) {
	var counter = $("#calcium").val();
	if ((!(counter == '')) && $.isNumeric($("#calcium").val())) {
	$("#calciumwarning").empty();
	} else {
	e.preventDefault();
	$("#calciumwarning").empty();
	$("#calciumwarning").append(" Must be a number");
	}
	});
	
	//Alkalinity
	$("#submit").click(function(e) {
	var counter = $("#alkalinity").val();
	if ((!(counter == '')) && $.isNumeric($("#alkalinity").val())) {
	$("#alkalinitywarning").empty();
	} else {
	e.preventDefault();
	$("#alkalinitywarning").empty();
	$("#alkalinitywarning").append(" Must be a number");
	}
	});
	
	//Solids
	$("#submit").click(function(e) {
	var counter = $("#solids").val();
	if ((!(counter == '')) && $.isNumeric($("#solids").val())) {
	$("#solidswarning").empty();
	} else {
	e.preventDefault();
	$("#solidswarning").empty();
	$("#solidswarning").append(" Must be a number");
	}
	});
	
	//Reset button
	$("#reset").click(function(e) {
		$('#ph').val('');
		$('#temperature').val('');
		$('#calcium').val('');
		$('#alkalinity').val('');
		$('#solids').val('');
		$('#ph').val('');
	});
	
});

</script>

</head>
<body>
<?

Echo'
<div class="container">
	<div class="panel">
			<form autocomplete="off" action="?" id="form" method="post" enctype="multipart/form-data">
			<h2>Taylor Standard Index Calculator</h2>
			<p>Enter the current chemical readings</p>
			<p class="header">pH <span id="phwarning" class="requiredfield"></span></p>
			<p><input name="ph" id="ph" value="'.$pH.'"></p>
			<p class="header">Temperature (&#176;F)<span id="temperaturewarning" class="requiredfield"></span></p>
			<p><input name="temperature" id="temperature" value="'.$Temperature.'"></p>
			<p class="header">Calcium Hardness (ppm)<span id="calciumwarning" class="requiredfield"></span></p>
			<p><input name="calcium" id="calcium" value="'.$Calcium.'"></p>
			<p class="header">Alkalinity (ppm)<span id="alkalinitywarning" class="requiredfield"></span></p>
			<p><input name="alkalinity" id="alkalinity" value="'.$Alkalinity.'"></p>
			<p class="header">Total Dissolved Solids (ppm)<span id="solidswarning" class="requiredfield"></span></p>
			<p><input name="solids" id="solids" value="'.$Solids.'"></p>
			<p class="header">Calculated LSI Value</p>
			<p>'.$RoundedLSI.'</p>
			<button class="button" type="submit" name="submit" id="submit">Calculate</button> <button class="button red" name="reset" id="reset">Reset</button>
		</form>
	</div>
</div>';

?>

</body>

</html>
