<div class="members view">
<h2><?php  __('Member');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Uye No'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['uye_no']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tckimlikno'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['tckimlikno']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lastname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['lastname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gender'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['gender']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date Of Birth'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['date_of_birth']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lotr Alias'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['lotr_alias']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['member_type']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Member', true), array('action'=>'edit', $member['Member']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Member', true), array('action'=>'delete', $member['Member']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $member['Member']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Members', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Personal Informations', true), array('controller'=> 'personal_informations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Personal Information', true), array('controller'=> 'personal_informations', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Registration Informations', true), array('controller'=> 'registration_informations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Registration Information', true), array('controller'=> 'registration_informations', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Payments', true), array('controller'=> 'payments', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Payment', true), array('controller'=> 'payments', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Preferences', true), array('controller'=> 'preferences', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Preference', true), array('controller'=> 'preferences', 'action'=>'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php  __('Related Personal Informations');?></h3>
	<?php if (!empty($member['PersonalInformation'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['member_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['email'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email 2');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['email_2'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['address'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['city'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Country');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['country'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Home Number');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['home_number'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mobile Number');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['mobile_number'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Work Number');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['work_number'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Current School Company');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['current_school_company'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Edit Personal Information', true), array('controller'=> 'personal_informations', 'action'=>'edit', $member['PersonalInformation']['id'])); ?></li>
			</ul>
		</div>
	</div>
		<div class="related">
		<h3><?php  __('Related Registration Informations');?></h3>
	<?php if (!empty($member['RegistrationInformation'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['member_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Year');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['registration_year'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Decision Number');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['registration_decision_number'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Decision Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['registration_decision_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Photos For Documents');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['photos_for_documents'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Form');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['registration_form'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Notes');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationInformation']['notes'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Edit Registration Information', true), array('controller'=> 'registration_informations', 'action'=>'edit', $member['RegistrationInformation']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php __('Related Payments');?></h3>
	<?php if (!empty($member['Payment'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Member Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($member['Payment'] as $payment):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $payment['id'];?></td>
			<td><?php echo $payment['member_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'payments', 'action'=>'view', $payment['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'payments', 'action'=>'edit', $payment['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'payments', 'action'=>'delete', $payment['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $payment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Payment', true), array('controller'=> 'payments', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Preferences');?></h3>
	<?php if (!empty($member['Preference'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Member Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($member['Preference'] as $preference):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $preference['id'];?></td>
			<td><?php echo $preference['member_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'preferences', 'action'=>'view', $preference['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'preferences', 'action'=>'edit', $preference['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'preferences', 'action'=>'delete', $preference['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $preference['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Preference', true), array('controller'=> 'preferences', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
