<div class="members index">
<h2><?php __('Members');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('uye_no');?></th>
	<th><?php echo $paginator->sort('tckimlikno');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('lastname');?></th>
	<th><?php echo $paginator->sort('gender');?></th>
	<th><?php echo $paginator->sort('date_of_birth');?></th>
	<th><?php echo $paginator->sort('member_type');?></th>
	<th><?php echo $paginator->sort('member_card_status');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($members as $member):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $member['Member']['id']; ?>
		</td>
		<td>
			<?php echo $member['Member']['uye_no']; ?>
		</td>
		<td>
			<?php echo $member['Member']['tckimlikno']; ?>
		</td>
		<td>
			<?php echo $member['Member']['name']; ?>
		</td>
		<td>
			<?php echo $member['Member']['lastname']; ?>
		</td>
		<td>
			<?php echo $member['Member']['gender']; ?>
		</td>
		<td>
			<?php echo $member['Member']['date_of_birth']; ?>
		</td>
		<td>
			<?php echo $member['Member']['member_type']; ?>
		</td>
		<td>
			<?php echo $member['Member']['member_card_status']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $member['Member']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $member['Member']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $member['Member']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $member['Member']['id'])); ?>
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
		<li><?php echo $html->link(__('New Member', true), array('action'=>'add')); ?></li>
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
