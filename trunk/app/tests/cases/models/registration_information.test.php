<?php 
/* SVN FILE: $Id$ */
/* RegistrationInformation Test cases generated on: 2008-09-26 00:09:18 : 1222376538*/
App::import('Model', 'RegistrationInformation');

class TestRegistrationInformation extends RegistrationInformation {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class RegistrationInformationTestCase extends CakeTestCase {
	var $RegistrationInformation = null;
	var $fixtures = array('app.registration_information', 'app.member');

	function start() {
		parent::start();
		$this->RegistrationInformation = new TestRegistrationInformation();
	}

	function testRegistrationInformationInstance() {
		$this->assertTrue(is_a($this->RegistrationInformation, 'RegistrationInformation'));
	}

	function testRegistrationInformationFind() {
		$results = $this->RegistrationInformation->recursive = -1;
		$results = $this->RegistrationInformation->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('RegistrationInformation' => array(
			'id'  => 1,
			'member_id'  => 1,
			'registration_year'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.',
			'registration_decision_number'  => 1,
			'registration_decision_date'  => '2008-09-26',
			'photos_for_documents'  => 1,
			'registration_form'  => 1,
			'notes'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.'
			));
		$this->assertEqual($results, $expected);
	}
}
?>