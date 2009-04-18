<?php 
/* SVN FILE: $Id$ */
/* RegistrationDetail Fixture generated on: 2009-04-18 11:04:09 : 1240041849*/

class RegistrationDetailFixture extends CakeTestFixture {
	var $name = 'RegistrationDetail';
	var $table = 'registration_details';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'member_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'registration_year' => array('type'=>'text', 'null' => true, 'default' => NULL, 'length' => 4),
		'registration_decision_number' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'registration_decision_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'photos_for_documents' => array('type'=>'boolean', 'null' => true, 'default' => NULL),
		'registration_form' => array('type'=>'boolean', 'null' => true, 'default' => NULL),
		'note' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'membership_information_FKIndex1' => array('column' => 'member_id', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'member_id'  => 1,
		'registration_year'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'registration_decision_number'  => 1,
		'registration_decision_date'  => '2009-04-18',
		'photos_for_documents'  => 1,
		'registration_form'  => 1,
		'note'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>