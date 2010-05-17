<?php

/*

	Congif's html essentials class

*/


class html {

	// html template function
	function __construct($params){
		/*

			example :
				$html = new html(array(
					'title' => 'Hey',
					'css'   => array(
						'style.css',
						'form.css',
						'page.css'
					),


					ayni sekilde js,
					meta,
					template
					template parametreleri gibi
					olaylar olacak

				));

		*/
	}


	// pagination template
	function pages($params){
		/*
			example :
				print html::pages(array(
					'class' => 'clean',  // clean, flickr, digg
					'page'  => 2,        // current page
					'count' => 10,       // total page count
					'all'   => true      // disabling complex mode
				));
		*/

		// setting params
		$defaults = array(
			'page'     => 1,
			'all'      => false,
			'link'     => '?page=__PAGE__',
			// display parameters
			'class'    => 'clean',
			'previous' => '&laquo; Previous',
			'next'     => 'Next &raquo;',
			'dots'     => '&hellip;', // triple dots
			// aClass, liClass
		);
		$params = setParams($params, $defaults);

		if( $params[count] > 1 ){
			$output = '<ul class="pagination '. $params["class"] .'">';

				// previous page link
					if( $params[page] > 1 ){
						$previousLink  = str_replace('__PAGE__', ($params[page] - 1), $params[link]);
						$previous      = '<a href="'. $previousLink .'">'. $params[previous] .'</a>';
						$previousClass = 'previous';
					}else{
						$previous      = $params[previous];
						$previousClass = 'previous-off';
					}
					// previous output
					$output .= '<li class="'. $previousClass . '">'. $previous .'</li>'."\n";


				// page links
					$beforeDots = true;
					$afterDots  = true;
					for ($i=1; $i < $params[count]+1; $i++){ 
						// control variables
						$ctrlMinimum = ($params[count] < 10);                                     // less than 10 pages, printing all page links
						$ctrlFirst   = ($i < 3);                                                  // showing first 2 pages always
						$ctrlLast    = ($i > ($params[count]-2));                                 // showing last 2 pages always
						$ctrlAround  = ( $i > ($params[page]-3) && $i < ($params[page]+3) );      // previous 2 and next 2 page links

						// link
						$link = str_replace('__PAGE__', $i, $params[link]);

						// print?
						if( $ctrlMinimum || $ctrlFirst || $ctrlLast || $ctrlAround || $params[all] ){
							// printing normal
							if( $i == $params[page] ){
								$output .= '<li class="active">'. $i .'</li>';
							}else{
								$output .= '<li><a href="'. $link .'">'. $i .'</a></li>';
							}
						}else{
							if( !$ctrlFirst && $i <= ($params[page]-3) && $beforeDots ){
								$output .= '<li class="dots">'. $params[dots] .'</li>';
								$beforeDots = false;
							}
							if( !$ctrlLast && $i >= ($params[page]+3) && $afterDots ){
								$output .= '<li class="dots">'. $params[dots] .'</li>';
								$afterDots = false;
							}
						}
					}


				// next page link
					if( $params[page] < $params[count] ){
						$nextLink  = str_replace('__PAGE__', ($params[page] + 1), $params[link]);
						$next      = '<a href="'. $nextLink .'">'. $params[next] .'</a>';
						$nextClass = 'next';
					}else{
						$next      = $params[next];
						$nextClass = 'next-off';
					}
					// next output
					$output .= '<li class="'. $nextClass . '">'. $next .'</li>'."\n";

			$output .= '</ul>';
		}

		// result
		if( $params["return"] ){
			return $output;
		}else{
			print $output;
		}
	}


	// array to select input
	function select( $array, $attr = false, $selected = false){
	  print '<select'. ( $attr ? ' '. $attr : '' ) .'>'."\n";
	    foreach ($array as $key => $value){
	      print '<option value="'. $key .'"'.( $key == $selected ? ' selected="selected"':'' ).'>'. $value .'</option>'."\n";
	    }
	  print '</select>';
	}


}

?>