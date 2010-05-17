<?php

/*

	This is Congif's database class

	Depends :
		PEAR/MDB2

*/

pear_load('mdb2');


class db {

	// constructor function
	function __construct($params){
		/*

			example :
				$db = new db(...);

		*/
		return db::connect($params);
	}


	// connection function
	function connect($params){
		/*

			parameters :
				dsn              <req>      Data Source Name (mysql://root:root@localhost/database_name)
				extend           <false>    Create object and extend mdb2
				cacheQueries     <false>    cache queries
				cacheTemp        <null>     cache temp directory path
				cacheCryptKey    RANDOM     cache decode (private) key

			example :
				$db = db::connect(...);

		*/

		pear_load('mdb2');

		if(!is_array($params)){
			$dsn = $params;
			unset($params);
			$params[dsn] = $dsn;
		}
		// parameter check
		if( empty( $params[dsn] ) ) return false;

		// connection with pear's mdb2
		$this->mdb2 = MDB2::factory( $params[dsn] );
		if(PEAR::isError($this->mdb2)){
			print '<pre>';
				print_r($this->mdb2);
			print '</pre>';
			exit;
			new error(array(
				'title'   => 'Database Connection Error',
				'message' => 'An error occured when trying to connect database.<br> Check your connection settings.',
				'details' => $this->mdb2->getMessage()
			));
		}

		// setting fetch mode
		$this->mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
		// setting charset
		$this->mdb2->query("SET NAMES 'UTF8'");
		// load extended if has request
		if($params[extend]){
			$this->mdb2->loadModule('Extended'); // auto statements
			$this->mdb2e = $this->mdb2->extended;
		}

		// quote object
		$this->quote = new db_quote($this->mdb2);

		return true;
	}


	// database disconnector
	function disconnect(){
		$this->mdb2->disconnect();
	}
	function free(){
		$this->disconnect();
	}


	// query function
	function query($params){
		/*

			parameters :
				type        query type (possibilities : select/insert/update/delete)
				table       table name
				select      select fields (default *)
				fields      insert fields // if "values" is an array, this variable will be ignored
				values      insert data string or array('field'=>'value')
				set         update query's set section // string or array (array like insert data)
				where       where section without "where" keyword
				              it can be string or array. (if array it will be "and")
				order       order by string/array
				limit       limit string/array


			example :
				// select sql
				$db->query(array(
						'type'   => 'select',
						'table'  => 'users',
						'select' => '*',
						'where'  => array('id' => 5),          // same as 'id = 5' string
						'order'  => array('date' => 'desc'),   // same as 'date desc' string
						'limit'  => array(100, 15)             // same as '100, 15' string
					));

				// insert sql
				$db->query(array(
						'type'   => 'insert',
						'table'  => 'content',
						'values' => array(
										'title'   => "'Baslik'",
										'content' => '"asd asd ' . time() .'"',
										'update'  => 'now()'
									)
					));

				// delete sql
				$db->query(array(
						'type'   => 'delete',
						'table'  => 'content',
						'where'  => array('id' => 10)
					));

			or use simply :
				$db->query("select * from users where ... order by ...");

		*/


		if( is_array($params) ){
			// preparing rules
				// type
				$type = $params[type];
				if( !in_array($type, explode(' ', 'select insert update delete')) ) return false;
				$queryParams[type]   = $type;
				// table name
				$queryParams[table]  = $params[table];
				// select
				$queryParams[select] = (is_array($params[select]) ? implode(',', $params[select]) : $params[select]);
				// insert
				$queryParams[fields] = $params[fields];
				$queryParams[values] = $params[values];
				// update
				$queryParams[set]    = $params[set];
				// where
				if( is_array($params[where]) ){
					$where = array();
					foreach ($params[where] as $key => $val)  $where[] = "`$key` = '$val'";
					$where = trim( implode(' and ', $where) );
				}else{
					$where = $params[where];
				}
				$queryParams[where] = $where;
				// order
				if( is_array($params[order]) ){
					$order = array();
					foreach ($params[order] as $key => $val)  $order[] = "`$key` $val";
					$order = trim( implode(', ', $order) );
				}else{
					$order = $params[order];
				}
				$queryParams[order] = $order;
				// limit
				$queryParams[limit] = (is_array($params[limit]) ? $params[limit][0]. ', '. $params[limit][1] : $params[limit]);

			// build query
				$SQL = $this->buildQuery($queryParams);

		}else{
			$SQL = $params;
			if( substr(strtolower($params), 0, 6) == 'select' ) $type = 'select';
		}


		// searching for cache
			if( 
				$this->cacheQueries and
				$type == 'select' and 
				false  // found in cache --------------------------
			){
				// found in cache,
				// return decoded and unserialized
				// data array
				// $result = ...
			}else{
				// running query
					$query = $this->run($SQL);

				// generating result array
					$result = array();
					// if query is select (return result array)
					if( $type == 'select' ){
						$result[results] = $query->fetchAll();
						$result[count]   = count($result[results]);
					}

					// if insert adding insertId to result array
					if( $type == 'insert' ){
						$result[insertId] = $this->mdb2->lastInsertID();
					}

					if( $type == 'update' || $type == 'delete' ){
						$result = true;
					}

				// caching if caching enabled
					if( $type == 'select' and $this->cacheQueries ){
						// encoding result set and caching
					}

				// free the resultset
					$query->free();

			}

		// returning result array
			return $result;
	}


