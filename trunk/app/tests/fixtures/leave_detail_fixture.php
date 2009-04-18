<?php 
/* SVN FILE: $Id$ */
/* LeaveDetail Fixture generated on: 2009-04-18 10:04:36 : 1240041156*/

class LeaveDetailFixture extends CakeTestFixture {
	var $name = 'LeaveDetail';
	var $table = 'leave_details';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'member_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'leave_year' => array('type'=>'text', 'null' => false, 'default' => NULL, 'length' => 4),
		'leave_decision_date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'leave_decision_number' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'note' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'Table_10_FKIndex1' => array('column' => 'member_id', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'member_id'  => 1,
		'leave_year'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'leave_decision_date'  => '2009-04-18',
		'leave_decision_number'  => 1,
		'note'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>