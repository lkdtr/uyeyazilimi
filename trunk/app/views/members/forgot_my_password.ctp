<h2>Şifremi Unuttum</h2>
<p>Eğer şifrenizi unuttuysanız bu sayfa aracılığıyla yeni bir şifre talebinde bulunabilirsiniz. 
<strong>isim.soyisim@linux.org.tr</strong> şeklindeki LKD eposta adresinizin sadece <strong>isim.soyisim</strong> kısmını giriniz. Eposta adresinize bir doğrulama mesajı
gönderilecektir. Bu mesajdaki bağlantıyı tıkladığınızda yeni şifreniz oluşturularak eposta adresinize gönderilecektir.</p>
<p>Eğer ilk defa üye sistemine giriş yapmak istiyorsanız ve ilk defa şifre alacaksanız <?php echo $html->link('bu sayfayı kullanınız',array('controller'=>'members','action'=>'new_member')) ?>.</p>
<?php
	echo $form->create('Member', array('action' => 'forgot_my_password'));     
	echo $form->input('lotr_alias',array('label'=>"<strong>isim.soyisim@linux.org.tr</strong> şeklindeki LKD eposta adresinizin sadece <strong>isim.soyisim</strong> kısmını giriniz.",'after'=>'@linux.org.tr'));     
	echo $form->end('Yeni Şifre Talebi Gönder'); 
?> 
