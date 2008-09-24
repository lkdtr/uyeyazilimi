<br/>&nbsp;<br/>
<strong>isim.soyisim@linux.org.tr</strong> şeklindeki kullanıcı adınızı giriniz.
<?php
if  ($session->check('Message.auth')) $session->flash('auth');     
echo $form->create('User', array('action' => 'newuser'));     
echo $form->input('username');     
echo $form->end('Şifremi Gönder!'); 
?> 
