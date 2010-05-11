<?php
// Ortak kullanilan fonksiyonlar

require('fonksiyonlar_tarih.inc.php');

function eposta_yonlendirmesi_ac($lkd_eposta, $hedef_eposta)
{
    global $conn;

    mysql_select_db(DB_MAIL,$conn);
    $sorgu = 'INSERT INTO forwardings VALUES("' . $lkd_eposta . '","' . $hedef_eposta . '")';
    mysql_query($sorgu, $conn) or die(mysql_error());
}

function trac_veritabanina_ekle($lkd_login, $ad, $soyad, $lkd_eposta)
{
    global $conn;

    mysql_select_db(DB_TRAC,$conn);
    $sorgu = 'INSERT INTO session VALUES ("' . $lkd_login . '", 1, 0)';
    mysql_query($sorgu, $conn) or die(mysql_error());
    $sorgu = 'INSERT INTO session_attribute VALUES ("' . $lkd_login . '", 1, "name", "' . $ad . ' ' . $soyad . '"),
                                                    ("' . $lkd_login . '", 1, "email", "' . $lkd_eposta . '");';
    mysql_query($sorgu, $conn) or die(mysql_error());
}

function parola_veritabanina_ekle($uye_no, $lkd_login, $ad, $soyad, $lkd_eposta, $privilege)
{
    global $conn;

    mysql_select_db(DB_PWD,$conn);
    $sorgu = 'INSERT INTO members (uye_no,name,lastname,lotr_alias,email,privilege)
                           VALUES  (' . $uye_no . ',"' . $ad . '","' . $soyad . '","' . $lkd_login . '","' . $lkd_eposta . '",' . $privilege . ')';
    mysql_query($sorgu, $conn) or die(mysql_error());
}

function ayrilma_bilgilerini_sifirla($uye_no)
{
    global $conn;

    mysql_select_db(DB,$conn);
    $sorgu = 'UPDATE uyeler SET ayrilma_tarihi = "", Ayrilma_karar_no = "", Ayrilma_karar_tarih = "", kayit_kapanis_tarih = NULL WHERE uye_id = ' . $uye_no;
    mysql_query($sorgu, $conn) or die(mysql_error());
}

function toplam_odemesi_gereken_aidat($uye_no)
{
    // Duzelt beni: aidat_miktar tablosuna elle her yil aidat miktari eklenmesi gerekiyor. Ayrica gelecek yilin aidati eklenirse de fazladan hesapliyor. Bunun yerine sadece aidat degisimlerini tutmak, bir sonraki yil icin otomatik olarak son aidat miktarini hesaplamak daha iyi olur

    global $conn;

    mysql_select_db(DB,$conn);

    $sorgu = 'SELECT kayit_tarihi FROM uyeler WHERE uye_id = ' . $uye_no;
    $sonuc = mysql_query($sorgu) or die(mysql_error());
    $uye = mysql_fetch_array($sonuc);    

    $sorgu = 'SELECT SUM(miktar) FROM aidat_miktar WHERE yil >= '. $uye['kayit_tarihi'];
    $sonuc = mysql_query($sorgu) or die(mysql_error());
    $toplam = mysql_fetch_row($sonuc);

    if($uye['kayit_tarihi'] <= 2002)    // 2002 ve oncesinde dernege 5 TL giris ucreti aliniyordu, ileriki yillarda bu uygulama kaldirildi
        $toplam[0] += 5;

    return $toplam[0];
}

function toplam_odedigi_aidat($uye_no)
{
    global $conn;

    mysql_select_db(DB,$conn);
    $sorgu = 'SELECT SUM(miktar) FROM odemeler WHERE uye_id = ' . $uye_no;
    $sonuc = mysql_query($sorgu) or die(mysql_error());
    $toplam = mysql_fetch_row($sonuc);

    return $toplam[0];
}

function toplam_aidat_borcu($uye_no)
{
    $borc = toplam_odemesi_gereken_aidat($uye_no) - toplam_odedigi_aidat($uye_no);

    if($borc > 0)
        return $borc;
    else
        return 0;
}

function csv_dosya_http_baslik_bilgilerini_gonder($dosya_adi)
{
    header('Pragma: public'); // required
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false); // required for certain browsers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $dosya_adi . '_' . date('dmY'). '.csv;');
    header('Content-Transfer-Encoding: binary');
}

function eposta2login($lkd_eposta)
{
    $parcalar = explode('@', $lkd_eposta);

    return $parcalar[0];
}

function aidat_miktari($yil)
{
    mysql_select_db(DB);

    $sorgu = 'SELECT miktar FROM aidat_miktar WHERE yil = '. $yil;
    $sonuc = mysql_query($sorgu) or die(mysql_error());
    $miktar = mysql_fetch_row($sonuc);

    return $miktar[0];
}

?>
