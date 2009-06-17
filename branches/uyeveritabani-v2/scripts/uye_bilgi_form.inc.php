<?php
/*
 * lkd üye listesi ile ilgili fonksiyon 
 * form alanında karışıklık yaratmaması için fonksiyon olarak tanımladım
 */

    //liste üyelik durumu
    if($user_info['liste_uyeligi'] == 1)
    {
        $lo1 = "Selected";
        $lo2 = "";
    }
    else
    {
        $lo1 = "";
        $lo2 = "Selected";
    }

    //gönüllülük durumu
    if($user_info['gonullu']==1)
    {
        $go1 = "Selected";
        $go2 = "";
    }
    else
    {
        $go1 = "";
        $go2 = "Selected";

    }

    //kimlik durumu
    if($user_info['kimlik_gizli'] == 1)
    {
        $ko1 = "Selected";
        $ko2 = "";
    }
    else
    {
        $ko1 = "";
        $ko2 = "Selected";
    }

    //oylama durumu
    if($user_info['oylama'] == 1)
    {
        $oo1 = "Selected";
        $oo2 = "";
    }
    else
    {
        $oo1 = "";
        $oo2 = "Selected";
    }

    //trac durumu
    if($user_info['trac_listesi'] ==1)
    {
        $to1 = "Selected";
        $to2 = "";
    }
    else
    {
        $to1 = "";
        $to2 = "Selected";

    }

?>

    <table>
        <form action='uye_bilgi_duzenle.php' method="post">
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Üye Numarası</td>
            <td bgcolor="#F5F5F5"><?php echo $user_info['uye_id']; ?></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Adı Soyadı</td>
            <td bgcolor="#F5F5F5"><?php echo $user_info['uye_ad'] . ' ' . $user_info['uye_soyad']; ?></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">E-Posta Adresi</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_mail1' value='<?php echo $user_info['eposta1']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">E-Posta Adresi 2</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_mail2' value='<?php echo $user_info['eposta2']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Telefon 1</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_telefon1' value='<?php echo $user_info['Telefon1']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Telefon 2</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_telefon2' value='<?php echo $user_info['Telefon2']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Yaşadığı Şehir</td>
            <td bgcolor="#F5F5F5"><input type='text' name='txt_sehir' value='<?php echo $user_info['sehir']; ?>'/></td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">LKD Üye E-posta Listesi</td>
            <td bgcolor="#F5F5F5">
                <select name='txt_liste'>
                    <option value='1' <?php echo $lo1;?>>Üye</option>
                    <option value='0' <?php echo $lo2;?>>Üye Değil</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Gönüllü Çalışmalar</td>
            <td bgcolor="#F5F5F5">
                <select name='txt_gonullu'>
                    <option value='1' <?php echo $go1;?>>Katılmak İstiyor</option>
                    <option value='0' <?php echo $go2;?>>Katılmak İstemiyor</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Elektronik Oylamalar</td>
            <td bgcolor="#F5F5F5">
                <select name='txt_oylama'>
                    <option value='1' <?php echo $oo1;?>>Katılmak İstiyor</option>
                    <option value='0' <?php echo $oo2;?>>Katılmak İstemiyor</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">Trac Bildirim E-posta Listesi</td>
            <td bgcolor="#F5F5F5">
                <select name='txt_trac'>
                    <option value='1' <?php echo $to1;?>>Üye</option>
                    <option value='0' <?php echo $to2;?>>Üye Değil</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176"><font color="#FFFFFF">İsminin Gizli Kalmasını</td>
            <td bgcolor="#F5F5F5">
                <select name='txt_kimlik'>
                    <option value='1' <?php echo $ko1;?>>İstiyor</option>
                    <option value='0' <?php echo $ko2;?>>İstemiyor</option>
                </select>
            </td>
        </tr>
        <tr>
            <td bgcolor="#466176" colspan='2'><input type='submit' value='Değiştir'/></td>
        </tr>
        </form>
        <tr height="20"><td>&nbsp;</td></tr>
        <form action='uye_bilgi_parola_degistir.php' method='post'>
        <tr>
            <td>Yeni Parolanız</td>
            <td><input type='password' name='txt_parola1'/></td>
        </tr>
        <tr>
            <td>Yeni Parolanız (Tekrar)</td>
            <td><input type='password' name='txt_parola2'/></td>
        </tr>
        <tr>
            <td colspan='2'><input type='submit' value='Değiştir'/></td>
        </tr>
        </form>
    </table>
