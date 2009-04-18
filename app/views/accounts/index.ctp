<div class="accounts index">
<h2><?php __('Accounts');?></h2>
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
	<th><?php echo $paginator->sort('lotr_alias');?></th>
	<th><?php echo $paginator->sort('password');?></th>
	<th><?php echo $paginator->sort('active');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($accounts as $account):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $account['Account']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($account['Member']['name'], array('controller'=> 'members', 'action'=>'view', $account['Member']['id'])); ?>
		</td>
		<td>
			<?php echo $account['Account']['lotr_alias']; ?>
		</td>
		<td>
			<?php echo $account['Account']['password']; ?>
		</td>
		<td>
			<?php echo $account['Account']['active']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $account['Account']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $account['Account']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $account['Account']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $account['Account']['id'])); ?>
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
		<li><?php echo $html->link(__('New Account', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Password Confirmations', true), array('controller'=> 'password_confirmations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Password Confirmation', true), array('controller'=> 'password_confirmations', 'action'=>'add')); ?> </li>
	</ul>
</div>
