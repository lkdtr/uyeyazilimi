<?php
/*
    Aidat odemelerinin dokumunu csv ya da html biceminde verir.

    Parametrelerin alabilecekleri degerler:
        * bicem: html (ontanimli), csv
        * liste: tum (ontanimli), tum_odemesi_bulunan, duzenli_aidat, ilk_aidat, birikmis_aidat
            + tum: Aidat odemesi olsun ya da olmasin tum uyeler
            + tum_odemesi_bulunan: Yalniz aidat odemesi bulunan tum uyeler
            + duzenli_aidat: Yalniz bulunulan yil disinda aidat odemesi bulunmayan ve iki seneden uzun suredir uye olan
            + ilk_aidat: Yalniz bulunulan yil disinda aidat odemesi bulunmayan ve iki seneden kisa suredir uye olan (yani kayit olduktan sonra ilk kez aidat odeyecek)
            + birikmis_aidat: Yalniz birden fazla yila ait odemesi bulunan
*/

    require('ayarlar.inc.php');
    require('fonksiyonlar.inc.php');

    if($_GET['bicem'] == 'csv')
    {
        csv_dosya_http_baslik_bilgilerini_gonder($_GET['liste']);
	echo "Üye Numarası;Ad Soyad;Kullanıcı Adı;Kayıt Tarihi;Aidat Borcu;\n";
    }
    else    // ontanimli html cikti
    {
        echo "<html>\n" .
             ' <head><title>LKD Aidat Ödeme Listesi .:. ' . $_GET['liste'] . "</title>\n" .
             "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n" .
             " </head>\n" .
             "<body>\n";

        echo "<ul>\n" .
             " <li>Tüm (<a href=?liste=tum>HTML</a> | <a href=?liste=tum&bicem=csv>CSV</a>)</li>\n" .
             " <li>Tüm Aidat Borcu Olan (<a href=?liste=tum_odemesi_bulunan>HTML</a> | <a href=?liste=tum_odemesi_bulunan&bicem=csv>CSV</a>)</li>\n" .
             " <li>Düzenli Aidat Ödeyen (<a href=?liste=duzenli_aidat>HTML</a> | <a href=?liste=duzenli_aidat&bicem=csv>CSV</a>)<br><font size=-2>&nbsp;&nbsp;Bulunulan yıl dışında aidat ödemesi bulunmayan ve iki yıldan uzun süredir üye olan</font></li>\n" .
             " <li>Üyelik Sonrası İlk Kez Aidat Ödeyecek (<a href=?liste=ilk_aidat>HTML</a> | <a href=?liste=ilk_aidat&bicem=csv>CSV</a>)<br><font size=-2>&nbsp;&nbsp;Bulunulan yıl dışında aidat ödemesi bulunmayan ve iki yıldan az süredir üye olan</font></li>\n" .
             " <li>Birikmiş Aidat Borcu Olan (<a href=?liste=birikmis_aidat>HTML</a> | <a href=?liste=birikmis_aidat&bicem=csv>CSV</a>)<br><font size=-2>&nbsp;&nbsp;Birden fazla yıla ait aidat ödemesi bulunan</font></li>\n" .
             " </ul>\n";

        echo "<table bgcolor=\"#D6DDE7\" border=0 bgcolor=\"white\" cellpadding=3 cellspacing=1>\n" .
             " <tr bgcolor=\"#466176\">\n" .
             "  <td align=\"left\"><font color=\"#ffffff\">Ad Soyad</font></td>\n" .
             "  <td align=\"center\"><font color=\"#ffffff\">Üye Numarası</font></td>\n" .
             "  <td align=\"center\"><font color=\"#ffffff\">Kullanıcı Adı</font></td>\n" .
             "  <td align=\"center\"><font color=\"#ffffff\">Kayıt Tarihi</font></td>\n" .
             "  <td align=\"center\"><font color=\"#ffffff\">Aidat Borcu</font></td>\n" .
             " </tr>\n";

        $Renkler = array("#ffffff", "#f5f5f5"); // Tablonun okunmasi kolaylassin
    }

    // Veritabaniyla baglanti kurup uyelerin listesini alalim
    @mysql_connect(HOST, USER, PASS) or die("Bağlanti kurulamadı");
    @mysql_select_db(DB) or die("Veritabanı seçilemedi");
    mysql_query("SET NAMES 'utf8'");
    $sorgu = 'SELECT uye_id,uye_ad,uye_soyad,alias,kayit_tarihi FROM uyeler WHERE artik_uye_degil=0 ORDER BY uye_ad';
    $sonuc = mysql_query($sorgu) or die(mysql_error());

    $bu_yil = date('Y');
    $bu_yil_aidati = aidat_miktari($bu_yil);

    while($uye = mysql_fetch_array($sonuc))    // Siradan uyeleri isleyleim
    {
        $Renk = $Renkler[ ++$RenkSec%2 ];

        $lkd_login = eposta2login($uye['alias']);
        $borc = toplam_aidat_borcu($uye['uye_id']);
        $uyelik_yil_sayisi = $bu_yil - $uye['kayit_tarihi'] + 1;    // uyeliginin kacinci yili

        if($_GET['bicem'] == 'csv')
            $cikti =  $uye['uye_ad'] . ' ' . $uye['uye_soyad'] . ';' .
                      $uye['uye_id'] . ';' .
                      $lkd_login . ';' .
                      $uye['kayit_tarihi'] . ';' .
                      $borc . "\n";
        else
            $cikti = " <tr bgcolor=$Renk>\n" .
                     '  <td>' . $uye['uye_ad'] . ' ' . $uye['uye_soyad'] . "</td>\n" .
                     '  <td>' . $uye['uye_id'] . "</td>\n" .
                     "  <td>$lkd_login</td>\n" .
                     '  <td>' . $uye['kayit_tarihi'] . "</td>\n" .
                     '  <td>' . FormatCurrency($borc, 0, -2, -2, -2) .  "</td>\n" .
                     ' </tr>';

        switch($_GET['liste'])
        {
            case 'tum_odemesi_bulunan':
                if($borc > 0)
                    echo $cikti;
                break;
            case 'duzenli_aidat':
                if($borc > 0 && $borc <= $bu_yil_aidati && $uyelik_yil_sayisi > 2)
                    echo $cikti;
                break;
            case 'ilk_aidat':
                if($borc > 0 && $borc <= $bu_yil_aidati && $uyelik_yil_sayisi == 2)
                    echo $cikti;
                break;
            case 'birikmis_aidat':
                if($borc > $bu_yil_aidati)
                    echo $cikti;
                break;
            default:
                echo $cikti;
                break;
        }

    }    // hoop basa

    mysql_free_result($Sonuc);
    mysql_close($Baglanti);

    if($_GET['bicem'] != 'csv')
        echo "</table>\n</body>\n</html>"
?>
