<?php
// Ortak kullanilan fonksiyonlar

require('fonksiyonlar_tarih.inc.php');

function veritabani_baglantisi_kur()
{
    @mysql_connect(HOST, USER, PASS) or die("Bağlanti kurulamadı");
    @mysql_select_db(DB) or die("Veritabanı seçilemedi");
    mysql_query("SET NAMES 'utf8'");
}

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

function html_basligi_yap($baslik)
{
    echo "<html>\n" .
         ' <head><title>' . $baslik . "</title>\n" .
         "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n" .
         " </head>\n" .
         "<body>\n";
}

function html_sonu_yap()
{
    echo "</html>\n" .
         '</body>';
}

function tablo_basligi_yap($dizi)
{
    echo '<div align="center"><center><table cellpadding="3" cellspacing="1" bgcolor="#d6dde7" border="0" width="100%"><tbody> <tr bgcolor="#466176">';

    foreach ($dizi as $i => $deger)
        echo '<td align="center"><font color="#ffffff"><u>' . $deger . '</u></font></td>' . "\n";

    echo '</tr>';
}

function tablo_satiri_yap($dizi, $renk_kodu)
{
    if($renk_kodu % 2)
        $renk = '#ffffff';
    else
        $renk = '#f5f5f5';

    echo '<tr bgcolor="' . $renk . '">';

    foreach ($dizi as $i => $deger)
        echo '<td align="center">' . $deger . '</td>' . "\n";

    echo '</tr>';
}

function tablo_sonu_yap()
{
    echo '</tbody></table></div></center>';
}

function uyeler_tablo_gosterimi($sonuc)
{
    global $UyeResimlerDizin;

    $sonuc_sayisi = mysql_num_rows($sonuc);

    tablo_basligi_yap(array('Üye No', 'Ad', 'Soyad', 'E-posta', 'Fotoğraf', 'Gör', 'Düzenle', 'Aidat'));
    while($sonuc_sayisi--)
    {
        $uye = mysql_fetch_array($sonuc);
        $resim = '<a href=' . $UyeResimlerDizin . '/' . $uye['Resim'] . '><img src=' . $UyeResimlerDizin . '/w150/' . $uye['Resim'] . ' height=16 border=0></a>';
        $duzenle = '<a href="uyeleredit.php?key=' . $uye['id'] . '"><img src="images/edit.gif" border="0"></a>';
        $gor = '<a href="uyelerview.php?key=' . $uye['id'] . '"><img src="images/browse.gif" border="0"></a>';
        $aidat = '<a href="odemelerlist.php?x_uye_id=' . $uye['uye_id'] . '"><img src="images/para.gif" border="0"></a>';
        tablo_satiri_yap(array($uye['uye_id'], $uye['uye_ad'], $uye['uye_soyad'], $uye['alias'], $resim, $gor, $duzenle, $aidat), $sonuc_sayisi);
    }
    tablo_sonu_yap();
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
    if($parola != 'NULL')
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

function trac_kullanici_adi_degistir($eski_lkd_login, $yeni_lkd_login)
{
    // Duzelt Beni: CC alanlarinin degistirilmesi -- ticket.cc || WHERE ticket_change.field = cc

    mysql_select_db(DB_TRAC);
    
    // ticket_change tablosu ozel ilgi ister
    $sorgu = 'UPDATE ticket_change SET oldvalue = "' . $yeni_lkd_login . '" WHERE field = "owner" AND oldvalue = "' . $eski_lkd_login . '";';
    mysql_query($sorgu) or die(mysql_error());
    $sorgu = 'UPDATE ticket_change SET newvalue = "' . $yeni_lkd_login . '" WHERE field = "owner" AND newvalue = "' . $eski_lkd_login . '";';
    mysql_query($sorgu) or die(mysql_error());

    // cc alanlari liste biciminde, baska kullanici adi/e-postalar da iceriyor
    $sorgu = 'UPDATE ticket SET cc = REPLACE("cc", "' . $eski_lkd_login .  '", "' . $yeni_lkd_login . '") WHERE cc LIKE "%' . $eski_lkd_login . '%";';
    mysql_query($sorgu) or die(mysql_error());

    // geri kalanlar
    $trac_guncellenecek_tablolar = array ( array ('attachment', 'author'),
                                   array ('component', 'owner'),
                                   array ('permission', 'username'),
                                   array ('revision', 'author'),
                                   array ('session', 'sid'),
                                   array ('session_attribute', 'sid'),
                                   array ('ticket', 'owner'),
                                   array ('ticket', 'reporter'),
                                   array ('ticket_change', 'author'),
                                   array ('wiki', 'author') );
    foreach ($trac_guncellenecek_tablolar as $tablo)
    {
        $sorgu = 'UPDATE ' . $tablo[0] . ' SET ' . $tablo[1] . ' = "' . $yeni_lkd_login . '" WHERE ' . $tablo[1] . ' = "' . $eski_lkd_login . '";';
        mysql_query($sorgu) or die(mysql_error());
    }
}

function trac_lkd_eposta_degistir($lkd_login, $lkd_eposta)
{
    mysql_select_db(DB_TRAC);

    $sorgu = 'UPDATE session_attribute SET value = "' . $lkd_eposta . '" WHERE sid = "' . $lkd_login . '" AND name = "email"';
    mysql_query($sorgu) or die(mysql_error());
}

?>
