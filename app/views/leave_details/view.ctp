<div class="leaveDetails view">
<h2><?php  __('LeaveDetail');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $leaveDetail['LeaveDetail']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($leaveDetail['Member']['name'], array('controller'=> 'members', 'action'=>'view', $leaveDetail['Member']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $leaveDetail['LeaveDetail']['leave_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Decision Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $leaveDetail['LeaveDetail']['leave_decision_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Decision Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $leaveDetail['LeaveDetail']['leave_decision_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Note'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $leaveDetail['LeaveDetail']['note']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit LeaveDetail', true), array('action'=>'edit', $leaveDetail['LeaveDetail']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete LeaveDetail', true), array('action'=>'delete', $leaveDetail['LeaveDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $leaveDetail['LeaveDetail']['id'])); ?> </li>
		<li><?php echo $html->link(__('List LeaveDetails', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New LeaveDetail', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
