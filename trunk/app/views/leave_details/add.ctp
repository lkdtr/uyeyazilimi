<div class="leaveDetails form">
<?php echo $form->create('LeaveDetail');?>
	<fieldset>
 		<legend><?php __('Add LeaveDetail');?></legend>
	<?php
		echo $form->input('member_id');
		echo $form->input('leave_year');
		echo $form->input('leave_decision_date');
		echo $form->input('leave_decision_number');
		echo $form->input('note');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List LeaveDetails', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
