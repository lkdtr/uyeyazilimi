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

if (@$_POST["submit"] <> "") {

	$validpwd = False;



	// degiskenler hazirlaniyor

	$userid = addslashes($_POST["userid"]);

//	$userid = (get_magic_quotes_gpc()) ? stripslashes($userid) : $userid;

	$passwd = addslashes($_POST["passwd"]);

//	$passwd = (get_magic_quotes_gpc()) ? stripslashes($passwd) : $passwd;

		$conn = mysql_connect(HOST, USER, PASS);

		mysql_select_db(DB);
		        mysql_query("SET NAMES 'utf8'");

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
		        mysql_query("SET NAMES 'utf8'");

		$rs = mysql_query("SELECT * FROM uyeler WHERE eposta1 = '" . $userid . "'") or die(mysql_error());

		if ($row = mysql_fetch_array($rs)) {

			if (strtoupper($row["PassWord"]) == strtoupper($passwd)) {

				$_SESSION["uy_status_User"] = $row["eposta1"];

					 	$_SESSION["uy_status_UserID"] = $row["uye_id"];


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

		header("Location: index.php");  // Yonlendirmek istediginiz sayfayi yaziniz...

// Baska bir sayfadan login kutularini koyacaksaniz burayi degistiriniz. Session olaylarina dikkat ediniz.

	}

} else {

	$validpwd = True;

}

?>

<html>

<head>

	<title>LKD ÜYE VERİTABANI</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9"/>

<meta name="generator" content="PHPMaker v2.0.0.4"/>

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

	if (!EW_onError(EW_this, EW_this.passwd, "PASSWORD", "Şifre Giriniz"))

		return false;

}

return true;

}



// end JavaScript -->

</script>

<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>

<table border="0" cellspacing="0" cellpadding="2" align="center">

	<tr>

		<td>LKD ÜYE VERİTABANI</td>

	</tr>

</table>

<?php if (!$validpwd) {?>

<p align="center"><font color="#FF0000">Yanlış ID veya Şifre<br><?php echo $userid $passwd;?></p>

<?php }?>

<form action="login.php" method="post" onSubmit="return EW_checkMyForm(this);">

<table border="0" cellspacing="0" cellpadding="4" align="center">

	<tr>

		<td align="left">Kullanıcı ID</td>

		<td><input type="text" name="userid" size="20" value="<?php echo @$_COOKIE["uy_userid"]; ?>"></td>

	</tr>

	<tr>

		<td align="left">Şifre</td>

		<td><input type="password" name="passwd" size="20"></td>

	</tr>

	<tr>

		<td align="left">&nbsp;</td>

		<td><input type="checkbox" name="rememberme" value="true">Beni Hatırla (Çerez Kullanılır)</td>

	</tr>

	<tr>

		<td colspan="2" align="center"><input type="submit" name="submit" value="Giriş"></td>

	</tr>

</table>

</form>

<br>
</body>

</html>
