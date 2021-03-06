<div class="leaveDetails index">
<h2><?php __('LeaveDetails');?></h2>
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
	<th><?php echo $paginator->sort('leave_year');?></th>
	<th><?php echo $paginator->sort('leave_decision_date');?></th>
	<th><?php echo $paginator->sort('leave_decision_number');?></th>
	<th><?php echo $paginator->sort('note');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($leaveDetails as $leaveDetail):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $leaveDetail['LeaveDetail']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($leaveDetail['Member']['name'], array('controller'=> 'members', 'action'=>'view', $leaveDetail['Member']['id'])); ?>
		</td>
		<td>
			<?php echo $leaveDetail['LeaveDetail']['leave_year']; ?>
		</td>
		<td>
			<?php echo $leaveDetail['LeaveDetail']['leave_decision_date']; ?>
		</td>
		<td>
			<?php echo $leaveDetail['LeaveDetail']['leave_decision_number']; ?>
		</td>
		<td>
			<?php echo $leaveDetail['LeaveDetail']['note']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $leaveDetail['LeaveDetail']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $leaveDetail['LeaveDetail']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $leaveDetail['LeaveDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $leaveDetail['LeaveDetail']['id'])); ?>
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
		<li><?php echo $html->link(__('New LeaveDetail', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
