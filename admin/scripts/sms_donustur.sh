#!/bin/bash
#
# CSV biceminde dosya (girdi.txt) alir, SMS gondermeye uygun bicemde geri verir
#
# ./sms_donustur.sh < girdi.txt olarak calistirilabilir
#
# girdi.txt ornegi :
# 128;Fiti;Fitican;fiti.fitican@linux.org.tr;2003;532xxxyyzz
#

rm -f sms_gondermeye_uygun_bicimde_liste.txt

MAXLEN=21

while read i
do
 NUMARA=`echo $i| cut -d\; -f1`
 AD=`echo $i| cut -d\; -f2`
 SOYAD=`echo $i| cut -d\; -f3`
 EPOSTA=`echo $i| cut -d\; -f4`
 KAYIT_YILI=`echo $i| cut -d\; -f5`
 TELEFON=`echo $i| cut -d\; -f6`

 ADSOYAD=$AD" "$SOYAD
 LEN=${#ADSOYAD}

 if [ "$LEN" -gt "$MAXLEN" ]; then
  echo "Dikkat! Uzun isimli insan --> $ADSOYAD"
 fi

 echo "'$TELEFON';'Sn $ADSOYAD,$NUMARA numaralı üyemiz olan sizden 7 aydır e-postayla geri dönüş alamıyoruz.Lütfen uye@lkd.org.tr adresine güncel bilgilerinizi iletiniz';'LKD Sizinle Iletisim Kurmaya Calisiyor'" >> sms_gondermeye_uygun_bicimde_liste.txt
done

 echo "Tamamlandi"
