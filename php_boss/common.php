<?php
function sanitiseinput($string){
	include_once('dict.php');
	$raw = explode(' ',$string);
	$chopChars = ' ,:.?!:[]{}()-_';
	// var_dump($nullwords);
	$sane = $raw;
	// sort($sane);
	$i=0;
	$saner = array();
	while($i<count($sane)){
		if(strlen($sane[$i])>2){
			$saner[] =strtolower(trim($sane[$i],$chopChars));
			// echo strlen($sane[$i]).$sane[$i].'<br>';
			
		}
		$i++;
	}
	// The above can be done using one function array_walk()
	
	// var_dump($sane);
	$saner = array_unique($saner);
	$saner = array_diff($saner,$nullwords);
	
	// var_dump($saner);
	return $saner;
	
}


function getimages($qwords){
	include_once('boss.php');
	$results = array();
	foreach($qwords as $query){
		$results = getbossimages($query);
			flush();
			echo '<div class="yui3-u" ><img src="'.$results.'" title="'.$query.'"></div>';
			$ans .=' '.$query;
	}
	return $ans;
}
