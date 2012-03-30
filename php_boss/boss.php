<?php
require_once("OAuth.php");

function getbossimages($query,$random=0){ 
	require("secrets.php");
$url = "http://yboss.yahooapis.com/ysearch/images";
$args = array();
 $_GET['q']?$q=$_GET['q']:$q='yahoo';
// $args["web.q"] = "$q";
// $args["news.q"]= "$q";
$args["images.q"] = urlencode($query);
 $_GET['xml']?$f='xml':$f='json';
 
$args["format"] = "$f";
// if($_GET['rand'])
$args["start"] = mt_rand(0,10);
$args["count"] = '1';

 
$consumer = new OAuthConsumer($cc_key, $cc_secret);
$request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
$url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));
$ch = curl_init();
$headers = array($request->to_header());
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
// curl_setopt($ch,CURLOPT_PROXY,'10.0.0.1:3128');//You can set proxies as well!
$rsp = curl_exec($ch);
// print_r($rsp);
if($f=='json'){
$results = json_decode($rsp,TRUE);
}else{
	die('error in boss.php line32');
}
// var_dump($results);
$res = $results['bossresponse']['images']['results'];
return($res[0]['thumbnailurl']);
// return $res;
}
// $results = getbossimages();
$html=<<<HTML
<!doctype="html"><html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>BOSS DEMO</title>
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
<div class="yui3-g" id="layout">
HTML;
foreach($results['bossresponse']['images']['results'] as $result){
$html.=<<<HTML
 <div class="yui3-u" >
<a href="$result[refererclickurl]" alt="$result[refererurl]"><img src="$result[thumbnailurl]"></a>
<div class="yui3-u-1-2">$result[title]</div>
<div class="yui3-1-2">$result[height]x$result[width]|$result[size]</div>
</div>

HTML;
}
$html.='<div>WEB </div>';
foreach($results['bossresponse']['web']['results'] as $result){
$html.=<<<HTML
 <div class="yui3-u" >
<a href="$result[clickurl]" >$result[title]</a> | $result[abstract] | $result[dispurl] 
</div>

HTML;
}
$html.='<div>NEWS  ________RESULTS</div>';
foreach($results['bossresponse']['news']['results'] as $result){
$html.=<<<HTML
 <div class="yui3-u" >
<a href="$result[url]" > $result[title] </a>$result[abstract] $result[source] $result[sourceurl]
</div>

HTML;
}

// echo $html;
//echo nl2br(print_r($results));
