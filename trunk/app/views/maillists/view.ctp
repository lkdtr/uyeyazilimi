<div class="maillists view">
<h2><?php  __('Maillist');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $maillist['Maillist']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Maillist Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $maillist['Maillist']['maillist_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Maillist Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $maillist['Maillist']['maillist_address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Maillist Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $maillist['Maillist']['maillist_description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Maillist', true), array('action'=>'edit', $maillist['Maillist']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Maillist', true), array('action'=>'delete', $maillist['Maillist']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $maillist['Maillist']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Maillists', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Maillist', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Members');?></h3>
	<?php if (!empty($maillist['Member'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Uye No'); ?></th>
		<th><?php __('Tckimlikno'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Lastname'); ?></th>
		<th><?php __('Gender'); ?></th>
		<th><?php __('Date Of Birth'); ?></th>
		<th><?php __('Member Type'); ?></th>
		<th><?php __('Member Card Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($maillist['Member'] as $member):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $member['id'];?></td>
			<td><?php echo $member['uye_no'];?></td>
			<td><?php echo $member['tckimlikno'];?></td>
			<td><?php echo $member['name'];?></td>
			<td><?php echo $member['lastname'];?></td>
			<td><?php echo $member['gender'];?></td>
			<td><?php echo $member['date_of_birth'];?></td>
			<td><?php echo $member['member_type'];?></td>
			<td><?php echo $member['member_card_status'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'members', 'action'=>'view', $member['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'members', 'action'=>'edit', $member['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'members', 'action'=>'delete', $member['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $member['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
