<div class="payments form">
<?php echo $form->create('Payment');?>
	<fieldset>
 		<legend><?php __('Add Payment');?></legend>
	<?php
		echo $form->input('member_id');
		echo $form->input('amount');
		echo $form->input('payment_date');
		echo $form->input('payment_method');
		echo $form->input('receipt_number');
		echo $form->input('note');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Payments', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
