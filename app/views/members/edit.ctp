<div class="members form">
<?php echo $form->create('Member');?>
	<fieldset>
 		<legend><?php __('Edit Member');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('uye_no');
		echo $form->input('tckimlikno');
		echo $form->input('name');
		echo $form->input('lastname');
		echo $form->input('gender');
		echo $form->input('date_of_birth');
		echo $form->input('member_type');
		echo $form->input('member_card_status');
		echo $form->input('Maillist');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Member.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Member.id'))); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Accounts', true), array('controller'=> 'accounts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Account', true), array('controller'=> 'accounts', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Leave Details', true), array('controller'=> 'leave_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Leave Detail', true), array('controller'=> 'leave_details', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Personal Informations', true), array('controller'=> 'personal_informations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Personal Information', true), array('controller'=> 'personal_informations', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Registration Details', true), array('controller'=> 'registration_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Registration Detail', true), array('controller'=> 'registration_details', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Payments', true), array('controller'=> 'payments', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Payment', true), array('controller'=> 'payments', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Preferences', true), array('controller'=> 'preferences', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Preference', true), array('controller'=> 'preferences', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Maillists', true), array('controller'=> 'maillists', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Maillist', true), array('controller'=> 'maillists', 'action'=>'add')); ?> </li>
	</ul>
</div>
