<div class="personalInformations index">
<h2><?php __('PersonalInformations');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('member_id');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('email_2');?></th>
	<th><?php echo $paginator->sort('address');?></th>
	<th><?php echo $paginator->sort('city');?></th>
	<th><?php echo $paginator->sort('country');?></th>
	<th><?php echo $paginator->sort('home_number');?></th>
	<th><?php echo $paginator->sort('mobile_number');?></th>
	<th><?php echo $paginator->sort('work_number');?></th>
	<th><?php echo $paginator->sort('current_school_company');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($personalInformations as $personalInformation):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $personalInformation['PersonalInformation']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($personalInformation['Member']['name'], array('controller'=> 'members', 'action'=>'view', $personalInformation['Member']['id'])); ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['email']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['email_2']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['address']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['city']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['country']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['home_number']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['mobile_number']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['work_number']; ?>
		</td>
		<td>
			<?php echo $personalInformation['PersonalInformation']['current_school_company']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $personalInformation['PersonalInformation']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $personalInformation['PersonalInformation']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $personalInformation['PersonalInformation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $personalInformation['PersonalInformation']['id'])); ?>
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
		<li><?php echo $html->link(__('New PersonalInformation', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Members', true), array('controller'=> 'members', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Member', true), array('controller'=> 'members', 'action'=>'add')); ?> </li>
	</ul>
</div>
