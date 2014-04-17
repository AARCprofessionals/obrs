<?php
//Output HTML
function themex_html($string) {
	return do_shortcode(html_entity_decode(themex_stripslashes($string)));
}

//Strip Slashes
function themex_stripslashes($string) {
	return stripslashes(stripslashes($string));
}

//Shuffle Array
function themex_shuffle($array) {
	$keys=array_keys($array);
	shuffle($keys);
	
	$shuffled=array();
	foreach($keys as $key) {
		$shuffled[$key] = $array[$key]; 
	}
	return $shuffled;
}
?>