	// execute query
	function run($query){
		// running query
		$result = $this->mdb2->query($query);
		// error handling
		if(PEAR::isError($result)){
			new error(array(
				'title'   => 'Query Error',
				'message' => 'An error occured when running a query.<br> Check your query structure.<br>' . $query,
				'details' => $result->getMessage()
			));
		}
		// returning result
		return $result;
	}


	// build sql from query array
	function buildQuery($params){
		$type = $params[type];

		// templates
		switch ($type) {
			case "select": {
				$template = 'SELECT __select__ FROM __table__ __where__ __order__ __limit__';
				break;
			}
			case "insert": {
				$template = 'INSERT INTO __table__ __fields__ VALUES (__values__)';
				break;
			}
			case "update": {
				$template = 'UPDATE __table__ SET __set__ __where__ __limit__';
				break;
			}
			case "delete": {
				$template = 'DELETE FROM __table__ __where__ __limit__';
				break;
			}
			default: {
				return false;
				break;
			}
		}

		// preparing template variables
		$SQL = str_replace('__table__', "`$params[table]`", $template);
		$SQL = str_replace('__where__', (empty($params[where]) ? '' : " WHERE $params[where]" ), $SQL);
		$SQL = str_replace('__order__', (empty($params[order]) ? '' : " ORDER BY $params[order]" ), $SQL);
		$SQL = str_replace('__limit__', (empty($params[limit]) ? '' : " LIMIT $params[limit]" ), $SQL);

		// special injections
		switch ($type) {
			case "select": {
				$SQL = str_replace('__select__', $params[select], $SQL);
				break;
			}
			case "insert": {
				if( empty($params[fields]) ){
					unset($fields, $values);
					if( is_array($params[values]) ){
						foreach ($params[values] as $key => $val){
							if( !is_int($key) ) $fields[] = "`$key`";
							$values[] = $val;
						}
						$fields = @implode(', ', $fields);
						$values = implode(', ', $values);
					}else{
						$values = $params[values];
					}
				}else{
					if( is_array($params[fields]) ){
						foreach ($params[fields] as $value) $fields[] = "`$value`";
						$fields = implode(', ', $fields);
					}else{
						$fields = $params[fields];
					}
					if( is_array($params[values]) ){
						$values = implode(', ', $params[values]);
					}else{
						$values = $params[values];
					}
				}
				if( !empty($fields) ) $fields = "($fields)";
				
				$SQL = str_replace('__fields__', $fields, $SQL);
				$SQL = str_replace('__values__', $values, $SQL);
				break;
			}
			case "update": {
				$SQL = str_replace('__set__', $params[set], $SQL);
				break;
			}
		}

		// ENDING
		$SQL .= ';';
		// result
		return $SQL;

	}


	// get one row
	function get($params){
		/*

			parameters :
				table, select, where

			example :
				$db->get(array('table' => 'users', 'where' => 'id = 5'));

		*/


		// running sql
		$row = $this->query(array(
			'type'   => 'select',
			'select' => (empty($params[select]) ? '*' : $params[select]),
			'table'  => $params[table],
			'where'  => $params[where]
		));

		// control
		if( empty($row[results][0]) ) return false;
		// return one row
		return $row[results][0];
	}
	// get alias
	function one($params){
		return $this->get($params);
	}


	// get all results
	function all($params){
		/*

			parameters :
				table, select, where, order

			example :
				$db->all(array('table' => 'users'));

		*/

		// if one parameter
		if( !is_array($params) ) $params = array('table'=> $params);

		// running sql
		$row = $this->query(array(
			'type'   => 'select',
			'select' => (empty($params[select]) ? '*' : $params[select]),
			'table'  => $params[table],
			'order'  => $params[order],
			'where'  => $params[where],
			'limit'  => $params[limit]
		));

		// control
		if( count($row[results]) == 0 ) return false;
		// return only result set
		return $row[results];
	}
	// all alias
	function getAll($params){
		return $this->all($params);
	}
	function getList($params){
		return $this->all($params);
	}


