Merhaba <?php echo $account['Member']['name']; ?> <?php echo $account['Member']['lastname']; ?>,
Şifrenizi unuttuğunuz için, isteğiniz üzerine bu iletiyi almış bulunuyorsunuz.
Şifrenizi yenilemek için için aşağıdaki bağlantıya tıklayınız:
<?php echo $html->url(array('controller'=> 'accounts', 'action'=>'confirm_password_change', $hash), true) ; ?>

Yeni bir şifre oluşturulup eposta adresinize gönderilecektir.

Eğer bu iletiyi yanlışlıkla aldığınızı düşünüyorsanız aşağıdaki bağlantıya tıklayarak isteğinizi iptal edebilirsiniz veya bu iletiyi dikkate almayınız:
<?php echo $html->url(array('controller'=> 'accounts', 'action'=>'cancel_password_change', $hash), true) ; ?>


Linux Kullanıcıları Derneği
