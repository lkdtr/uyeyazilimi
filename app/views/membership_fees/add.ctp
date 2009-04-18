<div class="membershipFees form">
<?php echo $form->create('MembershipFee');?>
	<fieldset>
 		<legend><?php __('Add MembershipFee');?></legend>
	<?php
		echo $form->input('fee_year');
		echo $form->input('yearly_fee_amount');
		echo $form->input('enterence_fee');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List MembershipFees', true), array('action'=>'index'));?></li>
	</ul>
</div>
