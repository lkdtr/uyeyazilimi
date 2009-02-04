<h2>Yeni Şifre Oluşturma</h2>
<p>Bu sayfa aracılığıyla LKD üyelerine özel sayfalarda ve üyelik sisteminde kullanılmak üzere ilk şifrenizi 
oluşturabilirsiniz. Şifreniz bizde kayıtlı eposta adresinize gönderilecektir. Eğer daha önce şifre 
oluşturduysanız ve unuttuysanız '<?php echo $html->link('Şifremi Unuttum',array('action'=>'forgot_my_password')) ?>' sayfasından yeni şifre oluşturabilirsiniz. Bu sayfa sadece 
ilk defa şifre oluşturulurken kullanılmaktadır.</p>
<?php
	echo $form->create('Member', array('action' => 'new_member'));     
	echo $form->input('lotr_alias',array('label'=>"<strong>isim.soyisim@linux.org.tr</strong> şeklindeki LKD eposta adresinizin sadece <strong>isim.soyisim</strong> kısmını giriniz.",'after'=>'@linux.org.tr'));     
	echo $form->end('Şifremi Gönder!'); 
?> 
