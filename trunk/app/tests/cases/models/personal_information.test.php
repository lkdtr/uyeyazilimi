<?php 
/* SVN FILE: $Id$ */
/* PersonalInformation Test cases generated on: 2008-09-26 00:09:31 : 1222376731*/
App::import('Model', 'PersonalInformation');

class TestPersonalInformation extends PersonalInformation {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class PersonalInformationTestCase extends CakeTestCase {
	var $PersonalInformation = null;
	var $fixtures = array('app.personal_information', 'app.member');

	function start() {
		parent::start();
		$this->PersonalInformation = new TestPersonalInformation();
	}

	function testPersonalInformationInstance() {
		$this->assertTrue(is_a($this->PersonalInformation, 'PersonalInformation'));
	}

	function testPersonalInformationFind() {
		$results = $this->PersonalInformation->recursive = -1;
		$results = $this->PersonalInformation->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PersonalInformation' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>