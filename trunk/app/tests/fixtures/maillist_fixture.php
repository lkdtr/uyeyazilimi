<?php 
/* SVN FILE: $Id$ */
/* Maillist Fixture generated on: 2009-04-18 11:04:44 : 1240041704*/

class MaillistFixture extends CakeTestFixture {
	var $name = 'Maillist';
	var $table = 'maillists';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'maillist_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'maillist_address' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'maillist_description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'maillist_name'  => 'Lorem ipsum dolor sit amet',
		'maillist_address'  => 'Lorem ipsum dolor sit amet',
		'maillist_description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>