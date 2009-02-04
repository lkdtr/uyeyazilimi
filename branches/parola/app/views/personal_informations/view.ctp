<div class="personalInformations view">
<h2><?php  __('PersonalInformation');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($personalInformation['Member']['name'], array('controller'=> 'members', 'action'=>'view', $personalInformation['Member']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email 2'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['email_2']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Country'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['country']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Home Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['home_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mobile Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['mobile_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Work Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['work_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Current School Company'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $personalInformation['PersonalInformation']['current_school_company']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit PersonalInformation', true), array('action'=>'edit', $personalInformation['PersonalInformation']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete PersonalInformation', true), array('action'=>'delete', $personalInformation['PersonalInformation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $personalInformation['PersonalInformation']['id'])); ?> </li>
		<li><?php echo $html->link(__('List PersonalInformations', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New PersonalInformation', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
