<?php 
/* SVN FILE: $Id$ */
/* Account Fixture generated on: 2009-04-18 10:04:40 : 1240040500*/

class AccountFixture extends CakeTestFixture {
	var $name = 'Account';
	var $table = 'accounts';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'member_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'lotr_alias' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 65),
		'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'active' => array('type'=>'boolean', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'accounts_FKIndex1' => array('column' => 'member_id', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'member_id'  => 1,
		'lotr_alias'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'active'  => 1
	));
}
?>