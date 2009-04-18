<div class="registrationDetails form">
<?php echo $form->create('RegistrationDetail');?>
	<fieldset>
 		<legend><?php __('Edit RegistrationDetail');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('member_id');
		echo $form->input('registration_year');
		echo $form->input('registration_decision_number');
		echo $form->input('registration_decision_date');
		echo $form->input('photos_for_documents');
		echo $form->input('registration_form');
		echo $form->input('note');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('RegistrationDetail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('RegistrationDetail.id'))); ?></li>
		<li><?php echo $html->link(__('List RegistrationDetails', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
