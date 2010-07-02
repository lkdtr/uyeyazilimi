<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
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
    
        <form method="POST" action="process_payment.php">
    <input name="payment_accepted" value="false" type="hidden">
        <table width="600" cellspacing="10" style="margin-right:auto; margin-left:auto;">
			<tbody>
            	<tr>
					<td colspan="2"></td>
                </tr>
                <tr>
                	<td colspan="2"><div class="subject" style="margin:10px;">Kredi kartı ile aidat/bağış ödemesi yapmak için aşağıdaki formu doldurabilirsiniz</div><br></td>
                </tr>
            	<tr><td><span class="subject">Ad</span></td><td><input name="nameText" type="text" class="inp"></td></tr>
            <tr><td><span class="subject">Soyad</span></td><td><input name="surnameText" type="text" class="inp"></td></tr>


            <tr><td><span class="subject">Adres</span></td><td><textarea name="addressTextArea" 
rows="5" class="tear"></textarea></td></tr>
	    <tr><td><span class="subject">Telefon</span></td><td><input name="telephoneText" type="text" class="inp"></td></tr>
            <tr><td><span class="subject">Açıklama</span></td><td><textarea 
name="descriptionTextArea" rows="5" class="tear"></textarea></td></tr>
             <tr><td><span class="subject">Ödeme Türü</span></td><td><input name="paymentTypeRadio" 
value="1" default="" type="radio" style="none;"><span class="subject"> Bağış&nbsp;</span><input 
name="paymentTypeRadio" value="2" type="radio" style="none;"><span class="subject">Üyelik Ödentisi</span></td></tr>
			 <tr>
				<td colspan="2">
				<div style="margin-top:10px;"><span class="warn">Üyelik ödentisi için açıklama 
kısmına ÜYE NUMARANIZI / İSMİNİZİ girmeyi unutmayınız.</span></div>
				</td>
			 </tr>
            <tr><td><span class="subject">E-Posta</span></td><td><input name="emailText" type="text" class="inp"></td></tr>
            <tr><td><span class="subject">Kart No</span></td><td><input name="cardNoText" type="text" class="inp"></td></tr>

            <tr><td><span class="subject">Son Kullanma Tarihi</span></td><td><?php monthSelect();?>&nbsp;<?php yearSelect();?></td></tr>

            <tr><td><span class="subject">CVC</span></td><td><input name="cvcText" type="text" class="inp"></td></tr>
            <tr><td><span class="subject">Tutar</span></td><td><input name="tutarYTLText" size="10" 
maxlength="10" style="text-align: right; width:60px;" value="0" type="text" class="inp"> 
<span class="subject">TL&nbsp;</span><input name="tutarYKRText" size="2" maxlength="2" value="00" 
type="text" class="inp" style="width:60px;">
<span class="subject"> KR</span></td></tr>
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
