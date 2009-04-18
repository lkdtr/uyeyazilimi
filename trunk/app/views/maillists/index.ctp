<div class="maillists index">
<h2><?php __('Maillists');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('maillist_name');?></th>
	<th><?php echo $paginator->sort('maillist_address');?></th>
	<th><?php echo $paginator->sort('maillist_description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($maillists as $maillist):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $maillist['Maillist']['id']; ?>
		</td>
		<td>
			<?php echo $maillist['Maillist']['maillist_name']; ?>
		</td>
		<td>
			<?php echo $maillist['Maillist']['maillist_address']; ?>
		</td>
		<td>
			<?php echo $maillist['Maillist']['maillist_description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $maillist['Maillist']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $maillist['Maillist']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $maillist['Maillist']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $maillist['Maillist']['id'])); ?>
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
		<li><?php echo $html->link(__('New Maillist', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
