<?php

/*

	Congif's multinode category class

	Depends :
		utility / nested


*/


class content{

	// content constructer
	function __construct($params = false){
		// defaults
		$this->table  = 'content';
		$this->id     = 'id';
		$this->title  = 'title';
		$this->count  = 'count';

		// setting given params
		foreach ($params as $key => $value){
			$this->$key = $value;
		}
	}


	// page content
	function get($id){
		$db = $GLOBALS[C][dbObject];
		// getting page array
		$page = $db->get(array(
			'table' => $this->table,
			'where' => array($this->id => $id)
		));
		// control
		if( !$page ) return false;
		// returning
		return $page;
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

}

?>