<html>
<head>
<title>LKD ÜYE VERİTABANI</title>
<link rel="StyleSheet" href="stil.css" type="text/css">
<script language="JavaScript1.2" src="flyout.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="event_onload();">
	<!-- Banner alani -->
	<!-- ust tablo... -->
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
		<tr><!-- logo burada -->
			<td valign="top">
			<TABLE width="100%"  border="0" cellpadding="0" cellspacing="0">
              <TR>
                <TD width="250"><IMG src="images/lkdlogo.png" alt="" width="250" height="100" border="0"></TD>
                <TD width="90%" valign="top" background="images/top_bg.png">
				<TABLE width="100%" height="100"  border="0" cellpadding="0" id="nav">
                  <TR>
                    <TD align="center">
						|&nbsp;
						<a href="logout.php">Çıkış</a>&nbsp;|&nbsp;
						<a href="uyelerlist.php?cmd=resetall">Üye Bilgileri </a> | 
						<a href="odemelerlist.php?cmd=resetall">Ödemeler</a> | 
<?php 
	if (($ewCurSec & ewAllowAdd) == ewAllowAdd) {
?>
						<a href="duyurularlist.php?cmd=resetall">Duyurular</a> | 
						<a href="bildirilerlist.php?cmd=resetall">Bildiriler</a> | 
						<a href="yoneticilerlist.php?cmd=resetall">Yöneticiler</a> | 
<?php 
	}
?>
						İletişim |						
					</TD>
                  </TR>
                  <TR>
                    <TD align="center" valign="bottom">&nbsp;</TD>
                  </TR>
                </TABLE></TD>
              </TR>
             </TABLE>
		   </td>
		</tr>
	</table>
	<!-- End Top banner -->
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
		<tr>
			<td width="180" valign="top">
			</td>
			<td width="100%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="15"><tr><td>
