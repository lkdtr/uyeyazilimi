<div class="maillists form">
<?php echo $form->create('Maillist');?>
	<fieldset>
 		<legend><?php __('Edit Maillist');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('maillist_name');
		echo $form->input('maillist_address');
		echo $form->input('maillist_description');
		echo $form->input('Member');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Maillist.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Maillist.id'))); ?></li>
		<li><?php echo $html->link(__('List Maillists', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
