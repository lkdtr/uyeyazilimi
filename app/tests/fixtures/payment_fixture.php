<?php 
/* SVN FILE: $Id$ */
/* Payment Fixture generated on: 2009-04-18 10:04:12 : 1240041312*/

class PaymentFixture extends CakeTestFixture {
	var $name = 'Payment';
	var $table = 'payments';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'member_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'amount' => array('type'=>'float', 'null' => true, 'default' => NULL),
		'payment_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'receipt_number' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 15),
		'note' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'payments_FKIndex1' => array('column' => 'member_id', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'member_id'  => 1,
		'amount'  => 1,
		'payment_date'  => '2009-04-18',
		'receipt_number'  => 'Lorem ipsum d',
		'note'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
	));
}
?>