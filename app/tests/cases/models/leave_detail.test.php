<?php 
/* SVN FILE: $Id$ */
/* LeaveDetail Test cases generated on: 2009-04-18 10:04:36 : 1240041156*/
App::import('Model', 'LeaveDetail');

class LeaveDetailTestCase extends CakeTestCase {
	var $LeaveDetail = null;
	var $fixtures = array('app.leave_detail', 'app.member');

	function startTest() {
		$this->LeaveDetail =& ClassRegistry::init('LeaveDetail');
	}

	function testLeaveDetailInstance() {
		$this->assertTrue(is_a($this->LeaveDetail, 'LeaveDetail'));
	}

	function testLeaveDetailFind() {
		$this->LeaveDetail->recursive = -1;
		$results = $this->LeaveDetail->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('LeaveDetail' => array(
			'id'  => 1,
			'member_id'  => 1,
			'leave_year'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'leave_decision_date'  => '2009-04-18',
			'leave_decision_number'  => 1,
			'note'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>