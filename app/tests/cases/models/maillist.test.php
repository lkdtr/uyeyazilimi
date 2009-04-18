<?php 
/* SVN FILE: $Id$ */
/* Maillist Test cases generated on: 2009-04-18 11:04:44 : 1240041704*/
App::import('Model', 'Maillist');

class MaillistTestCase extends CakeTestCase {
	var $Maillist = null;
	var $fixtures = array('app.maillist');

	function startTest() {
		$this->Maillist =& ClassRegistry::init('Maillist');
	}

	function testMaillistInstance() {
		$this->assertTrue(is_a($this->Maillist, 'Maillist'));
	}

	function testMaillistFind() {
		$this->Maillist->recursive = -1;
		$results = $this->Maillist->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Maillist' => array(
			'id'  => 1,
			'maillist_name'  => 'Lorem ipsum dolor sit amet',
			'maillist_address'  => 'Lorem ipsum dolor sit amet',
			'maillist_description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>