<div class="accounts form">
<?php echo $form->create('Account');?>
	<fieldset>
 		<legend><?php __('Add Account');?></legend>
	<?php
		echo $form->input('member_id');
		echo $form->input('lotr_alias');
		echo $form->input('password');
		echo $form->input('active');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Accounts', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Password Confirmations', true), array('controller'=> 'password_confirmations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Password Confirmation', true), array('controller'=> 'password_confirmations', 'action'=>'add')); ?> </li>
	</ul>
</div>
