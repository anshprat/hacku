<?php
$giventext = $_POST['words'];
include_once('common.php');
//above commented out will cause error
$qwords = sanitiseinput($giventext);
// var_dump($qwords);

$html=<<<HTML
<!doctype html>
<html>
<head><title> IITM HackU Demo - Pictionary creator</title>
	   <link rel="stylesheet" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset.css" type="text/css">
	    <link rel="stylesheet" href="http://yui.yahooapis.com/3.3.0/build/cssfonts/fonts.css" type="text/css">
	    <link rel="stylesheet" href="http://yui.yahooapis.com/3.3.0/build/cssgrids/grids.css" type="text/css">
	    <style>

	     DIV{ border-width: 1;
	    border-style : solid ;
	    border-color : #e0e0e0 ;
	}
	    </style>
	</head>
	<body>
HTML;
echo $html;
?>
		<form name="hacku" method="POST" action="">
			<textarea rows="6" cols="60" name="words"></textarea>
			<input type="submit" value="submit" />
			</form>
			
<?php
$ans = getimages($qwords);
?>
</div>
<div id="answer" style="display:none;">
<?php

if($ans){
echo $ans;
$ans=<<<ANS
</div>
	<script type="text/javascript">
		function showans(){
			document.getElementById('answer').style.display="block";
		}
	</script>
<div>
<span id="show" onclick="showans();">Show Answer</span>
</div>
ANS;
echo $ans;
}
?>


