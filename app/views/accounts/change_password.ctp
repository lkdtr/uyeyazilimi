<div class="accounts form">
<?php echo $form->create('Account',array('action'=>'change_password'));?>
	<fieldset>
 		<legend><?php __('Edit Account');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('password');
		echo $form->input('confirm_password');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Cancel', true), array('controller'=> 'members', 'action'=>'view',$this->data['Account']['member_id'])); ?> </li>
	</ul>
</div>
