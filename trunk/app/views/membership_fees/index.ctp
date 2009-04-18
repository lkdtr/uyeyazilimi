<div class="membershipFees index">
<h2><?php __('MembershipFees');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('fee_year');?></th>
	<th><?php echo $paginator->sort('yearly_fee_amount');?></th>
	<th><?php echo $paginator->sort('enterence_fee');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($membershipFees as $membershipFee):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $membershipFee['MembershipFee']['id']; ?>
		</td>
		<td>
			<?php echo $membershipFee['MembershipFee']['fee_year']; ?>
		</td>
		<td>
			<?php echo $membershipFee['MembershipFee']['yearly_fee_amount']; ?>
		</td>
		<td>
			<?php echo $membershipFee['MembershipFee']['enterence_fee']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $membershipFee['MembershipFee']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $membershipFee['MembershipFee']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $membershipFee['MembershipFee']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $membershipFee['MembershipFee']['id'])); ?>
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
		<li><?php echo $html->link(__('New MembershipFee', true), array('action'=>'add')); ?></li>
	</ul>
</div>
