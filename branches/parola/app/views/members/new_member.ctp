<h2>Yeni Parola Oluşturma</h2>
<p>Bu sayfa aracılığıyla LKD üyelerine özel alanlarda kullanılmak üzere ilk parolanızı oluşturabilirsiniz. Parolanız bizde kayıtlı e-posta adresinize gönderilecektir. Eğer daha önce parola oluşturduysanız ve unuttuysanız '<?php echo $html->link('Parolamı Unuttum',array('action'=>'forgot_my_password')) ?>' sayfasından yeni parola oluşturabilirsiniz. Bu sayfa sadece ilk kez parola oluşturulurken kullanılmaktadır.</p>
<?php
	echo $form->create('Member', array('action' => 'new_member'));     
	echo $form->input('lotr_alias',array('label'=>"ad.soyad@linux.org.tr biçimindeki LKD e-posta adresinizin sadece <strong>ad.soyad</strong> kısmını giriniz.",'after'=>'@linux.org.tr','style'=>'clear:none;float:left;width:300px;'));     
	echo $form->end('Parolamı Gönder!'); 
?> 
