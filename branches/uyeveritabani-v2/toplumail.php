<?php
	include ("db.php");
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritabanına bağlanamadık");
	mysql_select_db(DB) or die("seçemedi");
	$rs = mysql_query("SELECT uye_ad,uye_soyad,eposta1,PassWord FROM uyeler") or die(mysql_error());
	$mail = "Sayin __AD__ <br> Sifreniz : __SIFRE__ <br>";
	$mail.="Lütfen YENI Üye Sisteminize girişinizi yaparak bilgilerinizi güncelleyiniz. Yeni üye sistemi ile beraber ödeme takibi, üye bilgilerinin güncellenmesi gibi işlemler yürütülebilecektir. Üye Ödeme Bilgilerinin güncellenmesi biraz zaman alacaktır. Şu an sistemde hiç ödeme yapmamış gibi görünüyor olabilirsiniz. Üye bilgilerinin güncellenmesi ödemelerin girilmesi gibi konularda veya Web-Çalışma Grubu içerisinde kodlama, tasarım veya içerik konularından herhangi birisinde bize yardımcı olmak isterseniz web-cg@liste.linux.org.tr adresine bir mail atmanız yeterli. Size en kısa zamanda geri döneceğiz.<br>Iyi Günler Dileriz<br>Linux Kullanıcıları Derneği - Web-CG";


	/* and now mail it */
	mail($to, $subject, $message, $headers);
	while($row = mysql_fetch_array($rs)) {
		$content = eregi_replace("__AD__" , $row[0]." ".$row[1] , $mail);
		$content = eregi_replace("__SIFRE__" , $row[3] , $content);

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "To: ".$row[0]." ".$row[1]." <".$row[2].">\r\n";
		$to = $row[2];
		$headers .= "From: LKD Uyelik Sistemi <uye@lkd.org.tr>\r\n";
		// acilacak
		mail($to, "Yeni uyelik sistemi ve sifreniz", $content, $headers);
	}
	echo "bitti !!!";
?>
