<?php
	/*
	 *  175-193 numarali satirlar arasindaki blogu duzenledim - dfisek
	 *
	 *  LKD Uye Veritabani
	 *  Copyright (C) 2004  R. Tolga KORKUNCKAYA (tolga@mavibilgisayar.com)
	 *
	 *  This program is free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 2 of the License, or
	 *  (at your option) any later version.
	 *
	 *  This program is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU Library General Public License for more details.
	 *
	 *  You should have received a copy of the GNU General Public License
	 *  along with this program; if not, write to the Free Software
	 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
	 */
?>
<?php session_start(); ?>
<?php
define("DEFAULT_LOCALE", "tr_TR");
@setlocale(LC_ALL, DEFAULT_LOCALE);
?>
<?php include ("db.php") ?>
<?php

if (@$_POST["submit"] <> "") { 
	$validpwd = False;
	// degiskenler hazirlaniyor
	$userid = @$_POST["userid"];
	$userid = (get_magic_quotes_gpc()) ? stripslashes($userid) : $userid;
	$passwd = @$_POST["passwd"];
	$passwd = (get_magic_quotes_gpc()) ? stripslashes($passwd) : $passwd;
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritabanına bağlanamadık");
	mysql_select_db(DB) or die("seçemedi");
	$rs = mysql_query("SELECT * FROM yoneticiler WHERE AdminAd = '" . $userid . "'") or die(mysql_error());
	if ($row = mysql_fetch_array($rs)) {
		if (strtoupper($row["AdminPass"]) == strtoupper($passwd)) {
			$validpwd = True;
  			$_SESSION["uy_status_UserLevel"] = -1; //
		}
	}
	if (!$validpwd) {
		$conn = mysql_connect(HOST, USER, PASS);
		mysql_select_db(DB);
		$rs = mysql_query("SELECT * FROM uyeler WHERE eposta1 = '" . $userid . "'") or die(mysql_error());
		if ($row = mysql_fetch_array($rs)) {
			if (strtoupper($row["PassWord"]) == strtoupper($passwd)) {
				$_SESSION["uy_status_User"] = $row["eposta1"];
				$_SESSION["uy_status_UserID"] = $row["uye_id"];
				$_SESSION["uy_status_UserLevel"] = $row["AuthLevel"];
				$validpwd = True;
			}
		}
		mysql_free_result($rs);
		mysql_close($conn);
	}
	if ($validpwd) {
		// cerezci geldi haniimm!
		if (@$_POST["rememberme"] <> "") {
			setCookie("uy_userid", $userid, time()+365*24*60*60); // cerez son kullanma tarihi kutunun uzerindedir...
		}
		$_SESSION["uy_status"] = "login";
		//header("Location: uyelerlist.php");  // Yonlendirmek istediginiz sayfayi yaziniz...

		/* eklenti yaptigim yer */
		//***************************************************************************************
			//header("Location: duyurularview.php");
			header("Location: duyurusonlist.php");


		//***************************************************************************************

// Baska bir sayfadan login kutularini koyacaksaniz burayi degistiriniz. Session olaylarina dikkat ediniz.
	}
	} else {
	$validpwd = True;
}
?>
<html>
<head>
	<title>LKD ÜYE VERİTABANI</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="StyleSheet" href="stil.css" type="text/css">
</head>
<script language="JavaScript" src="ew.js"></script>
<script language="JavaScript">
<!-- start JavaScript
function  EW_checkMyForm(EW_this) {
if (!EW_hasValue(EW_this.userid, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.userid, "TEXT", "Lütfen ID Giriniz"))
		return false;
}
if (!EW_hasValue(EW_this.passwd, "PASSWORD")) {
	if (!EW_onError(EW_this, EW_this.passwd, "PASSWORD", "Parola Giriniz"))
		return false;
}
return true;
}

// end JavaScript -->
</script>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;">
<link href="stil.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#ffffff">
<br>
<table width="780" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#466176" style="border-collapse:collapse "><tr><td>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse ">
  <tr>
   <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="780">
	  <tr>
	   <td><img name="index_r1_c1" src="images/index_r1_c1.jpg" width="189" height="118" border="0" alt=""></td>
	   <td><img name="index_r1_c2" src="images/index_r1_c2.jpg" width="266" height="118" border="0" alt=""></td>
	   <td><img name="index_r1_c3" src="images/index_r1_c3.jpg" width="325" height="118" border="0" alt=""></td>
	  </tr>
	</table></td>
  </tr>
  <tr>
	<td height="81" background="#F8F8F8">
