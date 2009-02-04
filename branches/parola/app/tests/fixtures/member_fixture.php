<?php 
/* SVN FILE: $Id$ */
/* Member Fixture generated on: 2008-09-25 23:09:16 : 1222376356*/

class MemberFixture extends CakeTestFixture {
	var $name = 'Member';
	var $table = 'members';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'uye_no' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
			'tckimlikno' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 11, 'key' => 'index'),
			'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'lastname' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'gender' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 1),
			'date_of_birth' => array('type'=>'date', 'null' => true, 'default' => NULL),
			'lotr_alias' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 65, 'key' => 'index'),
			'password' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'members_unique1' => array('column' => 'uye_no', 'unique' => 1), 'members_unique2' => array('column' => 'tckimlikno', 'unique' => 0), 'members_unique3' => array('column' => 'lotr_alias', 'unique' => 0))
			);
	var $records = array(array(
			'id'  => 1,
			'uye_no'  => 1,
			'tckimlikno'  => 'Lorem ips',
			'name'  => 'Lorem ipsum dolor sit amet',
			'lastname'  => 'Lorem ipsum dolor sit amet',
			'gender'  => 'Lorem ipsum dolor sit ame',
			'date_of_birth'  => '2008-09-25',
			'lotr_alias'  => 'Lorem ipsum dolor sit amet',
			'password'  => 1
			));
}
?>