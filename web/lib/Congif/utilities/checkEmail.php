<?php

function checkEmail($email) {
	if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email) )
		return true;
	else
		return false;
}

/*
function checkEmail($email, $domainCheck = false) {
	// checks proper syntax
	if( !preg_match("/^( [a-zA-Z0-9] )+( [a-zA-Z0-9\._-] )*@( [a-zA-Z0-9_-] )+( [a-zA-Z0-9\._-] +)+$/" , $email) ){
		return false;
	}else{
		// if domain check
		if( $domainCheck ){
			// gets domain name
			list($username, $domain) = split('@',$email);
			// checks for if MX records in the DNS
			if( !checkdnsrr($domain, 'MX') ){
				return false;
			}
			// attempts a socket connection to mail server
			if( !fsockopen($domain, 25, $errno, $errstr, 30) ){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
}
*/

?>