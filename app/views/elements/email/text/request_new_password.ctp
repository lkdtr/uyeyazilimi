Merhaba <?php echo $member['Member']['name']; ?> <?php echo $member['Member']['lastname']; ?>,
Parolanızı unuttuğunuz için, isteğiniz üzerine bu iletiyi almış bulunuyorsunuz.
Parolanızı yenilemek için için aşağıdaki bağlantıya tıklayınız:
<?php echo $html->url(array('controller'=> 'members', 'action'=>'confirm_password_change', $hash), true) ; ?>

Yeni bir parola oluşturulup e-posta adresinize gönderilecektir.

Eğer bu iletiyi yanlışlıkla aldığınızı düşünüyorsanız aşağıdaki bağlantıya tıklayarak isteğinizi iptal edebilirsiniz veya bu iletiyi dikkate almayınız:
<?php echo $html->url(array('controller'=> 'members', 'action'=>'cancel_password_change', $hash), true) ; ?>


Linux Kullanıcıları Derneği
