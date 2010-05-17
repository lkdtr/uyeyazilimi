<?php

/*

	Congif's multinode category class

	Depends :
		utility / nested


*/


class category{

	// category constructer
	function __construct($params = false){
		// required libraries
		congif('utility');
		utility('nested');

		// defaults
		$this->table  = 'categories';
		$this->parent = 'parent';
		$this->id     = 'id';
		$this->name   = 'name';
		$this->items  = 'items';

		// setting given params
		foreach ($params as $key => $value){
			$this->$key = $value;
		}
	}


	// category listing
	function all($refresh = false){
		// if cached?
		if( !$this->all || $refresh ){
			// results not cached
			$db = $GLOBALS[C][dbObject];
			// getting category list
			$list = $db->all($this->table);
			// adding id keys to array keys
			if( $list ){
				foreach ($list as $val){
					$categories[ $val[$this->id] ] = $val;
				}
			}
			// adding to cache
			$this->all = $categories;
		}
		// result
		return $this->all;
	}


	// getting category info
	function get($id = false){
		$categories = $this->all();
		return $categories[ $id ];
	}

	// nested tree function
	function tree(){
		// category array
		$categories = $this->all();
		// nesting
		$tree = nesterByParent(array(
			'data'   => $categories,
			'id'     => $this->id,
			'parent' => $this->parent,
			'items'  => $this->items
		));
		// result
		return $tree;
	}


	// selectbox
	function select($attr = '', $dontPrintOutput = false, $selectedId = false){
		$html = '<select '. $attr .'>';
			$html .= $this->selectBox($this->tree(), '', $selectedId);
		$html .= '</select>';

		// result
		if( $dontPrintOutput ) return $html;
		else print $html;
	}
	// helper
	function selectBox($tree, $prefix = '', $selectedId = false){
		$html = '';
		foreach ($tree as $category){
			$html .= '<option value="'. $category[ $this->id ] .'"'. ($category[ $this->id ] == $selectedId ? ' selected="true"':'') .'>'. $prefix . $category[ $this->name ] .'</option>';
			// if there is subitems
			if( $category[ $this->items ] ){
				$html .= $this->selectBox($category[ $this->items ], "&nbsp;&nbsp;&nbsp;&nbsp;");
			}
		}
		return $html;
	}


	// inserting new category
	function add($data){
		// adding category
		return $GLOBALS[C][dbObject]->add($this->table, $data);
	}


	// updating category info
	function update($id, $data){
		$db = $GLOBALS[C][dbObject];
		// adding category
		return $db->update($this->table, $data, $this->id . '='. $db->quote->int($id));
	}


	// deleting category (and it's contents if wanted)
	function del($id, $recursive = false){
		$db = $GLOBALS[C][dbObject];
		// recursive aciton
		if( $recursive ){
			// getting sub items's ids
			$ids = $this->subs($id);
			// adding category's id
			$ids[] = $id;
			// getting where clause
			$where = $this->id .' in ('. implode(', ', $ids) .')';
		}else{
			// only category's id in where clause
			$where = $this->id . '='. $db->quote->int($id);
		}
		// deleting category (and it contents)
		return $db->del($this->table, $where);
	}


	// finding sub categories id's
	function subs($parent = null, $array = false, $all = false){
		if(!$array) $array = $this->tree();
		if(!$array) return false;
		// searching
		$results = array();
		foreach ($array as $val){
			if( $val[ $this->parent ] == $parent || $all ){
				// found, adding to result
				$results[] = $val[ $this->id ];
				// if there is sub items
				if($val[ $this->items ]){
					$foundSubs = $this->subs($parent, $val[$this->items], true);
				}
			}else{
				// not found, but if there is subItems there can be
				if( $val[ $this->items ] ){
					$foundSubs = $this->subs($parent, $val[$this->items]);
				}
			}
			// if there is found sub items, append to results array
			if( $foundSubs ) $results = $results + $foundSubs;
		}
		if(!$results) return false;
		// cleaning reuslt array
		foreach ($results as $value){
			if( !empty($value) ) $last[] = $value;
		}
		// returning lsat results
		return $last;
	}


}

?>