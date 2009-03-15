<?php error_reporting(0); ?>
<?php if (@$_SESSION["uy_status_UserID"] == "" && @$_SESSION["uy_status_UserLevel"] <> -1 ) header("Location: index.php"); ?>
<html>
<head>
<title>LKD ÜYE VERİTABANI</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="StyleSheet" href="stil.css" type="text/css">
<link rel="StyleSheet" href="anylink.css" type="text/css">
<script type="text/javascript" src="anylink.js"></script>
</head>
<table width="780" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse ">
  <tr>
   <td><table align="left" border="0" cellpadding="0" cellspacing="0" width="780">
	  <tr>
	   <td><a href="index.php"><img name="index_r1_c1" src="images/index_r1_c1.jpg" width="189" height="118" border="0" alt=""></a></td>
	   <td><a href="index.php"><img name="index_r1_c2" src="images/index_r1_c2.jpg" width="266" height="118" border="0" alt=""></a></td>
	   <td><a href="index.php"><img name="index_r1_c3" src="images/index_r1_c3.jpg" width="325" height="118" border="0" alt=""></a></td>
	  </tr>
	</table></td>
  </tr>
  <tr>
   <td height="1" bgcolor="#FFFFFF">
<!-- LOGIN FORMU VE LINKLER BAS -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<?php if (@$_SESSION["uy_status"] <> "login") { ?>
		<form action="index.php" method="post" onSubmit="return EW_checkMyForm(this);">
		<table width="100%"  border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td height="10" colspan="3"></td>
        </tr>
      <tr>
        <td width="75" align="right">e-mail</td>
        <td width="100" align="left"><input name="userid" type="text" id="email" value="<?php echo @$_COOKIE["uy_userid"]; ?>"></td>
        <td><input type="checkbox" name="rememberme" value="true">Beni Hatırla (Çerez Kullanılır)</td>
      </tr>
      <tr>
        <td width="75" align="right">şifre</td>
        <td width="100" align="left"><input type="password" name="passwd"></td>
        <td><input type="submit" name="submit" value="Giriş">
		<?php if (!$validpwd) {?>
		<font color="#FF0000">Yanlış ID veya Şifre
		<?php }?>
		</td>
      </tr>
    </table>
<? }
?>
	</td>
   </tr>
</table></form>
   </td>
  </tr>
  <tr>
   <td height="19" bgcolor="#466176">
<?php if ($_SESSION["uy_status_UserLevel"] == -1) { ?>
	<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
       <td><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="uyelerlist.php?cmd=resetall" class="navbeyaz">Üye Listesi</a></td>
       <td><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="odemelerlist.php?cmd=resetall" class="navbeyaz">Yapılan Ödemeler</a></td>
       <td><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="duyurularlist.php?cmd=resetall" class="navbeyaz">Duyurular</a></td>
	   <td><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="yoneticilerlist.php?cmd=resetall" class="navbeyaz">Yöneticiler</a></td>
	   <td align="center"><img src="images/navicon_truncu.gif" width="16" height="9">
	    <a href="#" onMouseOver="dropdownmenu(this, event, 'anylinkmenu1')" class="navbeyaz">Ekstralar</a>
	   </td>
	   <td align="right"><img src="images/navicon_beyaz.gif" width="16" height="9">&nbsp;<a class="navbeyaz" href="logout.php">Çıkış</a></td>
<?php }
else {
?>
	<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
       <td><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="uyelerlist.php?cmd=resetall" class="navbeyaz">Üye Bilgilerim</a></td>
       <td><img src="images/navicon_truncu.gif" width="16" height="9"> <a href="odemelerlist.php?cmd=resetall" class="navbeyaz">Ödemelerim</a></td>
       <td><img src="images/wacko.ico" height="13"> <a href="http://uye.lkd.org.tr/uye/" target="_blank" class="navbeyaz">Üye Wikisi</a></td>
	   <td align="right"><img src="images/navicon_truncu.gif" width="16" height="9">&nbsp;<a class="navbeyaz" href="logout.php">Çıkış</a></td>
<?
}
?>
     </tr>
   </table>
   <div class="anylinkcss" id="anylinkmenu1">
    <a href="csv.php" class="navbeyaz">Kimlik için CSV</a>
    <a href="tumkimlik.php" class="navbeyaz">Kimlik için HTML (tümü)</a>
    <a href="odemeyenler.php" target="_blank" class="navbeyaz">Ödemeleri Eksik Olanlar (CSV)</a>
    <a href="tum.php" target="_blank" class="navbeyaz">Ödemeler Genel Durum (HTML)</a>
  </div> 
   </td>
  </tr>
  <tr>
   <td bgcolor="#D6DDE7">

