<div class="registrationInformations view">
<h2><?php  __('RegistrationInformation');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($registrationInformation['Member']['name'], array('controller'=> 'members', 'action'=>'view', $registrationInformation['Member']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['registration_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Decision Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['registration_decision_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Decision Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['registration_decision_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Photos For Documents'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['photos_for_documents']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Form'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['registration_form']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $registrationInformation['RegistrationInformation']['notes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit RegistrationInformation', true), array('action'=>'edit', $registrationInformation['RegistrationInformation']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete RegistrationInformation', true), array('action'=>'delete', $registrationInformation['RegistrationInformation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $registrationInformation['RegistrationInformation']['id'])); ?> </li>
		<li><?php echo $html->link(__('List RegistrationInformations', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New RegistrationInformation', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
