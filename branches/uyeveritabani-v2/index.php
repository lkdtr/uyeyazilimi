<?php
	/*
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
if( $_SESSION["uy_status_UserLevel"] ) // Kullanicinin Login oldugunu ispat etmek icin
	header("Location: duyurusonlist.php");

if (@$_POST["submit"] <> "") {
	$validpwd = False;
	// degiskenler hazirlaniyor
	$userid = addslashes($_POST["userid"]);
//	$userid = (get_magic_quotes_gpc()) ? stripslashes($userid) : $userid;
	$passwd = addslashes($_POST["passwd"]);
//	$passwd = (get_magic_quotes_gpc()) ? stripslashes($passwd) : $passwd;
	$conn = mysql_connect(HOST, USER, PASS) or die("Veritabanýna baðlanamadýk");
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
		$Sorgu = "SELECT * FROM uyeler WHERE (eposta1 = '" . $userid . "')"
			. " OR (alias = '". $userid ."')"; //Alias da kabul
		$rs = mysql_query($Sorgu) or die(mysql_error());
		if ($row = mysql_fetch_array($rs)) {
			if ($row["PassWord"] == md5($passwd)) {
				$_SESSION["uy_status_User"] = $row["eposta1"];
				$_SESSION["uy_status_UserID"] = $row["uye_id"];
				// Aslinda artik tabloda AuthLevel yok. Ama eski yazilimin cogu yerinde
				// bu deger kontrol ediliyor. O yuzden "simdilik" bu cozumu uyguladim
				$_SESSION["uy_status_UserLevel"] = 1;

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
	<title>LKD ÜYE VERÝTABANI</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9"/>
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
	if (!EW_onError(EW_this, EW_this.passwd, "PASSWORD", "Þifre Giriniz"))
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
	<?php echo (@$_COOKIE["uy_userid"]) ? (@$_COOKIE["uy_userid"]) : "@linux.org.tr"; ?>
	"></td>
        <td><input type="checkbox" name="rememberme" value="true">Beni Hatýrla (Çerez Kullanýlýr)</td>
      </tr>
      <tr>
        <td width="75" align="right">Parola</td>
        <td width="100" align="left"><input type="password" name="passwd"></td>
        <td><input type="submit" name="submit" value="Giriþ">
		<?php if (!$validpwd) {?>
		<font color="#FF0000">Yanlýþ e-posta veya parola
		<?php }?>
		</td>
      </tr>
    </table></td>
    <td width="40%" align="center">
    Kullanýcý adý olarak gireceðiniz e-posta adresi, isim.soyisim@linux.org.tr biçiminde olmalýdýr.<br>
	<a href="sifrehatirlat.php">Parolanýzý unuttuysanýz týklayýnýz.</a></td>
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
	&nbsp;
<?php
	require_once "duyurusonlistforinclude.php";
	require_once "footer.php";
?>
</td></tr></table>
</body>
</html>
