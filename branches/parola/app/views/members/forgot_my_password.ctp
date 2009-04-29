<h2>Parolamı Unuttum</h2>
<p>Eğer parolanızı unuttuysanız bu sayfa aracılığıyla yeni bir parola isteğinde bulunabilirsiniz. ad.soyad@linux.org.tr şeklindeki LKD e-posta adresinizin sadece <strong>isim.soyisim</strong> kısmını giriniz. E-posta adresinize bir doğrulama mesajı gönderilecektir. Bu mesajdaki bağlantıya tıkladığınızda yeni parolanız oluşturularak e-posta adresinize gönderilecektir.</p>
<p>Eğer ilk defa üye sistemine giriş yapmak istiyorsanız ve ilk defa parola alacaksanız <?php echo $html->link('bu sayfayı kullanınız',array('controller'=>'members','action'=>'new_member')) ?>.</p>
<?php
	echo $form->create('Member', array('action' => 'forgot_my_password'));     
	echo $form->input('lotr_alias',array('label'=>"ad.soyad@linux.org.tr şeklindeki LKD e-posta adresinizin sadece <strong>ad.soyad</strong> kısmını giriniz.",'after'=>'@linux.org.tr','style'=>'clear:none;float:left;width:300px;'));     
	echo $form->end('Yeni Parola İsteği Gönder'); 
?> 
<p>Eğer adresinize e-posta ulaşmazsa, dernek kayıtlarında eski bir e-posta adresiniz kayıtlı olabilir. Bu durumda lütfen uye@lkd.org.tr adresiyle bağlantıya geçerek iletişim bilgilerinizi güncelleyiniz.</p>
