<div class="membershipFees view">
<h2><?php  __('MembershipFee');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $membershipFee['MembershipFee']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fee Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $membershipFee['MembershipFee']['fee_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Yearly Fee Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $membershipFee['MembershipFee']['yearly_fee_amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Enterence Fee'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $membershipFee['MembershipFee']['enterence_fee']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit MembershipFee', true), array('action'=>'edit', $membershipFee['MembershipFee']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete MembershipFee', true), array('action'=>'delete', $membershipFee['MembershipFee']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $membershipFee['MembershipFee']['id'])); ?> </li>
		<li><?php echo $html->link(__('List MembershipFees', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New MembershipFee', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
