<div class="membershipFees form">
<?php echo $form->create('MembershipFee');?>
	<fieldset>
 		<legend><?php __('Edit MembershipFee');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('fee_year');
		echo $form->input('yearly_fee_amount');
		echo $form->input('enterence_fee');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('MembershipFee.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('MembershipFee.id'))); ?></li>
		<li><?php echo $html->link(__('List MembershipFees', true), array('action'=>'index'));?></li>
	</ul>
</div>
