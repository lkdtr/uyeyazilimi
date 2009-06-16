<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
@mysql_connect(HOST,USER,PASS);
@mysql_select_db(DB);
$slug = $_SERVER['PHP_AUTH_USER'];
/* üye bilgileri */
$query='SELECT * FROM uyeler WHERE alias="' . $slug . '@linux.org.tr"';
$result=mysql_query($query);
$user_info = mysql_fetch_array($result);
/*
 * lkd üye listesi ile ilgili fonksiyon 
 * form alanında karışıklık yaratmaması için fonksiyon olarak tanımladım
 */

function durumlar($user_info)
{
    //liste üyelik durumu
    if($user_info['liste_uyeligi'] == 1)
    {
        $liste_durum = "Listeye kayıtlısınız";
        $lo1 = "Selected";
        $lo2 = "";
    }
    else
    {
        $liste_durum="Listeye kayıtlı değilsiniz";
        $lo1 = "";
        $lo2 = "Selected";
    }

    //gönüllülük durumu
    if($user_info['gonullu']==1)
    {
        $gonullu_durum = "Gönüllü olarak çalışmalara katılmak istiyorsunuz";
        $go1 = "Selected";
        $go2 = "";
    }
    else
    {
        $gonullu_durum = "Gönüllü olarak çalışmalara katılmak istemiyorsunuz";
        $go1 = "";
        $go2 = "Selected";

    }

    //kimlik durumu
    if($user_info['kimlik_gizli'] == 1)
    {
        $kimlik_durum = "Kimliğiniz gizli durumda";
        $ko1 = "Selected";
        $ko2 = "";
    }
    else
    {
        $kimlik_durum = "Kimliğiniz açık durumda";
        $ko1 = "";
        $ko2 = "Selected";
    }

    //oylama durumu
    if($user_info['oylama'] == 1)
    {
        $oylama_durum = "Oylamalara katılıyorsunuz";
        $oo1 = "Selected";
        $oo2 = "";
    }
    else
    {
        $oylama_durum = "Oylamalara katılmıyorsunuz";
        $oo1 = "";
        $oo2 = "Selected";
    }

    //trac durumu
    if($user_info['trac_listesi'] ==1)
    {
        $trac_durum = "Trac üyesine kayıtlısınız";
        $to1 = "Selected";
        $to2 = "";
    }
    else
    {
        $trac_durum = "Trac üyesine kayıtlı değilsiniz";
        $to1 = "";
        $to2 = "Selected";

    }
}




durumlar();
?>



<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
    Hoşlgeniz, <?php $user_info['uye_ad']; ?><br/>
    <table>
        <form action='bilgi_duzenle.php' method="post">
        <tr>
            <td bgcolor="#466176">Üye Numarası:</td>
            <td bgcolor="#F5F5F5"><?php echo $user_info['uye_id']; ?></td>
        </tr>
        <tr>
            <td bgcolor="#466176">Adı Soyadı:</td>
            <td bgcolor="#F5F5F5"><?php echo $user_info['uye_ad'] . $user_info['uye_soyad']; ?></td>
        </tr>
        <tr>
            <td bgcolor="#466176">E-Posta Adresi 1:</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_mail1' value='<?php echo $user_info['eposta1']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176">E-Posta Adresi 2:</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_mail2' value='<?php echo $user_info['eposta2']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176">Telefon 1:</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_telefon1' value='<?php echo $user_info['Telefon1']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176">Telefon 2:</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_telefon2' value='<?php echo $user_info['Telefon2']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176">Yaşadığı Şehir:</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_sehir' value='<?php echo $user_info['sehir']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176">LKD Üye Listesi: Şuanki durumunuz <?php echo $liste_durum; ?></td>
            <td bgcolor="#F5F5F5">
                <select name='txt_liste'>
                    <option value='1' <?php echo $lo1;?>>Kayıt Olmak İstiyorum</option>
                    <option value='0' <?php echo $lo2;?>>Kayıt Olmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176">Gönüllü Çalışmalar(LKD çalışmalarına gönüllü olmak istermisiniz): Şuanki durumunuz <?php echo $gonullu_durum; ?></td>
            <td bgcolor="#F5F5F5">
                <select name='txt_gonullu'>
                    <option value='1' <?php echo $go1;?>>Gönüllü Olmak İstiyorum</option>
                    <option value='0' <?php echo $go2;?>>Gönüllü Olmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176">Elektronik Oylamalar(Elektronik oylamalara katılmak istermisiniz): Şuanki durumunuz <?php echo $oylama_durum; ?></td>
            <td bgcolor="#F5F5F5">
                <select name='txt_oylama'>
                    <option value='1' <?php echo $oo1;?>>Katılmak İstiyorum</option>
                    <option value='0' <?php echo $oo2;?>>Katılmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176">Trac Liste Kaydı (Trac mail listesine kayıt durumunuz DİKKAT YÜKSEK TRAFİK): Şuanki durumunuz <?php echo $trac_durum; ?></td>
            <td bgcolor="#F5F5F5">
                <select name='txt_trac'>
                    <option value='1' <?php echo $to1;?>>Kayıt Olmak İstiyorum</option>
                    <option value='0' <?php echo $to2;?>>Kayıt Olmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176">Kimlik Gizliliği(Kimliğiniz diğer üyeler tarafından görülebilsin mi?): Şuanki durum <?php echo $kimlik_durum; ?></td>
            <td bgcolor="#F5F5F5">
                <select name='txt_kimlik'>
                    <option value='1' <?php echo $ko1;?>>Evet</option>
                    <option value='0' <?php echo $ko2;?>>Hayır</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176" colspan='2'><input type='submit' value='Değiştir'/></td>
        </tr>
        </form>
        <form action='sifre.php' method='post'>
        <tr>
            <td>Yeni Parolanız:</td>
            <td><input type='password' name='txt_parola1'/></td>
        </tr>
        <tr>
            <td>Parolanızı Tekrar Giriniz:</td>
            <td><input type='password' name='txt_parola2'/></td>
        </tr>
        <tr>
            <td colspan='2'><input type='submit' value='Değiştir'/></td>
        </tr>
        </form>
    </table>
    
    </body>
</html>
