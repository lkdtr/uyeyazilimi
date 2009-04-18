<div class="passwordConfirmations form">
<?php echo $form->create('PasswordConfirmation');?>
	<fieldset>
 		<legend><?php __('Edit PasswordConfirmation');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('account_id');
		echo $form->input('hash');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('PasswordConfirmation.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('PasswordConfirmation.id'))); ?></li>
		<li><?php echo $html->link(__('List PasswordConfirmations', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Accounts', true), array('controller'=> 'accounts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Account', true), array('controller'=> 'accounts', 'action'=>'add')); ?> </li>
	</ul>
</div>
