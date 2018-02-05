<?php
set_time_limit(0);

echo '<form method="post">
<input type="text" name="dork" placeholder="dork" />
<input type="submit" name="get" value="GeT" /><br>
<textarea name="sites" cols="50" rows="13" >
';

$dork = $_POST['dork'];

if(isset($_POST['get']) && $dork != ""){
$sites = @array_map("site",bing("$dork"));
if(!empty($sites)){
	$ss = array_unique($sites);
	echo implode("\r\nwww.", $ss);
	
}else{
	echo "no rezult";
}


	
	
}


echo '</textarea>';
////////////////////////////////////////////////////
function site($link){
	return str_replace("www.","",parse_url($link, PHP_URL_HOST));
	
}


////////////////////////////////////////////////////////
function bing($what){
	for($i = 1; $i <= 2000; $i += 10){
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, "http://www.bing.com/search?q=".urlencode($what)."&&first=".$i."&FORM=PERE");
		curl_setopt ($ch, CURLOPT_USERAGENT, "msnbot/1.0 (+http://search.msn.com/msnbot.htm)");
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, getcwd().'/log.txt');
		curl_setopt ($ch, CURLOPT_COOKIEJAR, getcwd().'/log.txt');
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		preg_match_all('#;a=(.*?)" h="#', $data, $links);
		foreach($links[1] as $link){
		$allLinks[] = $link;	
		}
		if(!preg_match('#"sw_next"#', $data)) break;
		
		
	}
	
	if(!empty($allLinks) && is_array($allLinks)){
	return array_unique(array_map("urldecode",$allLinks));	
	}
	
}
///////////////////////////////////////////









?>