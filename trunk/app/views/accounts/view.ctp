<div class="accounts view">
<h2><?php  __('Account');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $account['Account']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($account['Member']['name'], array('controller'=> 'members', 'action'=>'view', $account['Member']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lotr Alias'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $account['Account']['lotr_alias']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $account['Account']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $account['Account']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Account', true), array('action'=>'edit', $account['Account']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Account', true), array('action'=>'delete', $account['Account']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $account['Account']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Accounts', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Account', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Password Confirmations', true), array('controller'=> 'password_confirmations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Password Confirmation', true), array('controller'=> 'password_confirmations', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Password Confirmations');?></h3>
	<?php if (!empty($account['PasswordConfirmation'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Account Id'); ?></th>
		<th><?php __('Hash'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($account['PasswordConfirmation'] as $passwordConfirmation):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $passwordConfirmation['id'];?></td>
			<td><?php echo $passwordConfirmation['account_id'];?></td>
			<td><?php echo $passwordConfirmation['hash'];?></td>
			<td><?php echo $passwordConfirmation['created'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'password_confirmations', 'action'=>'view', $passwordConfirmation['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'password_confirmations', 'action'=>'edit', $passwordConfirmation['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'password_confirmations', 'action'=>'delete', $passwordConfirmation['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $passwordConfirmation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Password Confirmation', true), array('controller'=> 'password_confirmations', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
