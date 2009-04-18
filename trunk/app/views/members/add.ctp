<div class="members form">
<?php echo $form->create('Member');?>
	<fieldset>
 		<legend><?php __('Add Member');?></legend>
	<?php
		echo $form->input('uye_no');
		echo $form->input('tckimlikno');
		echo $form->input('name');
		echo $form->input('lastname');
		echo $form->input('Account.lotr_alias');
		echo $form->input('gender',array('options'=>array('E'=>__('Man',true),'K'=>__('Woman',true))));
		echo $form->input('date_of_birth',array('empty'=>true));
		echo $form->input('member_type',array('options'=>array('member'=>__('Member',true),'admin'=>__('Admin',true))));
		echo $form->input('member_card_status',array('options'=>array('İstemiyor'=>'İstemiyor','İstiyor'=>'İstiyor','Güncel Adres Bekleniyor'=>'Güncel Adres Bekleniyor','Dijital Fotoğraf Bekleniyor'=>'Dijital Fotoğraf Bekleniyor','Basılacak'=>'Basılacak','Baskıya Gitti'=>'Baskıya Gitti','Postaya Verilecek'=>'Postaya Verilecek')));
	?>
	</fieldset>
	<fieldset>
 		<legend><?php __('Registration Details');?></legend>
 		<div class="input text">
 	<?php 
		//echo $form->input('RegistrationDetail.registration_year',array('type'=>'date',''));
		echo $form->label('RegistrationDetail.registration_year');
		echo $form->year('RegistrationDetail.registration_year',2000,date('Y'),null,false);
		echo $form->error('RegistrationDetail.registration_year');
	?></div>
	<?php 
		echo $form->input('RegistrationDetail.registration_decision_number');
		echo $form->input('RegistrationDetail.registration_decision_date',array('empty'=>true,'minYear'=>2000,'maxYear'=>date('Y')));
		echo $form->input('RegistrationDetail.photos_for_documents');
		echo $form->input('RegistrationDetail.registration_form');
		echo $form->input('RegistrationDetail.note');
	?>
 	</fieldset>	
	<fieldset> 	
 		<legend><?php __('Personal Information');?></legend>
 		<?php
		echo $form->input('PersonalInformation.email');
		echo $form->input('PersonalInformation.email_2');
		echo $form->input('PersonalInformation.lotr_fwd_email');
		echo $form->input('PersonalInformation.address',array('type'=>'textarea'));
		echo $form->input('PersonalInformation.city');
		echo $form->input('PersonalInformation.country',array('value'=>'Türkiye'));
		echo $form->input('PersonalInformation.home_number');
		echo $form->input('PersonalInformation.mobile_number');
		echo $form->input('PersonalInformation.work_number');
		echo $form->input('PersonalInformation.current_school_company');
		echo $form->input('PersonalInformation.job_assignment');
		echo $form->input('PersonalInformation.latest_school_graduated');?>
 		<div class="input text">
 	<?php 
		//echo $form->input('RegistrationDetail.registration_year',array('type'=>'date',''));
		echo $form->label('PersonalInformation.latest_year_graduated');
		echo $form->year('PersonalInformation.latest_year_graduated',date('Y')-80,date('Y')+1,null,false);
		echo $form->error('PersonalInformation.latest_year_graduated');
	?></div>
 	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Cancel', true), array('action'=>'index'));?></li>
	</ul>
</div>
