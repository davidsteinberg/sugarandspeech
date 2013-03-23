<!DOCTYPE html>
<html>
<head>
	<title>Thesaurus Rex</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

	<script src="js/wordFreq.js"></script>
	<script src="js/POSTagger.js"></script>	
	<script src="js/keepWord.js"></script>

	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.fittext.js"></script>

	<script src="js/main.js"></script>

	<style>
		html {
			height: 100%;
		}
		body {
			height: 100%;
			background-color: rgb(50,100,150);
		}
		#chooserArea {
			display: none;
			width: 98.5%;
			background-color: white;
			border-radius: 5px;
			padding: 5px;
			height: 100%;
		}
		a.projectName {
			font-family: 'Patrick Hand SC', cursive;
			position: relative;
			left: -90px;
			top: 25px;
			color: lightblue;
			text-shadow: 1px 1px 1px navy;
		}
		a.bottomScript {
			color: white;
			text-shadow: 1px 1px 1px lightblue;
			font-family: cursive;
			float: right;
		}
	</style>
	<link href='http://fonts.googleapis.com/css?family=Patrick+Hand+SC' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container-fluid" style="height: 100%">
	<div class="row-fluid" style="height: 1%">
	</div>
	<div id="responsive_headline" class="row-fluid" style="height: 10%;background-color: rgb(250,250,250);text-align: center;">
		<img src="assets/images/lips.jpg" style="height: 100%;float: left;" />
		<img src="assets/images/sugar.png" style="height: 100%;float: left;position: relative;left: -50px;top: 20px;" />
		<a class="projectName">Sugar 'n Speech</a>
	</div>
	<div class="row-fluid" style="height: 3%">
	</div>
	<div class="row-fluid" style="height: 70%">
		<div class="span12" style="height: 100%">
			<textarea placeholder="Enter text here and click the Smart button." id="text" style="width: 98.5%;height: 100%;"></textarea>
			<div id="chooserArea"></div>
		</div>
	</div>
	<div class="row-fluid" style="height: 4%">
	</div>
	<div class="row-fluid" style="height: 6%">
		<div class="span12">
			<div class="progress progress-success progress-striped">
				<div id="progresser" class="bar" style="width: 0%;"></div>
			</div>
		</div>
	</div>
	<div class="row-fluid" style="height: 3%">
		<div class="span8" style="text-align: center;">
			<a class="bottomScript">A spoonful of sugar makes you sound smart...</a>
		</div>
		<div class="span4">
			<button id="start" style="float: right">Smart</button>
		</div>
	</div>
</div>
</body>
</html>