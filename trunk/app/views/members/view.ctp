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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['member_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Card Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $member['Member']['member_card_status']; ?>
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
		<li><?php echo $html->link(__('List Accounts', true), array('controller'=> 'accounts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Account', true), array('controller'=> 'accounts', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Leave Details', true), array('controller'=> 'leave_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Leave Detail', true), array('controller'=> 'leave_details', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Personal Informations', true), array('controller'=> 'personal_informations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Personal Information', true), array('controller'=> 'personal_informations', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Registration Details', true), array('controller'=> 'registration_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Registration Detail', true), array('controller'=> 'registration_details', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Payments', true), array('controller'=> 'payments', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Payment', true), array('controller'=> 'payments', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Preferences', true), array('controller'=> 'preferences', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Preference', true), array('controller'=> 'preferences', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Maillists', true), array('controller'=> 'maillists', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Maillist', true), array('controller'=> 'maillists', 'action'=>'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php  __('Related Accounts');?></h3>
	<?php if (!empty($member['Account'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['Account']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['Account']['member_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lotr Alias');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['Account']['lotr_alias'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['Account']['password'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['Account']['active'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Edit Account', true), array('controller'=> 'accounts', 'action'=>'edit', $member['Account']['id'])); ?></li>
			</ul>
		</div>
	</div>
		<div class="related">
		<h3><?php  __('Related Leave Details');?></h3>
	<?php if (!empty($member['LeaveDetail'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['LeaveDetail']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['LeaveDetail']['member_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Year');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['LeaveDetail']['leave_year'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Decision Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['LeaveDetail']['leave_decision_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Decision Number');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['LeaveDetail']['leave_decision_number'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Note');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['LeaveDetail']['note'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Edit Leave Detail', true), array('controller'=> 'leave_details', 'action'=>'edit', $member['LeaveDetail']['id'])); ?></li>
			</ul>
		</div>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lotr Fwd Email');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['lotr_fwd_email'];?>
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
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Latest School Graduated');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['latest_school_graduated'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Latest Year Graduated');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['latest_year_graduated'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Job Assignment');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['PersonalInformation']['job_assignment'];?>
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
		<h3><?php  __('Related Registration Details');?></h3>
	<?php if (!empty($member['RegistrationDetail'])):?>
		<dl>	<?php $i = 0; $class = ' class="altrow"';?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Member Id');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['member_id'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Year');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['registration_year'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Decision Number');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['registration_decision_number'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Decision Date');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['registration_decision_date'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Photos For Documents');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['photos_for_documents'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Registration Form');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['registration_form'];?>
&nbsp;</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Note');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	<?php echo $member['RegistrationDetail']['note'];?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $html->link(__('Edit Registration Detail', true), array('controller'=> 'registration_details', 'action'=>'edit', $member['RegistrationDetail']['id'])); ?></li>
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
		<th><?php __('Amount'); ?></th>
		<th><?php __('Payment Date'); ?></th>
		<th><?php __('Payment Method'); ?></th>
		<th><?php __('Receipt Number'); ?></th>
		<th><?php __('Note'); ?></th>
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
			<td><?php echo $payment['amount'];?></td>
			<td><?php echo $payment['payment_date'];?></td>
			<td><?php echo $payment['payment_method'];?></td>
			<td><?php echo $payment['receipt_number'];?></td>
			<td><?php echo $payment['note'];?></td>
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
<div class="related">
	<h3><?php __('Related Maillists');?></h3>
	<?php if (!empty($member['Maillist'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Maillist Name'); ?></th>
		<th><?php __('Maillist Address'); ?></th>
		<th><?php __('Maillist Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($member['Maillist'] as $maillist):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $maillist['id'];?></td>
			<td><?php echo $maillist['maillist_name'];?></td>
			<td><?php echo $maillist['maillist_address'];?></td>
			<td><?php echo $maillist['maillist_description'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'maillists', 'action'=>'view', $maillist['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'maillists', 'action'=>'edit', $maillist['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'maillists', 'action'=>'delete', $maillist['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $maillist['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Maillist', true), array('controller'=> 'maillists', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