	// pagination list function
	function paged($params){
		/*
			example :
				$db->paged(array(
						'table' => 'users',
						'where' => 'active = 1',
						'order' => 'username asc'
					));
		*/
		$result = array();

		// page limit
		if( !$params[pageLimit] ) $params[pageLimit] = 20;

		// getting row count
		$count = $this->one(array(
				'table'  => $params[table],
				'select' => 'count(1) as rowcount',
				'where'  => $params[where]
			));
		if( !$count || $count[rowcount] == 0 ) return false;
		$result[count] = $count[rowcount];

		// calculating page count
		$result[pageCount] = ceil($result[count] / $params[pageLimit]);
		$result[pageLimit] = $params[pageLimit];

		// is page number valid
		if( $params[page] < 1 || $params[page] > $result[pageCount] ){
			$result[page] = 1;
		}else{
			$result[page] = $params[page];
		}

		// generating limit
		$start = ($result[page]-1)*$result[pageLimit];
		$limit = $start .', '. $result[pageLimit];

		// getting rows
		$rows = $this->all(array(
				'table'  => $params[table],
				'select' => $params[select],
				'where'  => $params[where],
				'order'  => $params[order],
				'limit'  => $limit
			));
		$result[results] = $rows;

		// return results
		return $result;
	}


	// insert autoexecuter
	function insert($table, $data, $dontAutoQuote = false){
		/*

			example :
				$db->insert('users', array(
						'username'      => 'fatih',
						'password'      => md5('12345'),
						'register_date' => date('Y-m-d')
					));

		*/

		// control
		if( empty($table) || empty($data)) return false;

		// autoquoting
		if( !$dontAutoQuote ){
			$data = $this->autoQuote($table, $data);
		}

		// calling query
		return $this->query(array(
				'type'   => 'insert',
				'table'  => $table,
				'values' => $data
			));
	}
	// insert alias
	function add($table, $data, $dontAutoQuote = false){
		return $this->insert($table, $data, $dontAutoQuote);
	}


	// update autoexecuter
	function update($table, $data, $where, $dontAutoQuote = false){
		/*

			example :
				$db->update('users', array(
						'password' => md5('0000'),
					), 'id = 10');

		*/

		// control
		if( empty($table) || empty($data)) return false;

		// autoquoting
		if( !$dontAutoQuote ){
			$data = $this->autoQuote($table, $data);
		}

		// generating set string
		$set = array();
		foreach ($data as $key => $val){
			$set[] = "`$key` = $val";
		}
		$set = implode(', ', $set);

		// calling query
		return $this->query(array(
				'type'  => 'update',
				'table' => $table,
				'set'   => $set,
				'where' => $where
			));
	}


	// delete autoexecuter
	function delete($table, $where){
		/*

			example :
				$db->delete('users', 'id = 10');

		*/

		// control
		if( empty($table) || empty($where)) return false;

		// calling query
		return $this->query(array(
				'type'  => 'delete',
				'table' => $table,
				'where' => $where
			));
	}
	// delete alias
	function del($table, $where){
		return $this->delete($table, $where);
	}


	// quote function
	function quote($value, $type){
		return $this->mdb2->quote($value, $type);
	}


	// autoquote function
	function autoQuote($table, $data){
		// if table fields cached
		$fields = $this->tableStructure($table);

		// quoting variables
		foreach ($data as $key => $val){
			if( $fields[$key] ){ // if data type is recognized
				// quoting with that data type
				$data[ $key ] = $this->quote($val, $fields[$key]);
			}
		}

		// returning quoted data array
		return $data;
	}


	// getting table structure
	function tableStructure($table){
		global $C;
		// if fields cached ?
		if( $C[db][cache][fields][$table] ){
			$fields = $C[db][cache][fields][$table];
		}else{
			// fields
			$query = $this->run("select * from `$table` limit 0, 1");

			// fields
			for ($i = 0; $i < $query->numCols(); $i++) {
				$name = mysql_field_name($query->result, $i);
				$typ  = mysql_field_type($query->result, $i);
				switch ($typ) {
					case "int": {
						$type = 'integer';
						break;
					}
					case "string": {
						$type = 'text';
						break;
					}
					case "decimal":
					case "real": {
						$type = 'decimal';
						break;
					}
					default: {
						$type = $typ;
						break;
					}
				}
				// if type converted
				if( $type ){
					$fields[ $name ] = $type;
				}
			}

			// caching
			$C[db][cache][fields][$table] = $fields;
		}

		// returning result
		return $fields;
	}


	// adding fancy quotes to field names
	function cleanNames($names){
		// creating array
		if( !is_array($names) ){
			if( strpos($names, ',') == -1 ){
				$names[0] = $names;
			}else{
				$names = explode(',', $names);
			}
		}
		if( !$names ) return false;

		// cleaning / trimming quotes
		$cleaned_names = array();
		foreach ($names as $name){
			$name = trim($name);
			$name = str_replace('"', '', $name);
			$name = str_replace("'", '', $name);
			$name = str_replace('`', '', $name);
			$name = str_replace('´', '', $name);
			$name = trim($name);
			if( !empty($name) )  $cleaned_names[] = '`'. $name .'`';
		}
		// returning
		return $cleaned_names;
	}


}


// quote class
class db_quote {

	/*

		quote types
			integer, decimal, float, text, date, boolean,

		example :
			$db->quote->int($val);

	*/

	function __construct($mdb2){
		$this->mdb2 = $mdb2;
	}

	function int($val){
		return $this->mdb2->quote($val, 'integer');
	}

	function text($val){
		return $this->mdb2->quote($val, 'text');
	}

}


?>