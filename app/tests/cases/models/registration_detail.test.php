<?php 
/* SVN FILE: $Id$ */
/* RegistrationDetail Test cases generated on: 2009-04-18 11:04:09 : 1240041849*/
App::import('Model', 'RegistrationDetail');

class RegistrationDetailTestCase extends CakeTestCase {
	var $RegistrationDetail = null;
	var $fixtures = array('app.registration_detail', 'app.member');

	function startTest() {
		$this->RegistrationDetail =& ClassRegistry::init('RegistrationDetail');
	}

	function testRegistrationDetailInstance() {
		$this->assertTrue(is_a($this->RegistrationDetail, 'RegistrationDetail'));
	}

	function testRegistrationDetailFind() {
		$this->RegistrationDetail->recursive = -1;
		$results = $this->RegistrationDetail->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('RegistrationDetail' => array(
			'id'  => 1,
			'member_id'  => 1,
			'registration_year'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'registration_decision_number'  => 1,
			'registration_decision_date'  => '2009-04-18',
			'photos_for_documents'  => 1,
			'registration_form'  => 1,
			'note'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>