<!-- LOGIN FORMU VE LINKLER BAS -->
<form action="index.php" method="post" onSubmit="return EW_checkMyForm(this);">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%"  border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td height="10" colspan="3"></td>
        </tr>
      <tr>
        <td width="75" align="right">E-posta</td>
        <td width="100" align="left"><input name="userid" type="text" id="email" value="
	<?php echo ($_COOKIE["uy_userid"] != "") ? @$_COOKIE["uy_userid"] : "@linux.org.tr" ?>"></td>
        <td><input type="checkbox" name="rememberme" value="true">Beni Hatırla (Çerez Kullanılır)</td>
      </tr>
      <tr>
        <td width="75" align="right">Parola</td>
        <td width="100" align="left"><input type="password" name="passwd"></td>
        <td><input type="submit" name="submit" value="Giriş">
		<?php if (!$validpwd) {?>
		<font color="#FF0000">Yanlış e-posta veya parola
		<?php }?>
		</td>
      </tr>
    </table></td>
    <td width="40%" align="center">
	</td>
    </tr>
</table></form>
   </td>
  </tr>
  <tr>
   <td height="1" bgcolor="#466176"></td>
  </tr>
  <tr>
   <td bgcolor="#D6DDE7">
<!-- ANA ICERIK BAS -->
<?php
if(!($_POST["email"] && $_POST["button1"])) {
?>
<form action="sifrehatirlat.php" method="post">
<br>
<table align="center" width="80%">
<?php if($_POST["email"] == "" && isset($_POST["email"])) {?>
<tr><td colspan="2" align="center"><font color="red"><b>E-posta adresinizi girmelisiniz!</b></font></td></tr>
<?php } ?>
<tr><td colspan=2>
Parolanız e-posta adresinize gönderilecektir.</td></tr>
<tr><td align="right"><b>E-posta : </b></td><td><input type="text" name="email" size="50"></td></tr>
<tr><td></td><td align="left"><input type="submit" value="Gönder" name="button1"></td></tr>
</table>
</form>
<?php } else {
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritabanına bağlanamadık");
	mysql_select_db(DB) or die("seçemedi");
	$Sorgu = "SELECT uye_ad,uye_soyad,eposta1,PassWord FROM uyeler WHERE (eposta1='". addslashes($_POST["email"]) ."')"
	       . " OR (alias = '". addslashes($_POST["email"]) ."')";
	$rs = mysql_query($Sorgu) or die(mysql_error());
	$row = mysql_fetch_row($rs);

	$passChars = "qwertyuopasdfghjklizxcvbnmQWERTYUOPASDFGHIJKLZXCVBNM0123456789";
	$rndPass = "";
	
	for( $passCnt = 0; $passCnt < 10; $passCnt++ ) {
		$rndPass .= $passChars[ rand()%strlen($passChars) ];
	}
	

	$content = "Sayın $row[0] $row[1],\r\n\r\n";
//	$content .= "Bu e-posta, Linux Kullanıcıları Derneği Üye Veritabanı için yeni bir parola istediğiniz için gönderilmiştir. Eğer kendiniz böyle bir istekte bulunmadıysanız, mesajı dikkate almayabilirsiniz.\r\n\r\n";
	$content .= "Bu e-posta, Linux Kullanıcıları Derneği Üye Veritabanı için yeni bir parola istediğiniz için gönderilmiştir. Eğer kendiniz böyle bir istekte bulunmadıysanız, lütfen yeni parolanızı kaydediniz..\r\n\r\n";
	$content .= "Yeni Parolanız : $rndPass\r\n\r\n";
	//$content .= "Parolanız : $row[3]\r\n\r\n";
	$content .= "Parolanızı sisteme giriş yaptıktan sonra değiştirebilirsiniz.\r\n\r\n";
	$content .= "Üyelikle ilgili her türlü sorununuz için uye@lkd.org.tr adresi ile bağlantı kurabilirsiniz.";

	$headers = "From: LKD Uyelik Sistemi <uye@lkd.org.tr>\r\nContent-type: text/plain; charset=ISO-8859-9";
	$to = "$row[2]";
	if(time() > $_SESSION["Sifre_Mail_Time"]+(5*60) || 1) {
		echo "<br>Mailiniz Gönderilmiştir. Teşekkür Ederiz.";
		$_SESSION["Sifre_Mail_Time"] = time();
		
		$Sorgu = "UPDATE uyeler SET passWord = '". md5($rndPass) ."' WHERE (eposta1='". addslashes($_POST["email"]) ."')"
		       . " OR (alias = '". addslashes($_POST["email"]) ."') LIMIT 1";
		mysql_query($Sorgu) or die(mysql_error());

		mail($to, "Parola Hatirlatma Mesaji", $content, $headers);
		
	} else {
		echo "<br>Yeni bir mail atabilmek için bir süre beklemelisiniz!";
		$_SESSION["Sifre_Mail_Time"] = time();
	}
	// acilacak
 }
?>
<?php
	require_once "footer.php";
?>
</td></tr></table>
</body>
</html>
