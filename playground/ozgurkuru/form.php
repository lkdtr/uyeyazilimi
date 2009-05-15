<?php
@require('db.php'); //veri tabanı bilgilerini bu dosyadan çektiğimi varsayıyorum.
@mysql_connect("$HOST","$USER","$PASS");
@mysql_select_db("$DB");
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
    }
    else
    {
        $liste_durum="Listeye kayıtlı değilsiniz";
    }

    //gönüllülük durumu
    if($user_info['gonullu']==1)
    {
        $gonullu_durum = "Gönüllü olarak çalışmalara katılmak istiyorsunuz";
    }
    else
    {
        $gonullu_durum = "Gönüllü olarak çalışmalara katılmak istemiyorsunuz";
    }

    //kimlik durumu
    if($user_info['kimlik_gizli'] == 1)
    {
        $kimlik_durum = "Kimliğiniz gizli durumda";
    }
    else
    {
        $kimlik_durum = "Kimliğiniz açık durumda";
    }

    //oylama durumu
    if($user_info['oylama'] == 1)
    {
        $oylama_durum = "Oylamalara katılıyorsunuz";
    }
    else
    {
        $oylama_durum = "Oylamalara katılmıyorsunuz";
    }

    //trac durumu
    if($user_info['trac_listesi'] ==1)
    {
        $trac_durum = "Trac üyesine kayıtlısınız";
    }
    else
    {
        $trac_durum = "Trac üyesine kayıtlı değilsiniz";
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
    Hoşlgeniz, <?php $user_info['uye_adi']; ?><br/>
    <table>
        <form action='bilgi_duzenle.php' method="post">
        <tr>
            <td>Üye Numarası:</td>
            <td><?php echo $user_info['uye_id']; ?></td>
        </tr>
        <tr>
            <td>Üye Adı:</td>
            <td><?php echo $user_info['uye_adi'] . $user_info['uye_soyad']; ?></td>
        </tr>
        <tr>
            <td>E-Posta Adresi 1:</td>
            <td><input type='text' name='txt_mail1' value='<?php echo $user_info['eposta1']; ?>'/></td>
        </tr>
        <tr>
            <td>E-Posta Adresi 2:</td>
            <td><input type='text' name='txt_mail2' value='<?php echo $user_info['eposta2']; ?>'/></td>
        </tr>
        <tr>
            <td>Telefon 1:</td>
            <td><input type='text' name='txt_telefon1' value='<?php echo $user_info['Telefon1']; ?>'/></td>
        </tr>
        <tr>
            <td>Telefon 2:</td>
            <td><input type='text' name='txt_telefon2' value='<?php echo $user_info['Telefon2']; ?>'/></td>
        </tr>
        <tr>
            <td>Şehir:</td>
            <td><input type='text' name='txt_sehir' value='<?php echo $user_info['sehir']; ?>'/></td>
        </tr>
        <tr>
            <td>Liste Üyeliği (LKD Üye listesine kayıt durumu): Şuanki durumunuz <?php echo $liste_durum; ?></td>
            <td>
                <select name='text_liste'>
                    <option value='1'>Kayıt Olmak İstiyorum</option>
                    <option value='0'>Kayıt Olmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Gönüllü Durumu (LKD çalışmalarına gönüllü olmak istermisiniz): Şuanki durumunuz <?php echo $gonullu_durum; ?></td>
            <td>
                <select name='text_gonullu'>
                    <option value='1'>Gönüllü Olmak İstiyorum</option>
                    <option value='0'>Gönüllü Olmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Oylama Durumu (Elektronik oylamalara katılmak istermisiniz): Şuanki durumunuz <?php echo $oylama_durum; ?></td>
            <td>
                <select name='text_oylama'>
                    <option value='1'>Katılmak İstiyorum</option>
                    <option value='0'>Katılmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Trac Liste Kaydı (Trac mail listesine kayıt durumunuz DİKKAT YÜKSEK TRAFİK): Şuanki durumunuz <?php echo $trac_durum; ?></td>
            <td>
                <select name='text_gonullu'>
                    <option value='1'>Kayıt Olmak İstiyorum</option>
                    <option value='0'>Kayıt Olmak İstemiyorum</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kimlik Durumu (Kimliğiniz diğer üyeler tarafından görülebilsin mi?): Şuanki durum <?php echo $kimlik_durum; ?></td>
            <td>
                <select name='text_kimlik'>
                    <option value='1'>Evet</option>
                    <option value='0'>Hayır</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan='2'><input type='submit' value='Değiştir'/></td>
        </tr>
        </form>
        <form action='sifre.php' method='post'>
        <tr>
            <td>Yeni Parolanız:</td>
            <td><input type='password' name='text_parola1'/></td>
        </tr>
        <tr>
            <td>Parolanızı Tekrar Giriniz:</td>
            <td><input type='password' name='text_parola2'/></td>
        </tr>
        <tr>
            <td colspan='2'><input type='submit' value='Değiştir'/></td>
        </tr>
        </form>
    </table>
    
    </body>
</html>
