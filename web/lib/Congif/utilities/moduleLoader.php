<?php

// module file loader
function moduleLoader($params){
	/*
		example :
			$content = moduleLoader(array(
					'module'  => $_GET['module'],
					'allowed' => 'home contact about settings login register',
					'default' => 'home',
					'dir'     => 'modules',
					'return'  => true,
				));

			additional params
				returnError = false;

	*/

	// defaults
	if( !isset($params['return']) ) $params['return'] = true;

	// globalling all variables
	extract($GLOBALS);


	// if allowed module
	if( $params[allowed] ){
		// if not an array
		if( !is_array($params[allowed]) ) $params[allowed] = explode(' ', $params[allowed]);
		if( $params[module] ){
			// if not exists
			if( !in_array($params[module], $params[allowed]) ){
				$params[module] = $params['default'];
				//$moduleLoaderError = 'Module not allowed';
			}
		}else{
			$params[module] = $params['default'];
		}
	}
	// still empty?
	if( empty($params[module]) ) return false;

	// file control
	$moduleFile = rtrim($params[dir], '/') .'/'. $params[module] .'.php';
	if( !file_exists($moduleFile) ){
		$moduleLoaderError = 'Module file not exists';
	}

	// exporting module variable
	$GLOBALS[module] = $params[module];

	// if there is an error
	if( $moduleLoaderError ){
		if( $params[returnError] ){
			return $moduleLoaderError;
		}else{
			new error($moduleLoaderError);
		}
	}

	// loading module
	if( $params['return'] ){
		// caching content
		ob_start();
		require($moduleFile);
		$Content = ob_get_contents();
		ob_end_clean();
		// returning content
		return $Content;
	}else{
		require($moduleFile);
	}

}

?>
