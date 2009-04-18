<div class="members form">
<?php echo $form->create('Member');?>
	<fieldset>
 		<legend><?php __('Edit Member');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('uye_no');
		echo $form->input('tckimlikno');
		echo $form->input('name');
		echo $form->input('lastname');
		echo $form->input('gender',array('options'=>array('E'=>__('Man',true),'K'=>__('Woman',true))));
		echo $form->input('date_of_birth',array('empty'=>true));
		echo $form->input('member_type',array('options'=>array('member'=>__('Member',true),'admin'=>__('Admin',true))));
		echo $form->input('member_card_status',array('options'=>array('İstemiyor'=>'İstemiyor','İstiyor'=>'İstiyor','Güncel Adres Bekleniyor'=>'Güncel Adres Bekleniyor','Dijital Fotoğraf Bekleniyor'=>'Dijital Fotoğraf Bekleniyor','Basılacak'=>'Basılacak','Baskıya Gitti'=>'Baskıya Gitti','Postaya Verilecek'=>'Postaya Verilecek')));
	?>
	</fieldset>
<?php echo $form->end(__('Submit',true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Cancel', true), array('action'=>'index'));?></li>
	</ul>
</div>
