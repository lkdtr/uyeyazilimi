<?php

// anti-xss function
function XSS($data){
	if( is_array($data) ){
		// doing it recuresively
		foreach ($data as $key => $value){
			$data[ $key ] = XSS($value);
		}
	}else{
		// converting asciis
		$data = str_replace(
			array('#',     '&',     "'",     '"',     '<',     '>'),
			array("&#35;", "&#38;", "&#39;", "&#34;", "&#60;", "&#62;"),
		$data );
	}
	// result
	return $data;
}

?>