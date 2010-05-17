<?php

// create nested array
function nesterByParent($params){
	/*
		example :
			nesterByParent(array(
					array('id' => 1),
					array('id' => 2, 'root' => 1),
					array('id' => 3, 'root' => 1),
					array('id' => 4, 'root' => 3)
				), 'root');

		Result will be :

			array(
					array(
						'id' => 1,
						'items' => array(
								array(
										'id' => 2
									),
								array(
										'id' => 3,
										'items' => array(
												'id' => 4
											)
									)
							))
				)

		Result in this tree :

			(1)
			 |- (2)
			 '- (3)
			     '- (4)

	*/

	// params
		if( !$params[data] )      return false;
		if( !$params[id] )        $params[id]    = 'id';
		if( !$params['parent'] )  $params['parent']  = 'parent';
		if( !$params[items] )     $params[items] = 'items';

	// id-izing array
		$data = array();
		foreach ($params[data] as $value) $data[ $value[ $params[id] ] ] = $value;

	// getting tree
		$tree = getChilds($data, '', $params);

	// result
		return $tree;
}


// nesting function
function getChilds($array, $parent = '', $params){
	$result = array();
	foreach ($array as $key => $val){
		if( $val[ $params['parent'] ] == $parent ){
			// getting that item's sub items
			unset($subItems);
			$subItems = getChilds($array, $val[ $params[id] ], $params);
			if( $subItems ) $val[ $params[items] ] = $subItems;
			// adding to result array
			$result[ $key ] = $val;
		}
	}
	return $result;
}



// get path function
// http://www.sitepoint.com/article/hierarchical-data-database/


?>