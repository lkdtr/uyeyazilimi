<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>LKD Bağış Sistemi</title>

    <?php 
        function monthSelect () {
            echo '<select name="validityDateMonth">';
            for ($i=1;$i<=12;$i++) {
                echo "<option value=$i>$i</option>";

            }
            echo '</select>';
        }
        function yearSelect() {
            $currentYearDate = getdate();
            $currentYear =$currentYearDate['year'];
            echo '<select name="validityDateYear">';
            for ($i=$currentYear;$i<=$currentYear+20;$i++) {
                echo "<option value=$i>$i</option>";
            }
            echo '</select>';
        }


?>

</head>

<body bgcolor="white">

<center>
    <form method="POST" action="process_payment.php">
    <input type="hidden" name="payment_accepted" value="false">
    <img src="images/resmilogo.png" alt="LKD"><br/>
        Bağlantı Adresiniz, <strong><?php echo $_SERVER['REMOTE_ADDR']?></strong>
        <table>

            <tr><td>Ad</td><td><input type="text" name="nameText"></td></tr>
            <tr><td>Soyad</td><td><input type="text" name="surnameText"></td></tr>


            <tr><td>Adres</td><td><textarea name="addressTextArea" rows="5"></textarea></td></tr>
	    <tr><td>Telefon</td><td><input type="text" name="telephoneText"></td></tr>
            <tr><td>Açıklama</td><td><textarea name="descriptionTextArea" rows="5"></textarea></td></tr>
             <tr><td>Ödeme Türü</td><td><input type="radio" name="paymentTypeRadio" value="1" default> Bağış&nbsp;<input type="radio" name="paymentTypeRadio" value="2">Üyelik Ödentisi</td></tr>
			 <tr>
				<td colspan="2">
				<div style="color:#FF0000">Üyelik ödentisi için açıklama kısmına üye numaranızı / isminizi girmeyi unutmayınız.</div>
				</td>
			 </tr>
            <tr><td>E-Posta</td><td><input type="text" name="emailText"></td></tr>
            <tr><td>Kart No</td><td><input type="text" name="cardNoText"></td></tr>

            <tr><td>Son Kullanma Tarihi</td><td><?php monthSelect();?>&nbsp;<?php yearSelect();?></td></tr>

            <tr><td>CVC</td><td><input type="text" name="cvcText"></td></tr>
            <tr><td>Tutar</td><td><input type="text" name="tutarYTLText" size="10" maxlength="10" style="text-align:right" value="0"> YTL&nbsp;<input type="text" name="tutarYKRText" size="2" maxlength="2" value="00"> Kuruş</td></tr>
            <tr><td colspan="2" style="text-align:center"><input type="submit" value="Öde"></td></tr>

        </table>
    </form>
</center>
</body>
</html>
