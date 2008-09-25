<div class="personalInformations form">
<?php echo $form->create('PersonalInformation');?>
	<fieldset>
 		<legend><?php __('Edit PersonalInformation');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('member_id');
		echo $form->input('email');
		echo $form->input('email_2');
		echo $form->input('address');
		echo $form->input('city');
		echo $form->input('country');
		echo $form->input('home_number');
		echo $form->input('mobile_number');
		echo $form->input('work_number');
		echo $form->input('current_school_company');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('PersonalInformation.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('PersonalInformation.id'))); ?></li>
		<li><?php echo $html->link(__('List PersonalInformations', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
