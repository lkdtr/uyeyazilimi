<?php
	include ("db.php");
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritabanýna baðlanamadýk");
	mysql_select_db(DB) or die("seçemedi");
	$rs = mysql_query("SELECT uye_ad,uye_soyad,eposta1,PassWord FROM uyeler") or die(mysql_error());
	$mail = "Sayin __AD__ <br> Sifreniz : __SIFRE__ <br>";
	$mail.="Lütfen YENI Üye Sisteminize giriþinizi yaparak bilgilerinizi güncelleyiniz. Yeni üye sistemi ile beraber ödeme takibi, üye bilgilerinin güncellenmesi gibi iþlemler yürütülebilecektir. Üye Ödeme Bilgilerinin güncellenmesi biraz zaman alacaktýr. Þu an sistemde hiç ödeme yapmamýþ gibi görünüyor olabilirsiniz. Üye bilgilerinin güncellenmesi ödemelerin girilmesi gibi konularda veya Web-Çalýþma Grubu içerisinde kodlama, tasarým veya içerik konularýndan herhangi birisinde bize yardýmcý olmak isterseniz web-cg@liste.linux.org.tr adresine bir mail atmanýz yeterli. Size en kýsa zamanda geri döneceðiz.<br>Iyi Günler Dileriz<br>Linux Kullanýcýlarý Derneði - Web-CG";


	/* and now mail it */
	mail($to, $subject, $message, $headers);
	while($row = mysql_fetch_array($rs)) {
		$content = eregi_replace("__AD__" , $row[0]." ".$row[1] , $mail);
		$content = eregi_replace("__SIFRE__" , $row[3] , $content);

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-9\r\n";
		$headers .= "To: ".$row[0]." ".$row[1]." <".$row[2].">\r\n";
		$to = $row[2];
		$headers .= "From: LKD Uyelik Sistemi <uye@lkd.org.tr>\r\n";
		// acilacak
		mail($to, "Yeni uyelik sistemi ve sifreniz", $content, $headers);
	}
	echo "bitti !!!";
?>
