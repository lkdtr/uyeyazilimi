<?php 
/* SVN FILE: $Id$ */
/* MembershipFee Test cases generated on: 2009-04-18 10:04:55 : 1240041415*/
App::import('Model', 'MembershipFee');

class MembershipFeeTestCase extends CakeTestCase {
	var $MembershipFee = null;
	var $fixtures = array('app.membership_fee');

	function startTest() {
		$this->MembershipFee =& ClassRegistry::init('MembershipFee');
	}

	function testMembershipFeeInstance() {
		$this->assertTrue(is_a($this->MembershipFee, 'MembershipFee'));
	}

	function testMembershipFeeFind() {
		$this->MembershipFee->recursive = -1;
		$results = $this->MembershipFee->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('MembershipFee' => array(
			'id'  => 1,
			'fee_year'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'yearly_fee_amount'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'enterence_fee'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>