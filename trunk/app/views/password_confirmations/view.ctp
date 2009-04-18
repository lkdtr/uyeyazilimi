<div class="passwordConfirmations view">
<h2><?php  __('PasswordConfirmation');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $passwordConfirmation['PasswordConfirmation']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Account'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($passwordConfirmation['Account']['id'], array('controller'=> 'accounts', 'action'=>'view', $passwordConfirmation['Account']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hash'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $passwordConfirmation['PasswordConfirmation']['hash']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $passwordConfirmation['PasswordConfirmation']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit PasswordConfirmation', true), array('action'=>'edit', $passwordConfirmation['PasswordConfirmation']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete PasswordConfirmation', true), array('action'=>'delete', $passwordConfirmation['PasswordConfirmation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $passwordConfirmation['PasswordConfirmation']['id'])); ?> </li>
		<li><?php echo $html->link(__('List PasswordConfirmations', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New PasswordConfirmation', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Accounts', true), array('controller'=> 'accounts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Account', true), array('controller'=> 'accounts', 'action'=>'add')); ?> </li>
	</ul>
</div>
