<div class="personalInformations form">
<?php echo $form->create('PersonalInformation');?>
	<fieldset>
 		<legend><?php __('Add PersonalInformation');?></legend>
	<?php
		echo $form->input('member_id');
		echo $form->input('email');
		echo $form->input('email_2');
		echo $form->input('lotr_fwd_email');
		echo $form->input('address');
		echo $form->input('city');
		echo $form->input('country');
		echo $form->input('home_number');
		echo $form->input('mobile_number');
		echo $form->input('work_number');
		echo $form->input('current_school_company');
		echo $form->input('latest_school_graduated');
		echo $form->input('latest_year_graduated');
		echo $form->input('job_assignment');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List PersonalInformations', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
