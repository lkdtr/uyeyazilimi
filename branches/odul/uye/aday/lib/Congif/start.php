<?php

// setting congif path
if( !$C[PATH] ) $C[PATH] = 'congif/';

// adding slash to end if not exists
if( substr($C[PATH], -1) != '/' ) $C[PATH] .= '/';


// module loader
function congif(){
	global $C;
	// getting arguments
	$modules = func_get_args();
	if( $modules ){
		foreach ($modules as $module){
			// if module is allowed
			if( in_array($module, explode(' ', 'mail db error file image auth category form random html')) ){
				$module_file = $C[PATH] . $module .'.php';
				// if exists, load
				if( file_exists($module_file) ){
					// loading file
					require_once($module_file);
					// adding loaded modules array
					$C[loadedModules][] = $module;
				}
			}
		}
	}
}


// utility function loader
function utility(){
	global $C;
	// getting arguments
	$functions = func_get_args();
	if( $functions ){
		foreach ($functions as $function){
			// if module is allowed
			if( !in_array($function, explode(' ', 'XSS nested checkEmail arrayMultiSort moduleLoader')) ) return false;
			$function_file = $C[PATH] .'utilities/'. $function .'.php';
			// if exists, load
			if( file_exists($function_file) ){
				// loading file
				require_once($function_file);
				// adding loaded utilities array
				$C[loadedUtilities][] = $function_file;
			}
		}
	}
}


// include path
function addIncludePath($path = false){
	ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $path);
}


// PEAR path setting
addIncludePath($C[PATH] .'/PEAR');


// pear loader
function pear_load($module){
	switch ($module) {
		case "mdb2": { $include = 'MDB2.php'; break; }
		default:     { return false; break; }
	}
	// loading pear module
	require_once($include);
}


// array filter / allowed
function filterParams($parameters, $allowed = false){
	if( !$allowed ) return $parameters;
	// parameter
	if( !is_array($allowed) ) $allowed = explode(' ', $allowed);
	// filtering
	$result = array();
	foreach ($parameters as $key => $value){
		if( in_array($key, $allowed) ){
			$result[ $key ] = $value;
		}
	}
	// returting filtered array
	return $result;
}


// function for preparing parameters (defaults)
function setParams($parameters, $defaults, $allowed = false){
	// setting defaults
	foreach ($defaults as $key => $value){
		// if parameter not set and default array has that
		if( !isset($parameters[$key]) && isset($defaults[$key]) ){
			$parameters[ $key ] = $defaults[ $key ];
		}
	}
	// if defined allowed
	if( $allowed ){
		$parameters = filterParams($parameters, $allowed);
	}
	// result
	return $parameters;
}


?>