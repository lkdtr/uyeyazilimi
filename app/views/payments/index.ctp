<div class="payments index">
<h2><?php __('Payments');?></h2>
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
	<th><?php echo $paginator->sort('amount');?></th>
	<th><?php echo $paginator->sort('payment_date');?></th>
	<th><?php echo $paginator->sort('payment_method');?></th>
	<th><?php echo $paginator->sort('receipt_number');?></th>
	<th><?php echo $paginator->sort('note');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($payments as $payment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $payment['Payment']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($payment['Member']['name'], array('controller'=> 'members', 'action'=>'view', $payment['Member']['id'])); ?>
		</td>
		<td>
			<?php echo $payment['Payment']['amount']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['payment_date']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['payment_method']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['receipt_number']; ?>
		</td>
		<td>
			<?php echo $payment['Payment']['note']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $payment['Payment']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $payment['Payment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $payment['Payment']['id'])); ?>
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
		<li><?php echo $html->link(__('New Payment', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
