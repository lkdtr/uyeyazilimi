<?php 
/* SVN FILE: $Id$ */
/* PersonalInformation Fixture generated on: 2008-09-26 00:09:31 : 1222376731*/

class PersonalInformationFixture extends CakeTestFixture {
	var $name = 'PersonalInformation';
	var $table = 'personal_informations';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'member_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
			'email' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'email_2' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'address' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
			'city' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
			'country' => array('type'=>'string', 'null' => true, 'default' => 'Türkiye', 'length' => 60),
			'home_number' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 25),
			'mobile_number' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 25),
			'work_number' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 25),
			'current_school_company' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'contact_information_FKIndex1' => array('column' => 'member_id', 'unique' => 0))
			);
	var $records = array(array(
			'id'  => 1,
			'member_id'  => 1,
			'email'  => 'Lorem ipsum dolor sit amet',
			'email_2'  => 'Lorem ipsum dolor sit amet',
			'address'  => 'Lorem ipsum dolor sit amet',
			'city'  => 'Lorem ipsum dolor sit amet',
			'country'  => 'Lorem ipsum dolor sit amet',
			'home_number'  => 'Lorem ipsum dolor sit a',
			'mobile_number'  => 'Lorem ipsum dolor sit a',
			'work_number'  => 'Lorem ipsum dolor sit a',
			'current_school_company'  => 'Lorem ipsum dolor sit amet'
			));
}
?>