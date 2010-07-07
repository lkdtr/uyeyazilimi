<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />


<!-- javaScript -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready( function() {
	$("#odeform").submit(function() {
		if ($("#ad").val()=='') {
			alert("Ad alanını doldurunuz.");
			return false;
		}
		if ($("#soyad").val()=='') {
			alert("Soyad alanını doldurunuz.");
			return false;
		}
		if ($("#adres").val()=='') {
			alert("Adres alanını doldurunuz.");
			return false;
		}
		if ($("#telefon").val()=='') {
			alert("Telefon alanını doldurunuz.");
			return false;
		}
		if ($("#aciklama").val()=='') {
			alert("Açıklama alanını doldurunuz.");
			return false;
		}
		if ($("#eposta").val()=='') {
			alert("E-posta alanını doldurunuz.");
			return false;
		}
		if ($("#kartno").val()=='') {
			alert("Kart No alanını doldurunuz.");
			return false;
		}
		if ($("#tutarytl").val()=='0' ) {
			alert("Tutar alanını doldurunuz.");
			return false;
		}
		if ($("#tutarytl").val()=='' ) {
			alert("Tutar alanını doldurunuz.");
			return false;
		}
		if ($("#cvc").val()=='' ) {
			alert("Güvenlik Kodu alanını doldurunuz.");
			return false;
		}
		if ($("#guvenlik_kodu").val()=='') {
			alert("Bulmaca alanını doldurunuz.");
			return false;
		}
      });
});
</script>
<!-- javaScript -->



<title>LKD Bağış Sistemi</title>

    <?php 
        function monthSelect () {
            echo '<select name="validityDateMonth" style="width:70px; height:30px;" class="inp">';
            for ($i=1;$i<=12;$i++) {
                echo "<option value=$i>$i</option>";

            }
            echo '</select>';
        }
        function yearSelect() {
            $currentYearDate = getdate();
            $currentYear =$currentYearDate['year'];
            echo '<select name="validityDateYear" style="width:70px; height:30px;" class="inp">';
            for ($i=$currentYear;$i<=$currentYear+20;$i++) {
                echo "<option value=$i>$i</option>";
            }
            echo '</select>';
        }


?>
</head>
<body>
<div id="container">
	<div id="top_content">
    	<p class="top">Bağlantı Adresiniz, <strong><?php echo $_SERVER['REMOTE_ADDR']?></strong></p>
    </div>
    <div id="info-logo">
    	<div id="logo-part">
    		<img src="images/resmilogo.png" align="left" />
        </div>
        <div id="info-part">
            <img src="images/part.png" align="left" />
            <p>
            <span class="subject">Derneğe banka yoluyla da bağış / aidat ödemesi yapabilirsiniz</span><br /><br />
            <span class="subject">Banka :</span> Garanti Bankası<br>
            <span class="subject">Şube :</span> Kızılay (Şube No: 082)<br>
            <span class="subject">Hesap Numarası :</span> 6298573<br>
            <span class="subject">IBAN :</span> TR51 0006 2000 0820 0006 2985 73<br>
            </p>
        </div>
    </div>
    <div id="content">
    <!-- Form Başlangıcı -->
    
        <form method="POST" action="process_payment.php" id="odeform">
    <input name="payment_accepted" value="false" type="hidden">
        <table width="600" cellspacing="10" style="margin-right:auto; margin-left:auto;">
			<tbody>
            	<tr>
					<td colspan="2"></td>
                </tr>
                <tr>
                	<td colspan="2"><div class="subject" style="margin:10px;">Kredi kartı ile aidat/bağış ödemesi yapmak için aşağıdaki formu doldurabilirsiniz</div><br></td>
                </tr>
            	<tr><td><span class="subject">Ad</span></td><td><input name="nameText" type="text" class="inp" id="ad"></td></tr>
            <tr><td><span class="subject">Soyad</span></td><td><input name="surnameText" type="text" class="inp" id="soyad"></td></tr>


            <tr><td><span class="subject">Adres</span></td><td><textarea name="addressTextArea" 
rows="5" class="tear" id="adres"></textarea></td></tr>
	    <tr><td><span class="subject">Telefon</span></td><td><input name="telephoneText" type="text" class="inp" id="telefon"></td></tr>
            <tr><td><span class="subject">Açıklama</span></td><td><textarea 
name="descriptionTextArea" id="aciklama" rows="5" class="tear"></textarea></td></tr>
             <tr><td><span class="subject">Ödeme Türü</span></td><td><input name="paymentTypeRadio" 
value="1" default="" type="radio" style="none;"><span class="subject"> Bağış&nbsp;</span><input 
name="paymentTypeRadio" value="2" type="radio" checked style="none;"><span class="subject">Üyelik Ödentisi (Aidat)</span></td></tr>
			 <tr>
				<td colspan="2">
				<div style="margin-top:10px;"><span class="warn">Üyelik ödentisi için açıklama 
kısmına ÜYE NUMARANIZI / İSMİNİZİ girmeyi unutmayınız.</span></div>
				</td>
			 </tr>
            <tr><td><span class="subject">E-Posta</span></td><td><input name="emailText" type="text" class="inp" id="eposta"></td></tr>
            <tr><td><span class="subject">Kart No</span></td><td><input name="cardNoText" id="kartno" type="text" class="inp"></td></tr>

            <tr><td><span class="subject">Son Kullanma Tarihi</span></td><td><?php monthSelect();?>&nbsp;<?php yearSelect();?></td></tr>

            <tr><td><span class="subject">Güvenlik Kodu</span></td><td><input name="cvcText" type="text" id="cvc" class="inp"></td></tr>
            <tr><td><span class="subject">Tutar</span></td><td><input name="tutarYTLText" id="tutarytl" size="10" 
maxlength="10" style="text-align: right; width:60px;" value="0" type="text" class="inp"> 
<span class="subject">TL&nbsp;</span><input name="tutarYKRText" size="2" maxlength="2" value="00" 
type="text" class="inp" style="width:60px;">
<span class="subject"> KR</span></td></tr>

<tr><td><span class="subject">Bulmaca</span></td><td colspan="2"><img id="captcha" src="securimage/securimage_show.php" alt="Güvenlik Kodu" /><a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><img id="refresh" border="0" src="securimage/images/refresh.gif" alt="Resmi Yenile" /></a></td></tr>

            <tr><td><span class="subject"></span></td><td><input id="guvenlik_kodu" name="guvenlik_kodu" type="text" class="inp"></td></tr>

            <tr><td colspan="2" style="text-align: center;"><input 
value="Öde" type="submit" class="sub"></td></tr>

        </tbody></table>
    </form>
    
    <!-- From Bitişi -->
    
    
    </div>
</div>
<br /><br /><br /><br />



</body>
</html>
