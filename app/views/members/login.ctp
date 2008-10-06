<h2>LKD Üye Sistemine Oturum Açın</h2>
<?php
echo $form->create('Member', array('action' => 'login'));     
echo $form->input('lotr_alias',array('label'=>"<strong>isim.soyisim@linux.org.tr</strong> şeklindeki LKD eposta adresinizin sadece <strong>isim.soyisim</strong> kısmı"));     
echo $form->input('password');     
echo $form->end('Oturum Aç'); 
?> 
<div class="actions">
	<ul>
		<li><?php echo $html->link('Şifremi Unuttum', array('action'=>'forgot_my_password')); ?> </li>
		<li><?php echo $html->link('Üye Sistemine İlk Girişiniz mi? Yeni Şifre Oluşturun!', array('action'=>'new_member'));?></li>
	</ul>
</div>

