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

?>
