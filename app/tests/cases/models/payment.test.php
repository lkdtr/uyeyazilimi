<?php 
/* SVN FILE: $Id$ */
/* Payment Test cases generated on: 2009-04-18 10:04:12 : 1240041312*/
App::import('Model', 'Payment');

class PaymentTestCase extends CakeTestCase {
	var $Payment = null;
	var $fixtures = array('app.payment', 'app.member');

	function startTest() {
		$this->Payment =& ClassRegistry::init('Payment');
	}

	function testPaymentInstance() {
		$this->assertTrue(is_a($this->Payment, 'Payment'));
	}

	function testPaymentFind() {
		$this->Payment->recursive = -1;
		$results = $this->Payment->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Payment' => array(
			'id'  => 1,
			'member_id'  => 1,
			'amount'  => 1,
			'payment_date'  => '2009-04-18',
			'receipt_number'  => 'Lorem ipsum d',
			'note'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>