<?php
	include ("db.php");
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritaban�na ba�lanamad�k");
	mysql_select_db(DB) or die("se�emedi");
	$rs = mysql_query("SELECT uye_ad,uye_soyad,eposta1,PassWord FROM uyeler") or die(mysql_error());
	$mail = "Sayin __AD__ <br> Sifreniz : __SIFRE__ <br>";
	$mail.="L�tfen YENI �ye Sisteminize giri�inizi yaparak bilgilerinizi g�ncelleyiniz. Yeni �ye sistemi ile beraber �deme takibi, �ye bilgilerinin g�ncellenmesi gibi i�lemler y�r�t�lebilecektir. �ye �deme Bilgilerinin g�ncellenmesi biraz zaman alacakt�r. �u an sistemde hi� �deme yapmam�� gibi g�r�n�yor olabilirsiniz. �ye bilgilerinin g�ncellenmesi �demelerin girilmesi gibi konularda veya Web-�al��ma Grubu i�erisinde kodlama, tasar�m veya i�erik konular�ndan herhangi birisinde bize yard�mc� olmak isterseniz web-cg@liste.linux.org.tr adresine bir mail atman�z yeterli. Size en k�sa zamanda geri d�nece�iz.<br>Iyi G�nler Dileriz<br>Linux Kullan�c�lar� Derne�i - Web-CG";


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
