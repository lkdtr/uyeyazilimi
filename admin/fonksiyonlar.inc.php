<?php
// Ortak kullanilan fonksiyonlar

require('fonksiyonlar_tarih.inc.php');

function eposta_yonlendirmesi_ac($lkd_eposta, $hedef_eposta)
{
    mysql_select_db(DB_MAIL);
    $sorgu = 'INSERT INTO forwardings VALUES("' . $lkd_eposta . '","' . $hedef_eposta . '")';
    mysql_query($sorgu) or die(mysql_error());
}

function trac_veritabanina_ekle($lkd_login, $ad, $soyad, $lkd_eposta)
{
    mysql_select_db(DB_TRAC);
    $sorgu = 'INSERT INTO session VALUES ("' . $lkd_login . '", 1, 0)';
    mysql_query($sorgu) or die(mysql_error());
    $sorgu = 'INSERT INTO session_attribute VALUES ("' . $lkd_login . '", 1, "name", "' . $ad . ' ' . $soyad . '"),
                                                    ("' . $lkd_login . '", 1, "email", "' . $lkd_eposta . '");';
    mysql_query($sorgu) or die(mysql_error());
}

function parola_veritabanina_ekle($uye_no, $lkd_login, $ad, $soyad, $lkd_eposta, $privilege)
{
    mysql_select_db(DB_PWD);
    $sorgu = 'INSERT INTO members (uye_no,name,lastname,lotr_alias,email,privilege)
                           VALUES  (' . $uye_no . ',"' . $ad . '","' . $soyad . '","' . $lkd_login . '","' . $lkd_eposta . '",' . $privilege . ')';
    mysql_query($sorgu) or die(mysql_error());
}

function ayrilma_bilgilerini_sifirla($uye_no)
{
    mysql_select_db(DB);
    $sorgu = 'UPDATE uyeler SET artik_uye_degil = 0, ayrilma_tarihi = "", Ayrilma_karar_no = "", Ayrilma_karar_tarih = "", kayit_kapanis_tarih = NULL WHERE uye_id = ' . $uye_no;
    mysql_query($sorgu) or die(mysql_error());
}

function toplam_odemesi_gereken_aidat($uye_no)
{
    // Duzelt beni: aidat_miktar tablosuna elle her yil aidat miktari eklenmesi gerekiyor. Ayrica gelecek yilin aidati eklenirse de fazladan hesapliyor. Bunun yerine sadece aidat degisimlerini tutmak, bir sonraki yil icin otomatik olarak son aidat miktarini hesaplamak daha iyi olur

    mysql_select_db(DB);

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
    mysql_select_db(DB);
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

function form_metin_kutusu_yap($label, $maxlength, $key, $var) {

    echo '
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">' . $label . '</font></td>
<td bgcolor="#F5F5F5"><input type="text" name="' . $key . '" size="30" maxlength="' . $maxlength . '" value="' . htmlspecialchars(@$var) . '"></td></tr>
';
}

function form_radyo_dugmesi_yap($label, $name, $selected, $parameters) {

    echo '
<tr>
<td bgcolor="#466176"><font color="#FFFFFF">' . $label . '</font></td>
<td bgcolor="#F5F5F5">';

$arraycount=0;
foreach ($parameters as $parameter => $value) {
    echo '
 <input type="radio" name="' . $name . '" '; if($arraycount == $selected) {echo 'checked ';}; echo 'value=' . $value . '>' . $parameter;
$arraycount++;
}
echo '
</td></tr>
';

}

function trac_veritabanindan_sil($lkd_login)
{
    mysql_select_db(DB_TRAC);

    $sorgu = 'DELETE FROM session_attribute WHERE sid = "' . $lkd_login . '"';
    mysql_query($sorgu) or die(mysql_error());
    $sorgu = 'DELETE FROM session WHERE sid = "' . $lkd_login . '"';
    mysql_query($sorgu) or die(mysql_error());
}

function parola_veritabanindan_sil($uye_no)
{
    mysql_select_db(DB_PWD);

    $sorgu = 'DELETE FROM members WHERE uye_no = ' . $uye_no;
    mysql_query($sorgu) or die(mysql_error());
}

function eposta_yonlendirmesi_sil($lkd_eposta)
{
    mysql_select_db(DB_MAIL);

    $sorgu = 'DELETE FROM forwardings WHERE source = "' . $lkd_eposta . '"';
    mysql_query($sorgu) or die(mysql_error());
}

function trac_veritabaninda_isim_degistir($lkd_login, $ad, $soyad)
{
    mysql_select_db(DB_TRAC);

    $sorgu = 'UPDATE session_attribute SET value = "' . $ad . ' ' . $soyad . '" WHERE sid = "' . $lkd_login . '" AND name = "name"';
    mysql_query($sorgu) or die(mysql_error());
}

function parola_veritabanini_guncelle($uye_no, $lkd_login, $ad, $soyad, $parola, $privilege)
{
    mysql_select_db(DB_PWD);

    $sorgu = 'UPDATE members SET lotr_alias = "' . $lkd_login . '", name = "' . $ad . '", lastname = "' . $soyad . '", privilege = ' . $privilege;
    if($parola)
        $sorgu .= ", password = $parola";
    $sorgu .= ' WHERE uye_no = ' . $uye_no;

    mysql_query($sorgu) or die(mysql_error());
}

function uye_hesabi_kapanis_zaman_damgasi_yaz($uye_no)
{
    mysql_select_db(DB);

    $sorgu = 'UPDATE uyeler SET artik_uye_degil = 1, kayit_kapanis_tarih = "' . date("Y-m-d H:i:s") . '" WHERE uye_id= '. $uye_no;
    mysql_query($sorgu) or die(mysql_error());
}

function eposta_yonlendirmesi_hedef_eposta_degistir($lkd_eposta, $hedef_eposta)
{
    mysql_select_db(DB_MAIL);

    $sorgu = 'UPDATE forwardings SET destination = "' . $hedef_eposta . '" WHERE source = "' . $lkd_eposta . '"';
    mysql_query($sorgu) or die(mysql_error());
}

function eposta_yonlendirmesi_lkd_eposta_degistir($lkd_eposta, $hedef_eposta)
{
    mysql_select_db(DB_MAIL);

    $sorgu = 'UPDATE forwardings SET source = "' . $lkd_eposta . '" WHERE destination = "' . $hedef_eposta . '"';
    mysql_query($sorgu) or die(mysql_error());
}

?>
