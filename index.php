<!DOCTYPE html>
<html>
<head>
	<title>Thesaurus Rex</title>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="js/wordFreq.js"></script>
	<script src="js/POSTagger.js"></script>	
	<script src="js/keepWord.js"></script>
	<script src="js/main.js"></script>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
	<textarea id="text"></textarea>
	<br />
	Count: 
	<select id="wordMax">
		<?php
			for ($i=1; $i<11; $i++) {
				echo "<option value='".$i."'>".$i."</option>";
			}
		?>
	</select>
	Sentences apart: 
	<select id="sentenceMax">
		<?php
			for ($i=0; $i<11; $i++) {
				echo "<option value='".$i."'>".$i."</option>";
			}
		?>
	</select>
	<button id="start">Start</button>
	<br />
	<br />
	<div id="loading"></div>
	<br />
	<br />
	<div id="highlighted"></div>
</body>
</html>