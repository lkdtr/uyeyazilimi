<div class="registrationDetails index">
<h2><?php __('RegistrationDetails');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('member_id');?></th>
	<th><?php echo $paginator->sort('registration_year');?></th>
	<th><?php echo $paginator->sort('registration_decision_number');?></th>
	<th><?php echo $paginator->sort('registration_decision_date');?></th>
	<th><?php echo $paginator->sort('photos_for_documents');?></th>
	<th><?php echo $paginator->sort('registration_form');?></th>
	<th><?php echo $paginator->sort('note');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($registrationDetails as $registrationDetail):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($registrationDetail['Member']['name'], array('controller'=> 'members', 'action'=>'view', $registrationDetail['Member']['id'])); ?>
		</td>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['registration_year']; ?>
		</td>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['registration_decision_number']; ?>
		</td>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['registration_decision_date']; ?>
		</td>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['photos_for_documents']; ?>
		</td>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['registration_form']; ?>
		</td>
		<td>
			<?php echo $registrationDetail['RegistrationDetail']['note']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $registrationDetail['RegistrationDetail']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $registrationDetail['RegistrationDetail']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $registrationDetail['RegistrationDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $registrationDetail['RegistrationDetail']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New RegistrationDetail', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
