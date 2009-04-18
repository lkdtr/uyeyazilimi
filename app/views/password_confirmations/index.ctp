<div class="passwordConfirmations index">
<h2><?php __('PasswordConfirmations');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('account_id');?></th>
	<th><?php echo $paginator->sort('hash');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($passwordConfirmations as $passwordConfirmation):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $passwordConfirmation['PasswordConfirmation']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($passwordConfirmation['Account']['id'], array('controller'=> 'accounts', 'action'=>'view', $passwordConfirmation['Account']['id'])); ?>
		</td>
		<td>
			<?php echo $passwordConfirmation['PasswordConfirmation']['hash']; ?>
		</td>
		<td>
			<?php echo $passwordConfirmation['PasswordConfirmation']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $passwordConfirmation['PasswordConfirmation']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $passwordConfirmation['PasswordConfirmation']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $passwordConfirmation['PasswordConfirmation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $passwordConfirmation['PasswordConfirmation']['id'])); ?>
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
		<li><?php echo $html->link(__('New PasswordConfirmation', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Accounts', true), array('controller'=> 'accounts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Account', true), array('controller'=> 'accounts', 'action'=>'add')); ?> </li>
	</ul>
</div>
